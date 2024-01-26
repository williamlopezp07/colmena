<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;
use Auth;
use DB;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    // protected function authenticated()
    // {
    //     Auth::logoutOtherDevices(request('password'));
    // }
    public function login(){
     $email = request('email');
     $password = request('password');
     $user= User::where('email',$email)->first();
     if( $user ){//El email ingresado existe
       if( $user->activo == 1 ){ //Si active es igual a 1
         $credentials = $this->validate(request(),[
           'email'=> 'required|string',
           'password'=> 'required|string'
         ]);
         if( Auth::attempt($credentials)){
           $productos = DB::table('acceso_producto')->selectRaw("
           pc.id,pc.producto
           ")
           ->join('productos_cliente as pc',function($join){
             $join->on('pc.id','=','producto_id');
           })
           ->where('model_id',$user->id)->get();
           if (isset($productos)) {
             session(['productos' => ($productos)]);
           }
           return redirect()->intended('home');
           // $user = Auth::getProvider()->retrieveByCredentials($credentials);
           //  return $this->authenticated($request, $user);
         }
         return back()->withInput()->withErrors(['email'=>'Las credenciales ingresadas son incorrectas']);
       }else{
          return back()->withInput()->withErrors(['email'=>'El email ingresado se encuentra Inactivo']);
       }
     }else{ //El email ingresado no existe
         return back()->withInput()->withErrors(['email'=>'El email ingresado no esta registrado en nuestra plataforma.']);
     }
   }
}
