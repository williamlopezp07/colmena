<?php
Route::group(['middleware' => 'auth'], function(){
	Route::prefix('consultas')
  // ->middleware('permission:Usuario')//
  ->namespace('Consultas')
  ->name('consultas.influencer.')
  ->group(function () {
		Route::get('influencer','ConsultasController@busquedaInfluencer')->name('busqueda');
		Route::post('influencer/pdf','ConsultasController@busquedaInfluencerPdf')->name('busqueda.pdf');
	});
	Route::prefix('consultas')
  // ->middleware('permission:Usuario')//
	->namespace('Consultas')
  ->name('consultas.actividades_mes.')
  ->group(function () {
		Route::get('actividades_mes','ConsultasController@ActividadesMes')->name('index');
	});

});
