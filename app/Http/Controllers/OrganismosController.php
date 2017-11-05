<?php

namespace App\Http\Controllers;

use Validator;
use DB, View, Session, Request, Redirect, Response, App\Http\Models\organismosModel, App\Http\Models\camposModel;

class OrganismosController extends BaseController {
    
    public function obtenerOrganismosAll(){
        $organismos = organismosModel::select('ID', 'Tema', 'Institucion', 'Estado',
                'Direccion', 'Telefono', 'Email')->get();
        return $organismos;
    }
    
    public function getIndex() {
        if (!parent::tienePermiso('Organismos')){
            return Redirect::to('inicio');
            }
        $menu = parent::createMenu();
        return View::make('organismos.organismos', array('menu' => $menu, 
            'organismos' => $this->obtenerOrganismosAll(), 
            'estados' => getEstadosArray(), 
            'catalogo_tema' => parent::obtenerCampos('Tema')));
    }    
    
    public function postBuscarorganismo(){
        if (!Request::ajax()) {
            return;
        }
        $datos = Request::all();
        $organismo = organismosModel::find($datos['id']);
        return Response::json($organismo);
    }
    
    public function postBuscarorganismos(){
        if (!Request::ajax()) {
            return;
        }
        $whereStatement = [];
        $datos = Request::all();
        if( isset($datos['tema']) ){
            $tema_busqueda='(';
            foreach( explode('\n', $datos['tema']) as $llave => $tema ){
                if($llave == 0){
                    $tema_busqueda.=' Tema = "'.$datos['tema'].'" ';
                } else {
                    $tema_busqueda.=' OR Tema = "'.$datos['tema'].'" ';
                }
            }
            $tema_busqueda.=')';
            $whereStatement[] = $tema_busqueda;
        }
        if( isset( $datos['objetivo'] ) ){
            $objetivo_bus='Objetivo = "'.$datos['objetivo'].'"';
            $whereStatement[] = $objetivo_bus;
        }
        if( isset( $datos['institucion'] ) ){
            $instituto_bus='Institucion = "'.$datos['institucion'].'"';
            $whereStatement[] = $instituto_bus;
        }
        if( isset( $datos['estado'] ) ){
            $estado_bus='Estado = "'.$datos['estado'].'"';
            $whereStatement[] = $estado_bus;
        }
        $sql = 'SELECT * FROM organismos';
        foreach($whereStatement as $ind => $sta){
            if( $ind ==0 ){
                $sql.=' WHERE '.$sta.' ';
            } else {
                $sql.=' AND '.$sta.' ';
            }
        }
        $organismos = DB::select($sql);
        if($organismos){
            $view = View::make( 'organismos.organismos', array( 'menu' => [], 
                    'organismos' => $organismos, 
                    'estados' => getEstadosArray(), 
                    'catalogo_tema' => parent::obtenerCampos('Tema') ) );
            return $view->renderSections()['tableContent'];
        } else {
            return Redirect::to('Organismos')->with('mensajeError', 'Error al buscar organismos');
        }
        return;
    }
    
    public function postRegistraorganismo(){
        if( !Request::ajax() ){
            return;
        }
        $datos = Request::all();
        $validator = organismosModel::validar($datos);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->errors()->toArray()));
        }
        try{
            if( isset( $datos['ID'] ) ){
                $organismo = organismosModel::find( $datos['ID'] );
            } else {
                $organismo = new organismosModel();
            }
            $organismo->Tema = $datos["Tema"];
            $organismo->Objetivo = $datos["Objetivo"];
            $organismo->Institucion = $datos["Institucion"];
            $organismo->Estado = $datos["Estado"];
            $organismo->Direccion = $datos["Direccion"];
            $organismo->Referencia = $datos["Referencia"];
            $organismo->Telefono = $datos["Telefono"];
            $organismo->Email = $datos["Email"];
            $organismo->Observaciones = $datos["Observaciones"];
            $organismo->Requisitos = $datos["Requisitos"];
            $organismo->HorariosCostos = $datos["HorariosCostos"];
            
            $organismo->save();
        } catch(\Exception $e){
            error_log($e->getMessage());
        }
        Session::flash('mensaje', 'Organismo Actualizado');
    }
    
    public function postEliminarorganismo(){
        if( !Request::ajax() ){
            return;
        }
        $datos = Request::all();
        try{
            $organismo = organismosModel::find($datos['modalConfirmaId']);
            if( $organismo != null ){
                $organismo->delete();
            }
        } catch(\Exception $e){
            error_log($e->getMessage());
        }
        Session::flash('mensaje', 'Organismo Borrado');
        
    }
    
    
    
    

}
