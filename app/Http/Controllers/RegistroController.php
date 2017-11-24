<?php

namespace App\Http\Controllers;

use Auth, View, Session, Request, Redirect, Response, App\Http\Models\catalogocpModel, 
        Illuminate\Support\Facades\DB, App\Http\Models\casosModel, App\Http\Models\llamadasModel;
use App\Http\Controllers\OrganismosController;

class RegistroController extends BaseController {

    public function getIndex() {
        if (!parent::tienePermiso('Registro')){
            return Redirect::to('inicio');
        }
        $menu = parent::createMenu();
        return View::make('registro.registro', array('menu' => $menu, 'estados'=> getEstadosArray(), 
            'catalogo_tema' => parent::obtenerCampos('Tema'),
            'mpsicologicos' => parent::obtenerCampos('AYUDAPSICOLOGICO'),            
            'mlegales' => parent::obtenerCampos('AYUDALEGAL'),
            'mMed' => parent::obtenerCampos('AYUDAMEDICA'),
            'mOtr' => parent::obtenerCampos('AYUDAOTROS'),
            'tv' => parent::obtenerCampos('TipoViolencia'),
            'mv' => parent::obtenerCampos('ModalidadViolencia'), 
            'cte' => parent::obtenerCampos('ComoTeEnteraste'),
            'cleg' => parent::obtenerCampos('CanaLegal')));
    }
    
    public function postBuscardelegacion(){
        if( Request::ajax() ){
            $estado = Request::get('Estado');
            return getDelegacionesArray($estado);
        }
    }
    
    public function postBuscarcolonia(){
        if( Request::ajax() ){
            $municipio = Request::get('Municipio');
            $estado = Request::get('Estado');
            return getColoniasArray($estado, $municipio);    
        }
    }
    
    public function postBuscarcodigopostal(){
        if( Request::ajax() ){
            $estado = Request::get('Estado');
            $municipio = Request::get('Municipio');
            $colonia = Request::get('Colonia');
            return $this->buscarCodigoPostalPorCampos($estado, $municipio, $colonia);
        }
    }
    
    public function postBuscarorganismo(){
        if( Request::ajax() ){
            $datos = Request::all();
            $organismos = OrganismosController::obtenerOrganismos($datos);
            
        }
    }
    
    function buscarCodigoPostalPorCampos($estado="0", $municipio="0", $colonia="0"){
        $cp ='';
        if( $estado == "0" || $municipio == "0" || $colonia == "0" ){
            return "";
        }
        $busquedaCodigo = DB::table('catalogoCP')->select('cp')->where('estado', '=', $estado)->where('municipio', '=', $municipio)->where('colonia', '=', $colonia)->get();
        foreach ( $busquedaCodigo as $c ){
            // Suponemos que solo hay un codigo postal por cada colonia
            $cp = $c->cp;
        }
         return Response::json( $cp );
    }
    
    public function postBuscarcp(){
        if( Request::ajax() ){
            $cp = Request::get('CP');
            if( $cp == "" ){
                $direccion = array();
                $direccion['estado'] = 0;
                $direccion['municipio']=0;
                $direccion['colonia']=0;
                return Response::json($direccion);
            }
            $direccion = catalogocpModel::where('cp', '=', $cp)->get()->toArray();
            $direccion = $direccion[0];
            
            $direccion['estado'] = strtr($direccion['estado'], "áéíóú", "ÁÉÍÓÚ");
            $direccion['municipio'] = strtr($direccion['municipio'], "áéíóú", "ÁÉÍÓÚ");
            $direccion['colonia'] = strtr($direccion['colonia'], "áéíóú", "ÁÉÍÓÚ");
            
            $direccion['estado'] = strtoupper($direccion['estado']);
            $direccion['municipio'] = strtoupper($direccion['municipio']);
            $direccion['colonia'] = strtoupper($direccion['colonia']);
            
            if($direccion){
                return Response::json($direccion);
            }else{
                Session::flash('mensajeError', 'Error al buscar la direccion');
            }
        }
        return $direccion;
    }
    
    public function postRegistrarllamada(){
        if (!Request::ajax()) {
            return;
        }
        $datos = Request::all();
        $datos['motivos'] = isset($datos['AyudaPsicologico']) || isset($datos['AyudaLegal']) || isset($datos['AyudaMedica']) || isset($datos['AyudaOtros']);          
        $validatorCasos = casosModel::validar($datos);
        $validatorLlamadas = llamadasModel::validar($datos);
        if ($validatorCasos->fails() || $validatorLlamadas->fails()) {
            $errors = array_merge($validatorLlamadas->errors()->toArray() , $validatorCasos->errors()->toArray());
            return Response::json(array('mensaje'=> 'Error al procesar algunos campos' , 'errors' => $errors));
        }
        $duracion = ceil( explode(" ", $datos['duracion'])[0]/60 );

        $caso = new casosModel();
        $datos['Estatus'] = '1';
        $datos['HorasInvertidas'] = $duracion;
        $caso->fill($datos);
        $caso->save();

        $llamada = new llamadasModel();
        $llamada->IDCaso = $caso->IDCaso;
        $llamada->LlamadaNo = 1;
        $llamada->FechaLlamada = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3-$2-$1', $datos['fechaActual']);
        $llamada->Consejera = Auth::user()->nombre;
        $llamada->Horatermino = date("G:i:s");
        $llamada->Duracion = $duracion;
        $llamada->Acceso = 1;
        $llamada->fill($datos);
        $llamada->save();

        Session::flash('mensaje', 'Se ha registrado la llamada correctamente. Caso #'.$caso->IDCaso);
    }
    

}
