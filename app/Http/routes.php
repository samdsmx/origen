<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    if (Auth::guest()) {
        return \Redirect::to('index');
    } else {
        return \Redirect::to('inicio');
    }
});

Route::controller('index', 'App\Http\Controllers\GeneralController');
Route::post('login', array('uses' => 'App\Http\Controllers\AuthController@login'));
Route::post('recover', array('uses' => 'App\Http\Controllers\AuthController@recover'));

Route::group(array('before' => 'auth'), function() {
    Route::get('inicio', 'App\Http\Controllers\AuthController@inicio');
    Route::get('logout', 'App\Http\Controllers\AuthController@logout');
    Route::controller('Actividades', 'App\Http\Controllers\ActividadesController');
    Route::controller('PermisosUsuarios', 'App\Http\Controllers\PermisosUsuariosController');
    Route::controller('ActividadesUsuario', 'App\Http\Controllers\ActividadesUsuarioController');
    Route::controller('Propiedades', 'App\Http\Controllers\PropiedadesController');
    Route::controller('UnidadesResponsables', 'App\Http\Controllers\UnidadesResponsablesController');
    Route::controller('Consultas', 'App\Http\Controllers\ConsultasController');
    Route::controller('Reportes', 'App\Http\Controllers\ReportesController');
    Route::controller('MisSistemas', 'App\Http\Controllers\MisSistemasController');
    Route::controller('Periodos', 'App\Http\Controllers\PeriodosController');
    Route::controller('Grupos', 'App\Http\Controllers\GruposController');
	Route::controller('Registro', 'App\Http\Controllers\RegistroController');

    Route::get('CrearSistemaMio', 'App\Http\Controllers\MisSistemasController@crearSistema');
    Route::get('ActualizaMiSistema/{id}/{nombre}', 'App\Http\Controllers\MisSistemasController@actualizarSistema');
    Route::get('Ver/{id}', 'App\Http\Controllers\ConsultasController@verSistema');
});

function fechaLarga($fecha){
	$dividido = explode('-', $fecha);
	$dia = $dividido[2];
	$mes = $dividido[1];
	$ano = $dividido[0];
	if($mes == 1){
		$mes = "Enero";		
	}else if($mes == 2){
		$mes = "Febrero";
	}else if($mes == 3){
		$mes = "Marzo";		
	}else if($mes == 4){
		$mes = "Abril";			
	}else if($mes == 5){
		$mes = "Mayo";	
	}else if($mes == 6){
		$mes = "Junio";			
	}else if($mes == 7){
		$mes = "Julio";	
	}else if($mes == 8){
		$mes = "Agosto";
	}else if($mes == 9){
		$mes = "Septiembre";	
	}else if($mes == 10){
		$mes = "Octubre";	
	}else if($mes == 11){
		$mes = "Noviembre";	
	}else if($mes == 12){
		$mes = "Diciembre";	
	}
	return $dia." de ".$mes." ".$ano;
}