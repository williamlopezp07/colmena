<?php

namespace App\Http\Controllers\Mantenimiento;

use App\Http\Controllers\Controller;
use App\Models\Influencer;
use App\Models\CategoriaRedSocial;
use App\Models\Accion;
use App\Models\RedSocial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DB;
use Auth;
use Excel;
use App\Exports\ExportMetricas;

class InfluencerController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $result = Influencer::selectRaw("
        influencers.*,
        acciones.descripcion influencer_descripcion,
        acciones.codigo influencer_codigo
      ")->rightJoin('acciones',function($join){
        $join->on('acciones.codigo','=','influencers.influencer');
      })->where('acciones.estado',1)->where('acciones.tipo',1)->get();
      return [
        'data' => $result
      ];
    }
    $data = [
      'title' => 'Influencers',
      'js' => 'mantenimiento/influencer',
      'categorias' => CategoriaRedSocial::where('estado',1)->orderBy('descripcion','asc')->get(),
      'influencers' => Accion::where('estado',1)->where('tipo',1)->get(),
    ];
      return view('mantenimiento.influencer',$data);
  }

  public function store(Request $request)
  {
    try {
      $user = Auth::user();
      $path = '';
      if($request->hasFile('influencer_foto')) {
         $file = $request->file('influencer_foto');
         $extension = $request->file('influencer_foto')->extension();
         $filename = 'profile/'.$request->influencer.".".$extension;
         Storage::disk('space')->put($filename,file_get_contents($file), 'public');
         $path = Storage::disk('space')->url($filename);
      }
      $data = [
        'influencer' => $request->influencer,
        "representacion" => $request->representacion,
        "exclusividad_agencia" => $request->exclusividad_agencia,
        "celular" => $request->celular,
        "correo" => $request->correo,
        "ciudad" => $request->ciudad,
        "persona_contacto" => $request->persona_contacto,
        "categorias" =>  $request->categorias,
        "ruc" =>  $request->ruc,
        "banco" =>  $request->banco,
        "nro_cta_bancaria" =>  $request->nro_cta_bancaria,
        "banco_usd" =>  $request->banco_usd,
        "nro_cta_bancaria_usd" =>  $request->nro_cta_bancaria_usd,
        // "moneda_cta_bancaria" =>  $request->moneda_cta_bancaria,
        "nro_cta_detraccion" =>  $request->nro_cta_detraccion,
        "moneda_cta_detraccion" =>  $request->moneda_cta_detraccion,
        "usuario" => $user->nombre.' '.$user->apepat.' '.$user->apemat,
      ];
      if (Influencer::where('influencer',$request->influencer)->first()) {
        Influencer::where('influencer',$request->influencer)->update($data);
      }else {
        Influencer::insert($data);
      }
      if($request->hasFile('influencer_foto')!='') {
        Influencer::where('influencer',$request->influencer)->update(['foto' => $path]);
      }

      return [
        'title' => 'Buen Trabajo',
        'text' =>  'Se actualizó exitósamente los datos del influencers',
        'error' => null,
        'type' => 'success'
      ];
    } catch (\Exception $e) {
      return [
        'title' => 'Alerta',
        'text' => 'Hubo un error',
        'error' => $e->getMessage(),
        'type' => 'error'
      ];
    }
  }

 public function edit(Request $request)
 {
   return Influencer::selectRaw("
     influencers.*,
     acciones.descripcion influencer_descripcion,
     acciones.codigo influencer_codigo
   ")->rightJoin('acciones',function($join){
     $join->on('acciones.codigo','=','influencers.influencer');
   })->where('acciones.estado',1)->where('acciones.codigo',$request->id)->first();
 }

  public function editMetrica(Request $request)
  {
    try {
      $metricas = Influencer::selectRaw("
        acciones.codigo influencer_codigo,
        influencers.metricas
      ")->rightJoin('acciones',function($join){
        $join->on('acciones.codigo','=','influencers.influencer');
      })->where('acciones.estado',1)->where('acciones.codigo',$request->id)->first();
      $metricas_form = RedSocial::where('estado',1)->get();

      $data = [
        'metricas_influencer' => $metricas,
        'influencer_cod' => $request->id,
        'metricas_form' => $metricas_form,
      ];
      return  view('mantenimiento.influencer.metricas',$data);
    } catch (\Exception $e) {
      return $e->getMessage();
    }
  }
  public function storeMetrica(Request $request)
  {
    try {
      $user = Auth::user();

      $data = [
        'influencer' => $request->influencer,
        "metricas" => $request->metricasArray,
        "usuario" => $user->nombre.' '.$user->apepat.' '.$user->apemat,
      ];
      $influencer = Influencer::where('influencer',$request->influencer)->first();
      if (isset($influencer)) {
        if ($influencer->metricas!='') {
          $data_influencer = [
            'influencer' => $influencer->influencer,
            'metricas' => $influencer->metricas,
            'usuario' => $influencer->usuario,
            'fecha' => $influencer->updated_at
          ];
          DB::table('historial_influencer_metricas')->insert($data_influencer);
        }
        Influencer::where('influencer',$request->influencer)->update($data);
      }else {
        Influencer::insert($data);
      }


      return [
        'title' => 'Buen Trabajo',
        'text' =>  'Se actualizó exitósamente las métricas del influencers',
        'error' => null,
        'type' => 'success'
      ];
    } catch (\Exception $e) {
      return [
        'title' => 'Alerta',
        'text' => 'Hubo un error',
        'error' => $e->getMessage(),
        'type' => 'error'
      ];
    }
  }
  public function getInfoAccion(Request $request)
  {
    return  Influencer::selectRaw("
        influencers.*
      ")->rightJoin('acciones',function($join){
        $join->on('acciones.codigo','=','influencers.influencer');
      })->where('acciones.estado',1)->where('acciones.codigo',$request->valor)->first();
  }
  public function historialMetrica(Request $request)
  {
    $result =  DB::table("historial_influencer_metricas")->where('influencer',$request->influencer)->orderBy('fecha','desc')->get();
    return [
      'data' => $result
    ];
  }

  public function getHistorialMetrica(Request $request){
    $metricas_form = RedSocial::where('estado',1)->get();
    $data = [
      'metricas_influencer'=>DB::table('historial_influencer_metricas')->where('id',$request->id)->first(),
      'metricas_form' => $metricas_form,
    ];
    // dd($data['metricas_influencer']);
    return  view('mantenimiento.influencer.metricasHistorial',$data);
  }

  public function ExportMetrica(Request $request,$codigo ,$red_social){
    date_default_timezone_set("America/Lima");
    // $codigo = '_isaterrones';
    // $red_social = 'instagram';
    $metricas_valores = RedSocial::selectRaw('json,json_tarifario,json_demografica')->where('red_social',$red_social)->first();
    $metricas_influencer = json_decode(Influencer::where('influencer',$codigo)->value('metricas'));
    $found=[];
      foreach ($metricas_influencer as $key) {
          if (($key[0]->red_social)==$red_social) {
            array_push($found, $key[0]->metricas);
          }
      }

      $header = [];
      $data = [];
      foreach (json_decode($metricas_valores->json) as $key) {
        array_push($header, $key->descripcion);
        foreach ($found[0] as $row) {
          if ($row->input==$key->input) {
            array_push($data, $row->valor);
          }
        }
      }
      foreach (json_decode($metricas_valores->json_demografica) as $key) {
        array_push($header, $key->descripcion);
        foreach ($found[0] as $row) {
          if ($row->input==$key->input) {
            array_push($data, $row->valor);
          }
        }
      }
      foreach (json_decode($metricas_valores->json_tarifario) as $key) {
        array_push($header, $key->descripcion);
        foreach ($found[0] as $row) {
          if ($row->input==$key->input) {
            array_push($data, $row->valor);
          }
        }
      }
      $num_metricas = [count(json_decode($metricas_valores->json)),count(json_decode($metricas_valores->json_demografica)),count(json_decode($metricas_valores->json_tarifario))];
    $date = date('Y-m-d_H-i-s');
    $nombre = $date . "__Metricas_Influencer_".$red_social.".xlsx";

    return Excel::Download(new ExportMetricas($header, $data,$num_metricas), $nombre);
  }

  function getHistorialCampaña(Request $request)
  {
    $data = DB::table('prodet as d')->selectRaw("
      c.PCNOMBRE,pc.producto,cp.campaña,PDGLOSA,DATE_FORMAT(PDFECPRO,'%d-%m-%Y') as PDFECPRO,FORMAT(PDPRETAR,2) PDPRETAR,FORMAT(PDPREUNIT,2) PDPREUNIT,PDMONEDA
    ")->join('procab as c',function($join){
      $join->on('c.ID','=','d.PDNUMDOC');
    })->join('productos_cliente as pc',function($join){
      $join->on('pc.id','=','d.PDPRODUCTO');
    })->join('cronograma_producto as cp',function($join){
      $join->on('cp.id','=','d.PDCAMPAÑA');
    })->where('PDCODIGO',$request->influencer)
    ->whereIn('PDESTADO',[1,3])
    ->orderBy('PDFECPRO','desc')
    ->get();

    return [
      'data' => $data
    ];
  }
}
