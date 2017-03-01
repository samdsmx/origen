<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MisSistemasController
 *
 * @author Sergio Marquez
 */
class MisSistemasController extends BaseController {

    public function getIndex() {
        if (!parent::tienePermiso(8)) {
            return Redirect::to('inicio');
        }
        $menu = parent::createMenu();
        $periodo = siaPeriodoModel::where('status', '=', 1)->orderBy('fecha_inicio', 'desc')->first();
        $dentroDelPeriodo = !($periodo == null || strtotime("now") < strtotime($periodo->fecha_inicio) || strtotime("now") > strtotime($periodo->fecha_fin));
        $sistemas = DB::select('select T2.*, p.comentarios periodo, asp.id_observacion, asp.nota, o.descripcion observacion, r.valor Sistema, r2.valor nombreCompleto, asp.id_sistema_periodo
            from (select s.id_sistema, s.id_fase, s.status, f.descripcion fase, max(asp.id_periodo) id_periodo
                from sia_sistema s, sia_aso_persona_sistema ps, sia_aso_sistema_periodo asp, sia_cat_fase f
                where f.id_fase = s.id_fase and asp.id_sistema = s.id_sistema and s.id_sistema = ps.id_sistema and ps.id_persona = ' .  Auth::user()->persona->id_persona  /*11*/  .
                       ' group by id_sistema) T2,
            sia_periodo p, sia_observacion o, sia_aso_sistema_periodo asp
            LEFT JOIN sia_respuesta r on r.id_sistema_periodo = asp.id_sistema_periodo and r.id_propiedad = 6
            LEFT JOIN sia_respuesta r2 on r2.id_sistema_periodo = asp.id_sistema_periodo and r2.id_propiedad = 5
            where T2.id_periodo = p.id_periodo and asp.id_sistema=T2.id_sistema and asp.id_periodo = T2.id_periodo and o.id_observacion = asp.id_observacion');
        return View::make('missistemas.missistemas', array('menu' => $menu, "sistemas" => $sistemas, "dentroPeriodo" => $dentroDelPeriodo, "idPeriodoActual" => $periodo->id_periodo));
    }

    public function construyePregunta($i, $prop, $res = "") {
        $arrayRes = array_flip(array_map('strtolower', explode(';', $res)));
        $arreglo = array("id" => $prop->id_propiedad, "pregunta" => $prop->descripcion, "obligatorio" => $prop->obligatoria, "expresion" => $prop->expresion, "num" => $i, "campo" => "");
        $porDefault = siaRespuestaPredefinidaModel::select('id_respuesta_predefinida', 'valor', 'status')->where('status', '=', 1)->where('id_propiedad', '=', $prop->id_propiedad)->get()->toArray();
        $firmaGen = "onchange='detectaCambio($prop->id_propiedad);' name='inputQ" . $prop->id_propiedad . "' id='inputQ" . $prop->id_propiedad . "'";
        switch ($prop->id_tipo) {
            case 1:
                $arreglo["campo"] = "<input " . $firmaGen . " type='text' class='elemento' value='" . (strlen($res) ? $res : (sizeof($porDefault) ? $porDefault[0]["valor"] : "")) . "' style='width:100%;' />";
                break;
            case 2:
                $arreglo["campo"] = "<select " . $firmaGen . " class='chosen-select, elemento' tabindex='-1' style='width:100%;' data-placeholder='-- Selecciona un elemento --'>";
                $arreglo["campo"].="<option value=''></option>";
                foreach ($porDefault as $opcion) {
                    $arreglo["campo"].="<option value='" . $opcion["valor"] . "'" . (($opcion["valor"] == $res) ? " selected" : "") . ">" . $opcion["valor"] . "</option>";
                }
                $arreglo["campo"].="</select>";
                break;
            case 3:
                foreach ($porDefault as $ind => $opcion) {
                    $arreglo["campo"] .= "<input " . substr($firmaGen, 0, -1) . "(" . $ind . ")'" . " type='radio' class='elemento' value='" . $opcion["valor"] . "'" . ((array_key_exists(strtolower($opcion["valor"]), $arrayRes)) ? " checked" : "") . " style='margin-left:20px; margin-right:5px;vertical-align: top;' />" . $opcion["valor"];
                }
                break;
            case 4:
                $firmaGen = "onchange='detectaCambio($prop->id_propiedad);' name='inputQ" . $prop->id_propiedad . "'";
                foreach ($porDefault as $ind => $opcion) {
                    $arreglo["campo"] .= "<input " . substr($firmaGen, 0, -1) . "(" . $ind . ")' " . "id='inputQ" . $prop->id_propiedad . "(" . $ind . ")'" . " type='checkbox' class='elemento' value='" . $opcion["valor"] . "'" . ((array_key_exists(strtolower($opcion["valor"]), $arrayRes)) ? " checked" : "") . " style='margin-left:20px; margin-right:5px;vertical-align: top;' />" . $opcion["valor"] . "<br/>";
                }
                break;
            case 5:
                $arreglo["campo"] = "<textarea  " . $firmaGen . " class='elemento' style='width:100%;' >" . (strlen($res) ? $res : (sizeof($porDefault) ? $porDefault[0]["valor"] : "")) . "</textarea>";
                break;
            case 6:
                $arreglo["campo"] = "<input " . $firmaGen . " type='date' class='elemento' value='" . (strlen($res) ? date('Y-m-d', strtotime(str_replace('/', '-', $res))) : (sizeof($porDefault) ? date('Y-m-d', strtotime(str_replace('/', '-', $porDefault[0]["valor"]))) : "")) . "' style='width:100%; height: 25px;' />";
                break;
        }
        return $arreglo;
    }

    public function crearSistema() {
        $menu = parent::createMenu();
        $grupos = siaGrupoModel::select('id_grupo', 'grupo')->where('status', '=', 1)->orderBy('orden', 'asc')->orderBy('id_grupo', 'asc')->get()->toArray();
        $pantalla = array();
        foreach ($grupos as $gru) {
            $pantalla[$gru["grupo"]] = array();
        }
        $preguntas = DB::select('select p.*, g.grupo, t.tipo, r.expresion '
                        . 'from sia_cat_grupo g, sia_cat_tipo t, sia_cat_propiedad p '
                        . 'LEFT OUTER JOIN sia_cat_reglas r on r.id_propiedad_dependiente = p.id_propiedad '
                        . 'where p.id_grupo = g.id_grupo and t.id_tipo = p.id_tipo and p.status = 1 '
                        . 'order by -g.orden DESC, g.grupo ASC, -p.orden DESC, p.id_propiedad ASC');
        foreach ($preguntas as $ind => $prop) {
            $pantalla[$prop->grupo][] = self::construyePregunta($ind + 1, $prop);
        }
        $sistemaPeriodo = new siaAsoSistemaPeriodoModel();
        return View::make('missistemas.nuevos', array('menu' => $menu, 'pantallas' => $pantalla, 'grupos' => $grupos, 'sp' => $sistemaPeriodo, 'nombre' => "Nuevo Sistema", 'active_group' => $grupos[0]["grupo"]));
    }

    public function actualizarSistema($id, $nombre) {
        $menu = parent::createMenu();
        $sistema = siaSistemaModel::find($id);
        $sistemaPeriodo = parent::apuntaPeriodoActual($sistema);
        $secciones = parent::obtieneRespuestas($sistemaPeriodo->id_sistema_periodo);
        $preguntas = DB::select('select p.*, g.grupo, t.tipo, r.expresion '
                        . 'from sia_cat_grupo g, sia_cat_tipo t, sia_cat_propiedad p '
                        . 'LEFT OUTER JOIN sia_cat_reglas r on r.id_propiedad_dependiente = p.id_propiedad '
                        . 'where p.id_grupo = g.id_grupo and t.id_tipo = p.id_tipo and p.status = 1 '
                        . 'order by -g.orden DESC, g.grupo ASC, -p.orden DESC, p.id_propiedad ASC');
        $pantalla = array();
        foreach ($preguntas as $ind => $prop) {
            $res = isset($secciones[$prop->grupo][$prop->id_propiedad]["res"]) ? $secciones[$prop->grupo][$prop->id_propiedad]["res"] : "";
            $pantalla[$prop->grupo][] = self::construyePregunta($ind + 1, $prop, $res);
        }
        $grupos = siaGrupoModel::select('id_grupo', 'grupo')->where('status', '=', 1)->orderBy('orden', 'asc')->orderBy('grupo', 'asc')->get();
        return View::make('missistemas.nuevos', array('menu' => $menu, 'pantallas' => $pantalla, 'grupos' => $grupos, 'sp' => $sistemaPeriodo,  'nombre' => $nombre, 'active_group' => $grupos[0]["grupo"]));
    }
    
    public function postTermina() {
        if (!Request::ajax()) {
            return;
        }
        $datos = Input::all();
        $sistema = siaSistemaModel::find($datos["Id"]);
        if ($sistema->id_fase == 1 || $sistema->id_fase == 3){
            $sistema->id_fase++;
            $sistema->save();
            }
        $sistemaPeriodo = parent::apuntaPeriodoActual($sistema);            
        $sistemaPeriodo->id_observacion = (strcmp($sistemaPeriodo->nota,"Con cambios")==0)?3:1;
        $sistemaPeriodo->save();
        Session::flash('mensaje', 'Registrado completo');
        self::getIndex();
    }
    
    public function guardaRespuestas(&$sistemaPeriodo, &$respuestas, &$secciones, &$tipo){
        $grupo = siaGrupoModel::select('id_grupo', 'grupo')->where('grupo', '=', $tipo)->first();
        $conCambio=false;
        foreach ($respuestas as $key => $respuesta) {
            $id_propiedad=substr($key,6);
            if (isset($secciones[$grupo->grupo][$id_propiedad]["res"])){
                $res = siaRespuestaModel::find($secciones[$grupo->grupo][$id_propiedad]["id_respuesta"]);
                }
            else{
                $res = new siaRespuestaModel($sistemaPeriodo->id_sistema_periodo, Auth::user()->persona->id_persona, $id_propiedad);    
                }
            if(strcmp($respuesta, $res->valor)!=0){
                $res->valor = $respuesta;    
                $res->save();
                $conCambio=true;
            }
        }
        if ($conCambio){
            $sistemaPeriodo->nota = "Con cambios";
            $sistemaPeriodo->save();
            }        
    }

    public function postRegistra() {
        if (!Request::ajax()) {
            return;
        }
        $datos = Input::all();
        $respuestas=array();
        $validator = siaRespuestaModel::validar($datos["res"], $datos["obl"], $respuestas);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->errors()->toArray()));
        }
        if (intval($datos["Id"]) == 0) {
            $sistema = new siaSistemaModel(1);
            $sistema->save();
            $perSis = new siaAsoPersonaSistemaModel($sistema->id_sistema, Auth::user()->persona->id_persona);
            $perSis->save(); 
            $sistemaPeriodo = parent::apuntaPeriodoActual($sistema);
            $secciones=array();
        } else {
            $sistema = siaSistemaModel::find($datos["Id"]);
            $sistemaPeriodo = parent::apuntaPeriodoActual($sistema);
            $secciones = parent::obtieneRespuestas($sistemaPeriodo->id_sistema_periodo);
        }
        self::guardaRespuestas($sistemaPeriodo, $respuestas, $secciones, $datos["Tipo"]);
        $grupo = siaGrupoModel::select('id_grupo', 'grupo')->where('grupo', '=', $datos["Tipo"])->first();
	$grupoSiguiente = siaGrupoModel::select('id_grupo', 'grupo')->where('id_grupo', '>', $grupo->id_grupo)->first(); //No concidera el orden ni status
        return Response::json(array('id' => $sistema->id_sistema,'siguiente' => $grupo->grupo.'/'.$grupoSiguiente->grupo ));
    }

    public function postBajasistema() {
        if (!Request::ajax()) {
            return;
        }
        $datos = Input::all();
        $validator = siaAsoSistemaPeriodoModel::validar($datos);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->errors()->toArray()));
        }
        $sistema = siaSistemaModel::find($datos["id_hidden_sis"]);
        $sistemaPeriodo = parent::apuntaPeriodoActual($sistema);
        $sistemaPeriodo->id_observacion = 4;
        $sistemaPeriodo->nota = $datos["baja_razon"];
        $sistemaPeriodo->status = 1;
        $sistemaPeriodo->save();
        $sistemaPeriodo->sistema->id_fase = 4;
        $sistemaPeriodo->sistema->status = 0;
        $sistemaPeriodo->sistema->save();
        Session::flash('mensaje', 'Se ha dado de baja el sistema');
    }
    
    public function postEliminar() {
        if (!Request::ajax()) {
            return;
        }        
        $sistema = siaSistemaModel::find(Input::get('modalConfirmaId'));
        if ($sistema == null){
            Session::flash('mensajeError', "Error al tratar de eliminar el sistema");
            return;
            }
        $PerSis = siaAsoPersonaSistemaModel::where('id_sistema', '=', $sistema->id_sistema)->get();
        foreach ($PerSis as $ps) {
            $ps->delete();
            }               
        $sistemaPeriodo = siaAsoSistemaPeriodoModel::where('id_sistema', '=', $sistema->id_sistema)->get();
        foreach ($sistemaPeriodo as $sp) {
            $siaRespuestas = siaRespuestaModel::where('id_sistema_periodo', '=', $sp->id_sistema_periodo)->get();
            foreach ($siaRespuestas as $r) {
                $r->delete();
                }
            $sp->delete();
            }
        $sistema->delete();
        Session::flash('mensaje', 'Sistema eliminado');
        }

}
