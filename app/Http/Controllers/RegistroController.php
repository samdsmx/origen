<?php

namespace App\Http\Controllers;

use Auth, View, Session, Request, Redirect, Response, App\Http\Models\catalogocpModel, App\Http\Models\camposModel, 
        Illuminate\Support\Facades\DB, App\Http\Models\casosModel, App\Http\Models\llamadasModel;

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
    
    public function postBuscardelegacion(){
        if( Request::ajax() ){
            $estado = Request::get('estado');
            return getDelegacionesArray($estado);
        }
    }
    
    public function postBuscarcolonia(){
        if( Request::ajax() ){
            $municipio = Request::get('municipio');
            $estado = Request::get('estado');
            return getColoniasArray($estado, $municipio);    
        }
    }
    
    public function postBuscarcodigopostal(){
        if( Request::ajax() ){
            $estado = Request::get('estado');
            $municipio = Request::get('municipio');
            $colonia = Request::get('colonia');
            return $this->buscarCodigoPostalPorCampos($estado, $municipio, $colonia);
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
            $cp = Request::get('cp');
            if( $cp == "" ){
                $direccion = array();
                $direccion['estado'] = 0;
                $direccion['municipio']=0;
                $direccion['asentamiento']=0;
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
    
    function postRegistrarllamada(){
        if( Request::ajax() ){
            $datos = Request::all();
            $caso = new casosModel();
            $caso->Nombre = $datos['nombre'];
            $caso->Edad = $datos['edad'];
            $caso->EstadoCivil = $datos['estadoCivil'];
            $caso->Telefono = $datos['telefono'];
            $caso->Municipio = $datos['Municipio'];
            $caso->Estado = $datos['Estado'];
            $caso->Ocupacion = $datos['ocupacion'];
            $caso->Religion = $datos['religion'];
            $caso->ComoTeEnteraste = $datos['enteraste'];
            $caso->PosibleSolucion = $datos['utilidad'];
            $caso->Estatus = '1';
            $caso->Sexo = $datos['genero'];
            $caso->NivelEstudios = $datos['estudios'];
            $caso->LenguaIndigena = $datos['lengua'];
            $caso->CP = $datos['cp'];
            $caso->Colonia = $datos['Colonia'];
            $caso->CorreoElectronico = $datos['correo'];
            $caso->MedioContacto = $datos['medioContacto'];
            $caso->Pais = 'Mexico';
            $caso->save();
            // Llamadas
            $llamada = new llamadasModel();
            $llamada->IDCaso = $caso->IDCaso;
            $llamada->LlamadaNo = 1;
            // Formateamos la hora
            $date = $datos['fechaActual'];
            $date = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3-$2-$1', $date);
            $llamada->FechaLlamada = $date;
            unset( $date );
            // Obtenemos el usuario
            $user = Auth::user();
            $llamada->Consejera = $user->nombre;
            unset( $user );
            $llamada->Horainicio = $datos['horaInicio'];
            $llamada->Horatermino = date("G:i:s");
            $llamada->ComentariosAdicionales = $datos['motivoLlamada'];
            $llamada->AyudaPsicologico = $datos['mpsicologico'];
            $llamada->AyudaLegal = $datos['mlegal'];
            $llamada->AyudaMedica = $datos['mmedico'];
            $llamada->AyudaOtros = $datos['motros'];
            $llamada->DesarrolloCaso = $datos['desaCaso'];
            $llamada->CanaLegal = $datos['canaLegal'];
            $llamada->CanaOtro = $datos['canaOtro'];
//            $llamada->Duracion = $datos['duracion'];
            $llamada->Acceso = 1;
            $llamada->TipoViolencia = $datos['tviolencia'];
            $llamada->ModalidadViolencia = $datos['modviolencia'];
            $llamada->save();
        }
    }
    

}
