<?php

namespace App\Http\Controllers;

use View, Session, Request, Redirect, Response, App\Http\Models\catalogocpModel, App\Http\Models\camposModel;

class RegistroController extends BaseController {

    function obtenerMPsicologicos(){
        $psi = camposModel::where([['activo', '=', '1'], ['Tipo', '=', 'AYUDAPSICOLOGICO' ]])->get()->toArray();
        return $psi;
    }
    
    function obtenerMLegal(){
        $leg = camposModel::where([['activo', '=', '1'], ['Tipo', '=', 'AYUDALEGAL' ]])->get()->toArray();
        return $leg;
    }
    
    function obtenerMMedico(){
        $med = camposModel::where([['activo', '=', '1'], ['Tipo', '=', 'AYUDAMEDICA' ]])->get()->toArray();
        return $med;
    }
    
    function obtenerMOtros(){
        $otr = camposModel::where([['activo', '=', '1'], ['Tipo', '=', 'AYUDAOTROS' ]])->get()->toArray();
        return $otr;
    }
    function obtenerTViolencia(){
        $tv = camposModel::where([['activo', '=', '1'], ['Tipo', '=', 'TipoViolencia' ]])->get()->toArray();
        return $tv;
    }
    //ModalidadViolencia
    function obtenerMViolencia(){
        $mv = camposModel::where([['activo', '=', '1'], ['Tipo', '=', 'ModalidadViolencia' ]])->get()->toArray();
        return $mv;
    }
    function obtenerCTEnteraste(){
        $cte = camposModel::where([['activo', '=', '1'], ['Tipo', '=', 'ComoTeEnteraste' ]])->get()->toArray();
        return $cte;
    }
    function obtenerCLegal(){
        $cte = camposModel::where([['activo', '=', '1'], ['Tipo', '=', 'CanaLegal' ]])->get()->toArray();
        return $cte;
    }
    
    public function getIndex() {
        if (!parent::tienePermiso('Registro')){
            return Redirect::to('inicio');
            }
        $menu = parent::createMenu();
        return View::make('registro.registro', array('menu' => $menu, 'estados'=> getEstadosArray(), 'mpsicologicos' => $this->obtenerMPsicologicos(),
            'mlegales' => $this->obtenerMLegal(), 'mMed' => $this->obtenerMMedico(), 'mOtr' => $this->obtenerMOtros(), 'tv' => $this->obtenerTViolencia(),
            'mv' => $this->obtenerMViolencia(), 'cte' => $this->obtenerCTEnteraste(), 'cleg' => $this->obtenerCLegal()));
    }    
    
    public function postBuscarcp(){
        if(Request::ajax()){
            $cp = Request::get('cp');
            error_log($cp);
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
    
    
    
    

}
