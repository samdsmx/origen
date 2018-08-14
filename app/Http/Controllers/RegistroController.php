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
        $entradaCaso = Request::input('caso');
        $entradaLlamada = Request::input('llamada');
        $numeroCaso = ($entradaCaso != NULL)?$entradaCaso:0;
        $numeroLlamada = ($entradaLlamada != NULL)?$entradaLlamada:0;
        $datosLlamada = $this->obtenerLlamadas($numeroCaso,$numeroLlamada);
        if($datosLlamada == NULL) {
            $datosGenerales['nombre'] = '';
            $datosGenerales['edad'] = '';
            $datosGenerales['estadoCivil'] = '';
            $datosGenerales['genero'] = '';
            $datosGenerales['estudios'] = '';
            $datosGenerales['religion'] = '';
            $datosGenerales['lengua'] = '';
            $datosGenerales['ocupacion'] = '';
            $datosGenerales['vives'] = '';
            $datosGenerales['telefono'] = '';
            $datosGenerales['correoElectronico'] = '';
            $datosGenerales['medioContacto'] = '';
            $datosGenerales['comoTeEnteraste'] = '';
            $datosGenerales['Estatus'] = '';
        }else{
            $datosGenerales['nombre'] = $datosLlamada[0]->Nombre;
            $datosGenerales['edad'] = $datosLlamada[0]->Edad;
            $datosGenerales['estadoCivil'] = $datosLlamada[0]->EstadoCivil;
            $datosGenerales['genero'] = $datosLlamada[0]->Sexo;
            $datosGenerales['estudios'] = $datosLlamada[0]->NivelEstudios;
            $datosGenerales['religion'] = $datosLlamada[0]->Religion;
            $datosGenerales['lengua'] = $datosLlamada[0]->LenguaIndigena;
            $datosGenerales['ocupacion'] = $datosLlamada[0]->Ocupacion;
            $datosGenerales['vives'] = $datosLlamada[0]->VivesCon;
            $datosGenerales['telefono'] = $datosLlamada[0]->Telefono;
            $datosGenerales['correoElectronico'] = $datosLlamada[0]->CorreoElectronico;
            $datosGenerales['medioContacto'] = $datosLlamada[0]->MedioContacto;
            $datosGenerales['comoTeEnteraste'] = $datosLlamada[0]->ComoTeEnteraste;
            $datosGenerales['posibleSolucion'] = $datosLlamada[0]->PosibleSolucion;
            $datosGenerales['Estatus'] = $datosLlamada[0]->Estatus;
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
            'ocultarAgregar' => true,
            'numeroCaso' => $numeroCaso,
            'numeroLlamada' => $numeroLlamada,
            'datosGenerales' => $datosGenerales,
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

    public function postBuscarorganismos(){
        if (!Request::ajax()) {
            return;
        }
        $datos = Request::all();
        $organismosArray = app('App\Http\Controllers\OrganismosController')->obtenerOrganismos($datos);
        return $organismosArray;
    }


    function buscarCodigoPostalPorCampos($estado="0", $municipio="0", $colonia="0"){
        $cp ='';
        if( $estado == "0" || $municipio == "0" || $colonia == "0" ){
            return "";
        }
        $busquedaCodigo = DB::table('catalogocp')->select('cp')->where('estado', '=', $estado)->where('municipio', '=', $municipio)->where('colonia', '=', $colonia)->get();
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

        $numeroCaso = $datos['idCaso'];
        $numeroLlamada = 1;

        if($numeroCaso == 0){
            $caso = new casosModel();
            $datos['HorasInvertidas'] = $duracion;
            $caso->fill($datos);
            $caso->save();
            $numeroCaso = $caso->IDCaso;
        } else {
            $ultimaLlamada = DB::table('llamadas')
                            ->select('LlamadaNo')
                            ->where('IDCaso',$numeroCaso)
                            ->orderBy('LlamadaNo','desc')
                            ->take(1)
                            ->get();
            $numeroLlamada = ($ultimaLlamada[0]->LlamadaNo) + 1;
        }

        $llamada = new llamadasModel();
        $llamada->IDCaso = $numeroCaso;
        $llamada->LlamadaNo = $numeroLlamada;
        $llamada->FechaLlamada = preg_replace('#(\d{2})/(\d{2})/(\d{4})#', '$3-$2-$1', $datos['fechaActual']);
        $llamada->Consejera = Auth::user()->nombre;
        $llamada->Horatermino = date("G:i:s");
        $llamada->Duracion = $duracion;
        $llamada->Acceso = 1;
        $llamada->fill($datos);
        $llamada->save();

        Session::flash('mensaje', 'Se ha registrado la llamada correctamente. Caso #'.$numeroCaso);
    }

     public function obtenerLlamadas($nro_caso,$nro_llamada){
        if($nro_caso == 0) {
            return NULL;
        }
        if($nro_llamada == 0) {
            $nro_llamada = 1;
        }
 		$llamadas_casos = DB::table('llamadas')
						->join('casos','casos.IDCaso','=','llamadas.IDCaso')
						->join('consejeros','llamadas.Consejera','=','consejeros.nombre')
						->join('persona','consejeros.id_persona','=','persona.id_persona')
						->select('casos.*','llamadas.*')
                        ->select('casos.IDCaso','casos.Telefono','Horainicio',
                            'LlamadaNo','casos.Nombre','FechaLlamada','nombres',
                            'primer_apellido','segundo_apellido','casos.Edad',
                            'casos.EstadoCivil','casos.Sexo','casos.NivelEstudios',
                            'casos.Religion','casos.LenguaIndigena','casos.Ocupacion',
                            'casos.VivesCon','casos.Telefono','casos.CorreoElectronico',
                            'casos.MedioContacto','casos.ComoTeEnteraste', 
                            'casos.PosibleSolucion', 'casos.Estatus')
                        ->where('casos.IDCaso',$nro_caso)
                        ->where('llamadas.LlamadaNo',$nro_llamada)
                        ->get();
		return $llamadas_casos;
    }

}
