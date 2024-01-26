<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::middleware('auth')->get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::middleware('auth')->get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home.index');

Route::get('test',function(){
  // Permission::create(['name' => 'comp_pagar.index']);
  // Permission::create(['name' => 'comp_cobrar.index']);
  // Permission::create(['name' => 'comp_pagar.mantenimiento']);
  // Permission::create(['name' => 'comp_cobrar.mantenimiento']);
   // Role::create(['name' => 'Influencers']);
    $rol = Role::where('id',3)->first();
    // $user = User::where('id',39)->first();
    // $user->assignRole(4);
    // $user = User::where('id',27)->first();
    // $user->assignRole(4);
    // $user = User::where('id',28)->first();
    // $user->assignRole(4);
   $rol->givePermissionTo(20);
   // $rol->givePermissionTo(19);
   // $rol->givePermissionTo(20);
   // $rol->givePermissionTo(21);
});
Route::get('send-mail', function () {
    $data = DB::table('proder')->where('PDESTADO',1)->get();
    $details = [
        'title' => 'Mail from ItSolutionStuff.com',
        'body' => 'This is for testing email using smtp'
    ];

    \Mail::to('william.lopez@codrise.com')->send(new \App\Mail\MyTestMail($details));

    dd("Email is Sent.");
});

Route::get('count',function(){
  $numero = DB::table('prodet')->where('PDNUMDOC',1)->where('PDITEMCONVREF',1)->get()->count();
  dd($numero);
});

Route::get('clave_set',function(){
  // $usuarios = DB::table('users')->get();
  // foreach ($usuarios as $key) {
    DB::table('users')->where('id',22)->update(['password'=>Hash::make('admcolmena')]);
  // }
});

Route::get('pendientes',function(){

  $data = DB::table('prodet as d')
  ->selectRaw("d.PDDESCRI,d.PDGLOSA,DATE_FORMAT(d.PDFECPRO, '%d/%m/%Y') as PDFECPRO,
  c.PCNOMBRE,pc.producto,cp.campaña,d.PDINPUT,
  concat(u.nombre,' ',u.apepat ) as usuario_nom,
  TIMESTAMPDIFF(DAY, d.PDFECPRO, '".date('Y-m-d')."') AS dias_trascurridos")
  ->join("procab as c",function($join){
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
  // })->where('PDESTADO',1)->where('c.PCUSER','72474274')->get();
  })->where('PDESTADO',1);

  $rol = DB::table('model_has_roles')->where('model_id',Auth::user()->id)->value('role_id');
  if ($rol==3) {
    return $data->where('c.PCUSER',Auth::user()->documento)->get();
  } else {
    return $data->get();
  }

});


Route::get('pendientesFacturas',function(){

  return  DB::table('comdet as d')->selectRaw("
  DISTINCT c.id,mc.CNOMCLI,pc.producto,cp.campaña,c.destino,d.codigo, c.tipo_comprobante,
  c.comprobante,DATE_FORMAT(c.fecha,'%Y-%m-%d') as fecha,c.moneda,  c.monto, c.banco,c.adelanto,
  (select nro_cta_bancaria from influencers where influencer = (SELECT codigo FROM comdet where idcomcab=c.id LIMIT 1) LIMIT 1) as nro_cta_bancaria,
  c.ruc,DATE_FORMAT(c.fecha_pago,'%Y-%m-%d') as fecha_pago,
  TIMESTAMPDIFF(DAY, '".date('Y-m-d')."', c.fecha_pago) AS dias_trascurridos,
  prc.PCTIPCAM,c.estado
  ")->join("comcab as c",function($join){
    $join->on('c.id','=','d.idcomcab');
  })->join("maecli as mc",function($join){
    $join->on('mc.CCODCLI','=','d.cliente');
  })->leftJoin("productos_cliente as pc",function($join){
    $join->on('pc.id','=','d.producto');
  })->leftJoin("cronograma_producto as cp",function($join){
    $join->on('cp.id','=','d.campaña');
  })->join("procab as prc",function($join){
    $join->on('prc.id','=','c.docref');
  })
  ->where('c.estado',0)
  ->where('c.fecha_pago','=',date('Y-m-d'))
  ->get();

});

