<?php
Route::group(['middleware' => 'auth'], function(){
	Route::prefix('procesos')
  // ->middleware('permission:Usuario')//
  ->namespace('Procesos')
  ->name('procesos.cotizaciones.')
  ->group(function () {
		Route::get('cotizaciones','CotizacionController@index')->name('index');
		Route::post('cotizacion/create','CotizacionController@create')->name('create');
		Route::get('cotizacion/versionar','CotizacionController@versionar')->name('versionar');
		Route::get('cotizacion/mantenimiento','CotizacionController@mantenimiento')->name('mantenimiento');
    Route::get('cotizacion/edit','CotizacionController@edit')->name('edit');
		Route::post('cotizacion/createVersion','CotizacionController@createVersion')->name('createVersion');
		Route::post('cotizacion/update','CotizacionController@update')->name('update');
		Route::post('cotizacion/changeEjecutivo','CotizacionController@changeEjecutivo')->name('changeEjecutivo');
		Route::get('cotizacion/delete','CotizacionController@delete')->name('delete');
		Route::get('cotizacion/getVersiones','CotizacionController@getVersiones')->name('getVersiones');
		Route::get('cotizacion/getMetrica','CotizacionController@getMetrica')->name('getMetrica');
		Route::get('cotizacion/programar','CotizacionController@programar')->name('programar');
		Route::get('cotizacion/pdf','CotizacionController@pdf')->name('pdf');
		Route::get('cotizacion/excel_detalle','CotizacionController@excel_detalle')->name('excel_detalle');
		Route::get('cotizacion/excel/{f_inicio}/{f_fin}','CotizacionController@excel')->name('excel');
	});

	Route::prefix('procesos')
	// ->middleware('permission:Usuario')//
	->namespace('Procesos')
	->name('procesos.programacion.')
	->group(function () {
		Route::get('programacion','ProgramacionController@index')->name('index');
		Route::get('programacion/delete','ProgramacionController@delete')->name('delete');
		Route::POST('programacion/create','ProgramacionController@create')->name('create');
		Route::POST('programacion/update','ProgramacionController@update')->name('update');
		Route::POST('programacion/addAccion','ProgramacionController@addAccion')->name('addAccion');
		Route::POST('programacion/convertirAccion','ProgramacionController@convertirAccion')->name('convertirAccion');
		Route::post('programacion/changeEjecutivo','ProgramacionController@changeEjecutivo')->name('changeEjecutivo');
		Route::get('programacion/get','ProgramacionController@get')->name('get');
		Route::get('programacion/get_adjuntos','ProgramacionController@get_adjuntos')->name('get_adjuntos');
		Route::get('programacion/mantenimiento','ProgramacionController@mantenimiento')->name('mantenimiento');
		Route::get('programacion/edit','ProgramacionController@edit')->name('edit');
		Route::get('programacion/updateAccion','ProgramacionController@updateAccion')->name('updateAccion');
		Route::get('programacion/deleteAccion','ProgramacionController@deleteAccion')->name('deleteAccion');
		Route::get('programacion/cancelAccion','ProgramacionController@cancelAccion')->name('cancelAccion');
		Route::get('programacion/aprobacion_acciones','ProgramacionController@aprobacion')->name('aprobacion_acciones');
		Route::get('programacion/get_input_resultados','ProgramacionController@get_input_resultados')->name('get_input_resultados');
		Route::post('programacion/aprobar','ProgramacionController@aprobar')->name('aprobar');
		Route::get('programacion/diferenciaActiva','ProgramacionController@diferenciaActiva')->name('diferenciaActiva');
		Route::get('programacion/resultados/{id}','ProgramacionController@resultados')->name('resultados');
		Route::get('programacion/deleteArchivo','ProgramacionController@deleteArchivo')->name('deleteArchivo');
		Route::get('programacion/deleteEvidencia','ProgramacionController@deleteEvidencia')->name('deleteEvidencia');
	});

	Route::prefix('procesos')
	// ->middleware('permission:Usuario')//
	->namespace('Procesos')
	->name('procesos.comp_cobrar.')
	->group(function () {
		Route::get('comp_cobrar','ComprobanteCliController@index')->name('index');
		Route::get('comp_cobrar/getInfoProg','ComprobanteCliController@getInfoProg')->name('getInfoProg');
		Route::post('comp_cobrar/saveComprobante','ComprobanteCliController@saveComprobante')->name('saveComprobante');
		Route::post('comp_cobrar/pagarComprobante','ComprobanteCliController@pagarComprobante')->name('pagarComprobante');
		Route::get('comp_cobrar/mantenimiento','ComprobanteCliController@mantenimiento')->name('mantenimiento');
		Route::get('comp_cobrar/deleteComprobante','ComprobanteCliController@deleteComprobante')->name('deleteComprobante');
		Route::post('comp_cobrar/update','ComprobanteCliController@update')->name('update');
		Route::get('comp_cobrar/edit','ComprobanteCliController@edit')->name('edit');
		Route::get('comp_cobrar/getComprabanteSinNotaCredito','ComprobanteCliController@getComprabanteSinNotaCredito')->name('getComprabanteSinNotaCredito');
		Route::post('comp_cobrar/saveNotaCredito','ComprobanteCliController@saveNotaCredito')->name('saveNotaCredito');
		Route::get('comp_cobrar/getNotaCredito','ComprobanteCliController@getNotaCredito')->name('getNotaCredito');
		Route::get('comp_cobrar/deleteNC','ComprobanteCliController@deleteNC')->name('deleteNC');
		Route::get('comp_cobrar/editNC','ComprobanteCliController@editNC')->name('editNC');
		Route::get('comp_cobrar/fileRemoveNC','ComprobanteCliController@fileRemoveNC')->name('fileRemoveNC');
		Route::get('comp_cobrar/validar_ruc','ComprobanteCliController@validar_ruc')->name('validar_ruc');
	});

	Route::prefix('procesos')
	// ->middleware('permission:Usuario')//
	->namespace('Procesos')
	->name('procesos.comp_pagar.')
	->group(function () {
		Route::get('comp_pagar','ComprobanteProvController@index')->name('index');
		Route::get('comp_pagar/getActividades','ComprobanteProvController@getActividades')->name('getActividades');
		Route::post('comp_pagar/saveComprobante','ComprobanteProvController@saveComprobante')->name('saveComprobante');
		Route::post('comp_pagar/pagarComprobante','ComprobanteProvController@pagarComprobante')->name('pagarComprobante');
		Route::get('comp_pagar/mantenimiento','ComprobanteProvController@mantenimiento')->name('mantenimiento');
		Route::get('comp_pagar/deleteComprobante','ComprobanteProvController@deleteComprobante')->name('deleteComprobante');
		Route::get('comp_pagar/deletePago','ComprobanteProvController@deletePago')->name('deletePago');
		Route::post('comp_pagar/update','ComprobanteProvController@update')->name('update');
		Route::get('comp_pagar/edit','ComprobanteProvController@edit')->name('edit');
		Route::get('comp_pagar/infoPago','ComprobanteProvController@infoPago')->name('infoPago');
		Route::get('comp_pagar/getPagos','ComprobanteProvController@getPagos')->name('getPagos');
		Route::get('comp_pagar/sinComprobante','ComprobanteProvController@sinComprobante')->name('sinComprobante');
		Route::get('comp_pagar/validar_ruc','ComprobanteProvController@validar_ruc')->name('validar_ruc');
		Route::get('comp_pagar/validar_ruc_nc','ComprobanteProvController@validar_ruc_nc')->name('validar_ruc_nc');
		Route::get('comp_pagar/notas_credito','ComprobanteProvController@notas_credito')->name('notas_credito');
		Route::get('comp_pagar/getComprabanteSinNotaCredito','ComprobanteProvController@getComprabanteSinNotaCredito')->name('getComprabanteSinNotaCredito');
		Route::post('comp_pagar/saveNotaCredito','ComprobanteProvController@saveNotaCredito')->name('saveNotaCredito');
		Route::get('comp_pagar/getNotaCredito','ComprobanteProvController@getNotaCredito')->name('getNotaCredito');
		Route::get('comp_pagar/deleteNC','ComprobanteProvController@deleteNC')->name('deleteNC');
		Route::get('comp_pagar/editNC','ComprobanteProvController@editNC')->name('editNC');
		Route::get('comp_pagar/fileRemoveNC','ComprobanteProvController@fileRemoveNC')->name('fileRemoveNC');
	});
});
