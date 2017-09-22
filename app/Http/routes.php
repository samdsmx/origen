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

// Funcion de carga de catalogo estados
function getEstadosArray(){
    $states = DB::table('catalogoCP')->select('estado')->groupby('estado')->get();
    $estados = array();
    foreach($states as $estado){
        $estados[ strtoupper( strtr( $estado->estado, "áéíóú", "ÁÉÍÓÚ" ) ) ] = strtoupper( strtr( $estado->estado, "áéíóú", "ÁÉÍÓÚ" ) );
    }
    $estados["EXTRANJERO"] = "EXTRANJERO";
    return $estados;
}
function getDelegacionesArray( $estado="0" ){
    if ( $estado == "0" ) {
        $municipios = DB::table('catalogoCP')->distinct()->select('municipio')->groupby('municipio')->get();
    } else {
        $municipios = DB::table('catalogoCP')->distinct()->select('municipio')->where('estado', '=', $estado)->groupby('municipio')->get();
    }
    $delegaciones = array();
    foreach ($municipios as $m){
        $delegaciones[ strtoupper( strtr( $m->municipio, "áéíóú", "ÁÉÍÓÚ" ) ) ] = strtoupper( strtr( $m->municipio, "áéíóú", "ÁÉÍÓÚ" ) );
    }
    return $delegaciones;
}

function getColoniasArray( $estado="0", $delegacion="0" ){
    if( $delegacion == "0" && $estado == "0" ){
        $cols = DB::table('catalogoCP')->distinct()->select('colonia')->groupby('colonia')->get();
    } else if( $estado != "0" && $delegacion != "0" ){
        $cols = DB::table('catalogoCP')->distinct()->select('colonia')->where('estado', '=', $estado)->where('municipio', '=', $delegacion)->groupby('colonia')->get();
    } else {
        return array();
    }
    $colonias = array();
    foreach( $cols as $c ){
        $colonias[ strtoupper( strtr( $c->colonia, "áéíóú", "ÁÉÍÓÚ" ) ) ] = strtoupper( strtr( $c->colonia, "áéíóú", "ÁÉÍÓÚ" ) );
    }
    return $colonias;
}

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
    Route::controller('UnidadesResponsables', 'App\Http\Controllers\UnidadesResponsablesController');
    Route::controller('Consultas', 'App\Http\Controllers\ConsultasController');
    Route::controller('Reportes', 'App\Http\Controllers\ReportesController');
    Route::controller('Grupos', 'App\Http\Controllers\GruposController');
    Route::controller('Registro', 'App\Http\Controllers\RegistroController');
    Route::controller('Organismos', 'App\Http\Controllers\OrganismosController');

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
