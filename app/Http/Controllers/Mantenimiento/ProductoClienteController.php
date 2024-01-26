<?php

namespace App\Http\Controllers\Mantenimiento;

use App\Http\Controllers\Controller;
use Auth;
use DB;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductoClienteController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
      if ($request->ajax()) {
        $result = DB::table('productos_cliente')->selectRaw("
          productos_cliente.*,
          maecli.CNOMCLI
        ")
        ->join('maecli',function($join){
          $join->on('productos_cliente.cliente','=','maecli.CCODCLI');
        })->get();

        return [
          'data' => $result
        ];
      }
      $data = [
        'title' => 'Producto de Clientes',
        'js' => 'mantenimiento/producto_cliente',
        'clientes' => Cliente::where('active',1)->get(),
      ];
        return view('mantenimiento.producto_cliente',$data);
    }

    public function store(Request $request)
    {
      try {
        $user = Auth::user();

          $data = [
            "producto" => mb_strtoupper($request->producto,'UTF-8'),
            "cliente" => $request->cliente,
            // "contacto" => mb_strtoupper($request->nom_contacto.' '.$request->apat_contacto.' '.$request->amat_contacto,'UTF-8'),
            "contacto" => mb_strtoupper($request->contacto,'UTF-8'),
            "email" => $request->email,
            "estado" => $request->estado,
            "usuario" => $user->nombre.' '.$user->apepat.' '.$user->apemat,
          ];
          if (IS_NULL($request->id)) {
            $id = DB::table('productos_cliente')->insert($data);
            // User::create([
            //     'nombre' => $request->nom_contacto.,
            //     'apepat' => $request->apat_contacto,
            //     'apemat' => $request->amat_contacto,
            //     'documento' => $data['documento'],
            //     'usuario' => $request->email,
            //     'email' => $request->email,
            //     'password' => Hash::make($data['password']),
            // ]);
          }else {
            DB::table('productos_cliente')->where('id',$request->id)->update($data);

            $id = $request->id;
          }
          $path = '';
          if($request->hasFile('logo')) {
             $file = $request->file('logo');
             $extension = $request->file('logo')->extension();
             $filename = 'logo_productos/'.$id.'/'.$file->getClientOriginalName();
             Storage::disk('space')->put($filename,file_get_contents($file), 'public');
             $path = Storage::disk('space')->url($filename);
             DB::table('productos_cliente')->where('id',$id)->update(['logo'=>$path]);
          }

          return [
            'title' => 'Buen Trabajo',
            'text' => IS_NULL($request->id) ? 'Se registró exitósamente el producto del cliente' : 'Se actualizó exitósamente el producto del cliente',
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
      return DB::table('productos_cliente')->where('id',$request->id)->first();
    }

    public function destroy(Request $request)
    {
      try {
        DB::table('productos_cliente')->where('id',$request->id)->update(['estado'=>0]);
        return [
          'title' => 'Buen Trabajo',
          'text' =>  'Se desactivó el producto',
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

    public function get_campana(Request $request){

      $data = DB::table('cronograma_producto')->selectRaw("
      id,campaña,predecesor,adjunto_comentarios,
         DATE_FORMAT(periodo, '%d-%m-%Y')  periodo,
            DATE_FORMAT(periodo_fin, '%d-%m-%Y')  periodo_fin,
        case
        WHEN DATEDIFF(periodo,NOW())>7 then '2'
        WHEN DATEDIFF(periodo,NOW())<=7 or DATEDIFF(periodo,NOW())>0  then '1'
        WHEN DATEDIFF(periodo,NOW())<=0  then '0' end condicion
      ")->where('producto',$request->producto)->orderBy('periodo','desc')->get();
      return [
        'data' => $data
      ];
    }

    public function storeCampaña(Request $request)
    {
      try {
        $user = Auth::user();
          $data = [
            "producto" => $request->id,
            "campaña" => mb_strtoupper($request->campaña,'UTF-8'),
            "usuario" => mb_strtoupper($user->nombre.' '.$user->apepat.' '.$user->apemat,'UTF-8'),
            "periodo" => date("Y-m-d",strtotime($request->mes)),
            "periodo_fin" => date("Y-m-d",strtotime($request->mes_fin)),
          ];
          DB::table('cronograma_producto')->insert($data);

          return [
            'title' => 'Buen Trabajo',
            'text' =>  'Se registró exitósamente la campaña',
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

    public function destroyCampaña(Request $request)
    {
      try {
        DB::table('cronograma_producto')->where('id',$request->id)->delete();
        return [
          'title' => 'Buen Trabajo',
          'text' =>  'Se eliminó la campaña del producto',
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

    public function cambiarCamPred(Request $request)
    {
        DB::table('cronograma_producto')->where('id',$request->id)->update(['predecesor'=>$request->valor]);
    }

    function cargarAdjCamp(Request $request)
    {
      try {
        $path = '';
        if($request->hasFile('adjunto_comentarios')) {
           $file = $request->file('adjunto_comentarios');
           $extension = $request->file('adjunto_comentarios')->extension();
           $filename = 'comentarios_campaña/'.$request->id.'/'.$request->id.".".$extension;
           Storage::disk('space')->put($filename,file_get_contents($file), 'public');
           $path = Storage::disk('space')->url($filename);
        }
        DB::table('cronograma_producto')->where('id',$request->id)->update(['adjunto_comentarios'=>$path]);
        return [
          'title' => 'Buen Trabajo',
          'text' =>  'Se cargo el archivo',
          'error' => null,
          'type' => 'success'
        ];
      }catch (\Exception $e) {
        return [
          'title' => 'Alerta',
          'text' => 'Hubo un error',
          'error' => $e->getMessage(),
          'type' => 'error'
        ];
      }
    }

    function eliminarAdjCamp(Request $request)
    {
      try {
        DB::table('cronograma_producto')->where('id',$request->id)->update(['adjunto_comentarios'=>null]);
          Storage::disk('space')->delete("{$request->url}");
        return [
          'title' => 'Buen Trabajo',
          'text' => 'Se eliminó el archivo de la campaña',
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
}
