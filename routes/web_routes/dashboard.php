<?php
Route::group(['middleware' => 'auth'], function(){
	Route::prefix('dashboard')
  // ->middleware('permission:Usuario')//
  ->namespace('Dashboard')
  ->name('dashboard.cotizaciones.')
  ->group(function () {
		Route::get('cotizaciones','DashboardController@index')->name('index');
	});

  Route::prefix('dashboard')
  // ->middleware('permission:Usuario')//
  ->namespace('Dashboard')
  ->name('dashboard.programaciones.')
  ->group(function () {
		Route::get('programaciones','DashboardController@programaciones')->name('index');
	});

  Route::prefix('dashboard')
  // ->middleware('permission:Usuario')//
  ->namespace('Dashboard')
  ->name('dashboard.clientes.')
  ->group(function () {
		Route::get('clientes','DashboardController@clientes')->name('index');
	});

  Route::prefix('dashboard')
  // ->middleware('permission:Usuario')//
  ->namespace('Dashboard')
  ->name('dashboard.influencers.')
  ->group(function () {
		Route::get('influencers','DashboardController@influencers')->name('index');
	});

  Route::prefix('dashboard')
  // ->middleware('permission:Usuario')//
  ->namespace('Dashboard')
  ->name('dashboard.top_influencers.')
  ->group(function () {
		Route::get('top_influencers','DashboardController@top_influencers')->name('index');
		Route::get('top_influencers/getFiltros','DashboardController@getFiltros')->name('getFiltros');
		Route::get('top_influencers/getCampañas','DashboardController@getCampañas')->name('getCampañas');
	});

});
