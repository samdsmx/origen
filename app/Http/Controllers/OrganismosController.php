<?php

namespace App\Http\Controllers;

use Validator;
use View, Session, Request, Redirect, Response, App\Http\Models\organismosModel, App\Http\Models\camposModel;

class OrganismosController extends BaseController {
    
    function obtenerTema(){
        $ctema = camposModel::where([['activo', '=', '1'], ['Tipo', '=', 'Tema' ]])->get()->toArray();
        return $ctema;
    }

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
            'catalogo_tema' => $this->obtenerTema()));
    }    
    
    public function postBuscarcp(){
        if(Request::ajax()){
            $cp = Request::get('cp');
            $direccion = catalogocpModel::where('cp', '=', $cp)->get()->toArray();
            $direccion = $direccion[0];
            
            $direccion['estado'] = strtr($direccion['estado'], "áéíóú", "ÁÉÍÓÚ");
            $direccion['municipio'] = strtr($direccion['municipio'], "áéíóú", "ÁÉÍÓÚ");
            $direccion['asentamiento'] = strtr($direccion['asentamiento'], "áéíóú", "ÁÉÍÓÚ");
            
            $direccion['estado'] = strtoupper($direccion['estado']);
            $direccion['municipio'] = strtoupper($direccion['municipio']);
            $direccion['asentamiento'] = strtoupper($direccion['asentamiento']);
            
            if($direccion){
                return Response::json($direccion);
            }else{
                Session::flash('mensajeError', 'Error al buscar la direccion');
            }
        }
        return $direccion;
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
            $organismo->Tema = $datos["tema"];
            $organismo->Objetivo = $datos["objetivo"];
            $organismo->Institucion = $datos["institucion"];
            $organismo->Estado = $datos["estado"];
            $organismo->Direccion = $datos["direccion"];
            $organismo->Referencia = $datos["referencia"];
            $organismo->Telefono = $datos["telefono"];
            $organismo->Email = $datos["email"];
            $organismo->Observaciones = $datos["observaciones"];
            $organismo->Requisitos = $datos["requisitos"];
            $organismo->HorariosCostos = $datos["hycostos"];
            
            $organismo->save();
            
        } catch(\Exception $e){
            error_log($e->getMessage());
        }
        
        Session::flash('mensaje', 'Organismo Actualizado');
        
    }
    
    
    
    

}
