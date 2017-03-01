<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function() {
    if (Auth::guest()) {
        return Redirect::to('index');
    } else {
        return Redirect::to('inicio');
    }
});

Route::controller('index', 'GeneralController');
Route::post('login', array('uses' => 'AuthController@login'));
Route::post('recover', array('uses' => 'AuthController@recover'));

Route::group(array('before' => 'auth'), function() {
    Route::get('inicio', 'AuthController@inicio');
    Route::get('logout', 'AuthController@logout');
    Route::controller('Actividades', 'ActividadesController');
    Route::controller('PermisosUsuarios', 'PermisosUsuariosController');
    Route::controller('ActividadesUsuario', 'ActividadesUsuarioController');
    Route::controller('Propiedades', 'PropiedadesController');
    Route::controller('UnidadesResponsables', 'UnidadesResponsablesController');
    Route::controller('Consultas', 'ConsultasController');
    Route::controller('Reportes', 'ReportesController');
    Route::controller('MisSistemas', 'MisSistemasController');
    Route::controller('Periodos', 'PeriodosController');
    Route::controller('Grupos', 'GruposController');
    Route::get('CrearSistemaMio', 'MisSistemasController@crearSistema');
    Route::get('ActualizaMiSistema/{id}/{nombre}', 'MisSistemasController@actualizarSistema');
    Route::get('Ver/{id}', 'ConsultasController@verSistema');
});

function fechaLarga($fecha){
	$dividido = explode('-', $fecha);
	$dia = $dividido[2];
	$mes = $dividido[1];
	$ano = $dividido[0];
		if($mes == 01){
			$mes = "Enero";		
	}else if($mes == 02){
		$mes = "Febrero";
	}else if($mes == 03){
		$mes = "Marzo";		
	}else if($mes == 04){
		$mes = "Abril";			
	}else if($mes == 05){
		$mes = "Mayo";	
	}else if($mes == 06){
		$mes = "Junio";			
	}else if($mes == 07){
		$mes = "Julio";	
	}else if($mes == 08){
		$mes = "Agosto";
	}else if($mes == 09){
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
