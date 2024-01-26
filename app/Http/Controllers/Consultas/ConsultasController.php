<?php
namespace App\Http\Controllers\Consultas;

use App\Http\Controllers\Controller;
use App\Models\Influencer;
use App\Models\CategoriaRedSocial;
use App\Models\RedSocial;
use Illuminate\Http\Request;
use Auth;
use DB;
use Illuminate\Support\Facades\Storage;
use Dompdf\Dompdf;

class ConsultasController extends Controller
{
  function busquedaInfluencer(Request $request){
    if ($request->ajax()) {
      try {
        $influencers = Influencer::selectRaw("
          influencers.*,
          acciones.descripcion influencer_descripcion,
          (SELECT PDRESULTADOS FROM prodet where PDCODIGO = influencers.influencer and PDRESULTADOS is not null and PDINPUT='tarifa_reel' AND PDREDSOCIAL='instagram' order by PDFECPRO desc limit 1) as er_reel,
          (SELECT PDRESULTADOS FROM prodet where PDCODIGO = influencers.influencer and PDRESULTADOS is not null and PDINPUT='tarifa_video' AND PDREDSOCIAL='tiktok' order by PDFECPRO desc limit 1) as er_video,
          acciones.codigo influencer_codigo
        ")->rightJoin('acciones',function($join){
          $join->on('acciones.codigo','=','influencers.influencer');
        })->where('acciones.estado',1)->where('acciones.tipo',1)->get();
        $categorias = CategoriaRedSocial::selectRaw('id,descripcion')->where('estado',1)->get();
        $red_social = RedSocial::where('estado',1)->get();
          $data = [
            'influencers' => $influencers,
            'categorias' => $categorias,
            'red_social' => $red_social
          ];
          return $data;
      } catch (\Exception $e) {
          return $e->getMessage();
      }

    }

    $data = [
      'title' => 'Busqueda de Influencer',
      'js' => 'consultas/busqueda_influencer',
    ];
    return view('consultas/busqueda_influencer',$data);
  }

  function ActividadesMes(Request $request){
    if ($request->ajax()) {
        $result = DB::table("procab as c")->selectRaw("
        c.ID,
        c.PCUSER,
        d.PDGLOSA,
        concat(d.PDDESCRI,' - ',c.PCNOMBRE) title,
        d.PDFECPRO start,
        d.PDFECPRO end,
        d.PDSECUEN,
        d.PDCODIGO,
        d.PDESTADO,
        d.PDOBSERVACIONES,
        pc.producto,
        cp.campaña,
        d.PDPREUNIT,
        d.PDPRETAR,
        d.PDINPUT,
        d.PDREDSOCIAL,
        a.descripcion as nom_acciones,
        date_format(d.PDFECPRO, '%Y-%m-%d') PDFECPRO,
        case when PDMONEDA='USD' THEN 'DOLARES' ELSE 'SOLES' END precio,
        concat(u.nombre,' ',u.apepat,' ',u.apemat) as usuario_nom,
        TIMESTAMPDIFF(DAY ,NOW(), d.PDFECPRO) AS dias_pendiente,
        case
          WHEN PDESTADO = 0 THEN (
            case
              when TIMESTAMPDIFF(DAY ,NOW(), d.PDFECPRO) < 0 then '#FF7D7B'
              when TIMESTAMPDIFF(DAY ,NOW(), d.PDFECPRO) >= 0 and TIMESTAMPDIFF(DAY,NOW(), d.PDFECPRO ) < 7 then '#FFF17B'
              when TIMESTAMPDIFF(DAY ,NOW(), d.PDFECPRO) >=7 then '#A9FF7B' end
            )
          WHEN PDESTADO = 1 THEN '#7B95FF'
          WHEN PDESTADO = 2 THEN '#000000' END AS color,
          case
            WHEN PDESTADO = 0 THEN 'PENDIENTE'
            WHEN PDESTADO = 1 THEN 'CUMPLIDO'
            WHEN PDESTADO = 2 THEN 'CANCELADO'
            WHEN PDESTADO = 3 THEN 'CERRADO' END AS PDESTADOINFO
        ")->join("prodet as d",function($join){
          $join->on('d.PDNUMDOC','=','c.ID');
        })
        ->join("users as u",function($join){
          $join->on('u.documento','=','c.PCUSER');
        })
        ->leftJoin('cronograma_producto as cp',function($join){
          $join->on('cp.id','=','d.PDCAMPAÑA');
        })
        ->join('productos_cliente as pc',function($join){
          $join->on('pc.id','=','PDPRODUCTO');
        })
        ->join('acciones as a',function($join){
          $join->on('a.codigo','=','PDCODIGO');
        })
        ->whereMonth("d.PDFECPRO",date('m',strtotime($request->mes)))
        ->whereYear("d.PDFECPRO",date('Y',strtotime($request->mes)))
        ->whereNotIn("d.PDESTADO",[99])
        ->where("c.PCESTADO","!=",4);
        if ($request->ejecutivo=='ALL') {
          $data = $result->get();
        }else {
          $data = $result->where("c.PCUSER","=",$request->ejecutivo)->get();
        }
        $data = [
          'data' => $data,
          'mes' => $request->mes,
        ];
        return view('consultas/table/actividades_mes',$data);
    }
    $users = DB::table('model_has_roles')->where('role_id',3)->pluck('model_id');
    $ejecutivos = DB::table('users')->whereIn('id',$users)->get();
    $data = [
      'title' => 'Actividades del Mes',
      'js' => 'consultas/actividades_mes',
      'ejecutivos' => $ejecutivos
    ];
    return view('consultas/actividades_mes',$data);
    }

    public function busquedaInfluencerPdf(Request $request)
    {
      $items=[];
      foreach ($request->items as $key => $value) {
        $items[] = $value;
      }
      $influencers = Influencer::selectRaw("
      influencers.*,
      acciones.descripcion influencer_descripcion,
      acciones.codigo influencer_codigo
      ")->rightJoin('acciones',function($join){
        $join->on('acciones.codigo','=','influencers.influencer');
      })->where('acciones.estado',1)->whereIn('influencers.influencer',$items)->get();

      $categorias = CategoriaRedSocial::where('estado',1)->get();
      $data = [
        'influencers' => $influencers,
        'categorias' => $categorias,
        'red_social' => $request->red_social,
      ];

      $dompdf = new Dompdf();
      $html = view('consultas/pdf/busqueda_influencer',$data);
      $dompdf->loadHtml($html);
      $dompdf->setPaper('A4','landscape');
      $dompdf->set_option('enable_remote', TRUE);
      $dompdf->render();
      $output = $dompdf->output();
      $path  = date('YmdHis').'.pdf';
      Storage::disk('space')->put($path, $output, 'public' );
      return Storage::disk('space')->url($path);
    }
}
