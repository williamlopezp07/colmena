<?php
namespace App\Http\Controllers\Mantenimiento;

use App\Http\Controllers\Controller;
use App\Models\Accion;
use Illuminate\Http\Request;
use Auth;

class AccionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

  public function index(Request $request)
    {
      if ($request->ajax()) {
        $result = Accion::get();

        return [
          'data' => $result
        ];
      }
      $data = [
        'title' => 'Acciones (Servicios/Influencers)',
        'js' => 'mantenimiento/accion'
      ];
        return view('mantenimiento.accion',$data);
    }

    public function store(Request $request)
    {
        try {
          $user = Auth::user();
          $data = [
            'codigo' => $request->codigo,
            "descripcion" => $request->descripcion,
            "tipo" => $request->tipo,
            "usuario" => $user->nombre.' '.$user->apepat.' '.$user->apemat,
            "estado" => $request->estado,
          ];
          Accion::updateOrCreate([
            'id' => $request->id
          ],  $data);

          return [
            'title' => 'Buen Trabajo',
            'text' => IS_NULL($request->codigo) ? 'Se registró exitósamente la accion' : 'Se actualizó exitósamente la accion',
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
      return Accion::where('id',$request->id)->first();
    }
    public function update(Request $request, Accion $accion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Accion  $accion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
      try {
        Accion::where('id',$request->id)->update(['estado'=>0]);
        return [
          'title' => 'Buen Trabajo',
          'text' =>  'Se desactivó la accion',
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
   public function validar_accion(Request $request)
   {
       return Accion::where('codigo',$request->codigo)->count();
   }

   public function getCodigo(Request $request)
   {
     $codigo = Accion::where('tipo',2)->orderBy('codigo','DESC')->value('codigo');
     $codigo_asignado = (isset($codigo)) ? (ltrim($codigo, '0') + 1) : 1 ;

     return str_pad($codigo_asignado,10,"0",STR_PAD_LEFT);
   }
}
