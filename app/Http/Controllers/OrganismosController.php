<?php

namespace App\Http\Controllers;

use Validator;
use View, Session, Request, Redirect, Response, App\Http\Models\organismosModel, App\Http\Models\camposModel;

class OrganismosController extends BaseController {
    
    public function obtenerOrganismosAll(){
        $organismos = organismosModel::select('ID', 'Tema', 'Institucion', 'Estado',
                'Direccion', 'Telefono', 'Email')->get()->toArray();
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
            $organismo = new organismosModel();
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
