<?php

namespace App\Http\Controllers;

use Validator;
use DB, View, Session, Request, Redirect, Response, App\Http\Models\organismosModel, App\Http\Models\camposModel;

class OrganismosController extends BaseController {

    public function obtenerOrganismosAll() {
        $organismos = organismosModel::select('ID', 'Tema', 'Institucion', 'Estado',
                'Direccion', 'Telefono', 'Email')->get()->toArray();
        return $this->cambiarComasSaltos($organismos);
    }

    /*
    Función que se encarga de cambiar las comas por <br>
    */
    public function cambiarComasSaltos($org) {
        for($i=0;$i<count($org); $i++) {
            $org[$i]['Tema'] = str_replace(',','<br>',$org[$i]['Tema']);
        }
        return $org;
    }

    /*
    Fuńcion que se encarga de regresar la lista paginada de organismos
    $num_pagina, la página a mostrar de los elementos
    $num_elementos: El número de elementos que se quiere regresar de la lista.
      Si el número es igual a cero, muestra todos los elementos
    */
    public function organismosPaginados($num_pagina,$num_elementos) {
        $lista_organismos = $this->obtenerOrganismosAll();
        if($num_elementos==0){
          return $lista_organismos;
        }
        $organismoPag = array_slice($lista_organismos,($num_pagina * $num_elementos),$num_elementos);
        return $organismoPag;
    }

    public function getIndex() {
        if (!parent::tienePermiso('Organismos')){
            return Redirect::to('inicio');
            }
        $menu = parent::createMenu();
        return View::make('organismos.organismos', array('menu' => $menu,
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

    public function obtenerOrganismos($datos){
        $whereStatement = [];
        if( isset($datos['tema']) && $datos['tema'] != '' ){
            $tema_busqueda='(Tema like "';
            foreach( explode(',', $datos['tema']) as $llave => $tema ){
                    $tema_busqueda.='%'.$tema;
            }
            $tema_busqueda.='")';
            $whereStatement[] = $tema_busqueda;
        }
        if( isset( $datos['objetivo'] ) && $datos['objetivo'] != '' ){
            $objetivo_bus = '(';
            $palabras = explode(' ', $datos['objetivo']);
            foreach( $palabras as $i => $palabra){
                if($palabra != ''){
                    if( $i == 0 ){
                        $objetivo_bus.=" Objetivo LIKE  '%".$palabra."%'";
                    } else {
                        $objetivo_bus.=" AND Objetivo LIKE  '%".$palabra."%'";
                    }
                }
            }
            $objetivo_bus .= ' )';
            //$objetivo_bus='Objetivo = "'.$datos['objetivo'].'"';
            $whereStatement[] = $objetivo_bus;
        }
        if( isset( $datos['institucion'] ) &&  $datos['institucion'] != '' ){
            $instituto_bus='Institucion like "%'.$datos['institucion'].'%"';
            $whereStatement[] = $instituto_bus;
        }
        if( isset( $datos['estado'] ) && $datos['estado'] != '-1' && $datos['estado']!='' ){
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
        $organismosArray = [];
        if($organismos){
            foreach( $organismos as $organismo ){
                $organismoArray = [];
                $organismoArray['ID'] = $organismo->ID;
                $organismoArray['Tema'] = $organismo->Tema;
                $organismoArray['Objetivo'] = $organismo->Objetivo;
                $organismoArray['Institucion'] = $organismo->Institucion;
                $organismoArray['Estado'] = $organismo->Estado;
                $organismoArray['Direccion'] = $organismo->Direccion;
                $organismoArray['Referencia'] = $organismo->Referencia;
                $organismoArray['Telefono'] = $organismo->Telefono;
                $organismoArray['Email'] = $organismo->Email;
                $organismosArray[] = $organismoArray;
            }
        } else {
            $organismoArray = array();
        }
        return $this->cambiarComasSaltos($organismosArray);
    }

    /*
    Función que se encarga de regresar la lista de organismos según el tamaño y
    el número de elementos solicitados (tamaño,num_elementos)
    */
    public function postOrganismosactuales() {
      if(!Request::ajax()) {
        return;
      }
      $data = Request::all();
      return $this->organismosPaginados($data["tamanio"],$data["num_elementos"]);
    }

    public function postBuscarorganismos(){
        if (!Request::ajax()) {
            return;
        }
        $datos = Request::all();
        $organismosArray = $this::obtenerOrganismos($datos);
        return $organismosArray;
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
            $organismo->Tema = $datos['Tema'];
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
            Session::flash('mensaje', 'Organismo Actualizado');
        } catch(\Exception $e){
            error_log($e->getMessage());
        }
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
