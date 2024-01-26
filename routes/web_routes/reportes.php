<?php
Route::group(['middleware' => 'auth'], function(){
	Route::prefix('reportes')
  // ->middleware('permission:Usuario')//
  ->namespace('Reportes')
  ->name('reportes.ctaxpagar.')
  ->group(function () {
		Route::get('ctaxpagar','ReportesController@ctaxpagar')->name('index');
	});
  Route::prefix('reportes')
  // ->middleware('permission:Usuario')//
  ->namespace('Reportes')
  ->name('reportes.ctaxcobrar.')
  ->group(function () {
		Route::get('ctaxcobrar','ReportesController@ctaxcobrar')->name('index');
	});
  Route::prefix('reportes')
  // ->middleware('permission:Usuario')//
  ->namespace('Reportes')
  ->name('reportes.relacion_facturas.')
  ->group(function () {
		Route::get('relacion_facturas','ReportesController@relacion_facturas')->name('index');
	});
  Route::prefix('reportes')
  // ->middleware('permission:Usuario')//
  ->namespace('Reportes')
  ->name('reportes.actividades_pendientes.')
  ->group(function () {
		Route::get('actividades_pendientes','ReportesController@actividades_pendientes')->name('index');
	});
  Route::prefix('reportes')
  // ->middleware('permission:Usuario')//
  ->namespace('Reportes')
  ->name('reportes.resultados_cotizacion.')
  ->group(function () {
		Route::get('resultados_cotizacion','ReportesController@resultados_cotizacion')->name('index');
		Route::get('resultados_cotizacion/get_cotizaciones','ReportesController@get_cotizaciones')->name('get_cotizaciones');
		Route::get('resultados_cotizacion/get_resultados','ReportesController@get_resultados')->name('get_resultados');
	});
  Route::prefix('reportes')
  // ->middleware('permission:Usuario')//
  ->namespace('Reportes')
  ->name('reportes.progreso_campanas.')
  ->group(function () {
		Route::get('progreso_campanas','ReportesController@progreso_campanas')->name('index');
		Route::get('progreso_campanas/dashboard','ReportesController@progreso_campanas_dashboard')->name('dashboard');
		Route::get('progreso_campanas/table','ReportesController@progreso_campanas_table')->name('table');
		Route::get('progreso_campanas/tableval','ReportesController@progreso_campanas_table_val')->name('tableval');
		Route::get('progreso_campanas/resultados','ReportesController@resultados')->name('resultados');
		Route::get('progreso_campanas/resultados_filtrado_influencer','ReportesController@resultados_filtrado_influencer')->name('resultados_filtrado_influencer');
		Route::get('progreso_campanas/resultados_filtrado_publicidad','ReportesController@resultados_filtrado_publicidad')->name('resultados_filtrado_publicidad');
		Route::get('progreso_campanas/resultados_excel','ReportesController@get_resultados_excel')->name('resultados_excel');
	});


});