Route::get('notificar_correo',function(){
  $user_id = DB::table('model_has_roles')->where('role_id',3)->pluck('model_id');
  $users = DB::table('users')->whereIn('id',$user_id)->get();
  // dd($user_id);
  foreach ($users as $key) {
    $data = DB::table('prodet as d')
    ->selectRaw("d.PDDESCRI,d.PDGLOSA,DATE_FORMAT(d.PDFECPRO, '%d/%m/%Y') as PDFECPRO,
    c.PCNOMBRE,pc.producto,cp.campaña,d.PDINPUT,
    concat(u.nombre,' ',u.apepat ) as usuario_nom,
    TIMESTAMPDIFF(DAY, '".date('Y-m-d')."', d.PDFECPRO) AS dias_trascurridos")
    ->join("procab as c",function($join){
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
    // })->where('PDESTADO',1)->where('c.PCUSER','72474274')->get();
  })->where('PDESTADO',1)->where('c.PCUSER',$key->documento)->count();
    if ($data>0) {
      $details = [
          'to' => $key->email,
          // 'to' => 'william.lopez@codrise.com',
          'name' => $key->nombre,
          'subject' => 'Alerta de Acciones Pendientes'
      ];
      \Mail::to($details['to'])->send(new \App\Mail\MyTestMail($details));
    }
  }
  // \Mail::to('monica@colmenadigital.pe')->cc('william.lopezp93@gmail.com')->send(new \App\Mail\MyTestMail($details));
  // return dd(count($data));
});


Route::get('notificar_correo_facturas',function(){
  $user_id = DB::table('model_has_roles')->where('role_id',1)->pluck('model_id');
  $email = DB::table('users')->whereIn('id',$user_id)->pluck('email');
    $data = DB::table('comdet as d')->selectRaw("
    DISTINCT c.id,mc.CNOMCLI,pc.producto,cp.campaña,c.destino,d.codigo, c.tipo_comprobante,
    c.comprobante,DATE_FORMAT(c.fecha,'%Y-%m-%d') as fecha,c.moneda,  c.monto, c.banco,c.adelanto,
    (select nro_cta_bancaria from influencers where influencer = (SELECT codigo FROM comdet where idcomcab=c.id LIMIT 1) LIMIT 1) as nro_cta_bancaria,
    c.ruc,DATE_FORMAT(c.fecha_pago,'%Y-%m-%d') as fecha_pago,
    TIMESTAMPDIFF(DAY, c.fecha_pago, '".date('Y-m-d')."') AS dias_trascurridos,
    prc.PCTIPCAM,c.estado
    ")->join("comcab as c",function($join){
      $join->on('c.id','=','d.idcomcab');
    })->join("maecli as mc",function($join){
      $join->on('mc.CCODCLI','=','d.cliente');
    })->leftJoin("productos_cliente as pc",function($join){
      $join->on('pc.id','=','d.producto');
    })->leftJoin("cronograma_producto as cp",function($join){
      $join->on('cp.id','=','d.campaña');
    })->join("procab as prc",function($join){
      $join->on('prc.id','=','c.docref');
    })
    ->where('c.estado',0)
    ->where('c.fecha_pago','=',date('Y-m-d'))
    ->count();
    if ($data>0) {
      $details = [
        // 'to' => 'william.lopez@codrise.com',
        'subject' => 'Alerta de Facturas Pendientes'
      ];
      \Mail::to($email)->send(new \App\Mail\PendingInvoiceMail($details));
    }
  });

  Route::get('consultar_clientes',function(){
    $data = DB::select("SELECT u.id,u.usuario,u.documento,ap.producto_id,pc.email FROM `users` u inner join model_has_roles rm on rm.model_id=u.id inner join acceso_producto ap on ap.model_id=u.id inner join productos_cliente pc on pc.id=ap.producto_id where rm.role_id=4 and (u.usuario != pc.email or pc.email is null)");
    dd($data);
  // SELECT u.id,u.usuario,u.documento,ap.producto_id,pc.email FROM `users` u inner join model_has_roles rm on rm.model_id=u.id inner join acceso_producto ap on ap.model_id=u.id inner join productos_cliente pc on pc.id=ap.producto_id where rm.role_id=4 and (u.usuario != pc.email or pc.email is null)
});

Route::get('getRoles',function(){
  return  DB::table('roles')->get();
});

Route::get('getProductos',function(){
  try {

      return  DB::table('productos_cliente as pc')
        ->selectRaw("pc.id,pc.producto,c.CNOMCLI as cliente_name")
        ->join("maecli as c",function($join){
        $join->on('pc.cliente','=','c.CCODCLI');
      })->where('pc.estado',1)->get();
  } catch (\Exception $e) {
    return $e->getMessage();
  }

});
