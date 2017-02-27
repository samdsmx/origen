<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PeriodosController
 *
 * @author Angel
 */
class MisSistemasController extends BaseController {

    public function getIndex() {
        if (!parent::tienePermiso(8)) {
            return Redirect::to('inicio');
        }
        $menu = parent::createMenu();
        $periodo = siaPeriodoModel::where('status', '=', 1)->first();
        $dentroDelPeriodo = !($periodo == null || strtotime("now") < strtotime($periodo->fecha_inicio) || strtotime("now") > strtotime($periodo->fecha_fin));
        $sistemas = DB::select('select T2.*, p.comentarios periodo, asp.id_observacion, o.descripcion observacion, r.valor Sistema, r2.valor nombreCompleto, asp.id_sistema_periodo
            from
            (select s.id_sistema, s.id_fase, f.descripcion fase, max(asp.id_periodo) id_periodo
                from sia_sistema s, sia_aso_persona_sistema ps, sia_aso_sistema_periodo asp, sia_cat_fase f
                where f.id_fase = s.id_fase and asp.id_sistema = s.id_sistema and s.id_sistema = ps.id_sistema and ps.id_persona = ' . /* Auth::user()->persona->id_persona */11 .
                        ' group by id_sistema) T2,
            sia_periodo p, sia_aso_sistema_periodo asp, sia_observacion o, sia_respuesta r, sia_respuesta r2
            where T2.id_periodo = p.id_periodo and asp.id_sistema=T2.id_sistema and asp.id_periodo = T2.id_periodo and 
            o.id_observacion = asp.id_observacion and r.id_sistema_periodo = asp.id_sistema_periodo and r.id_propiedad = 6
            and r2.id_sistema_periodo = asp.id_sistema_periodo and r2.id_propiedad = 5');
        return View::make('missistemas.missistemas', array('menu' => $menu, "sistemas" => $sistemas, "dentroPeriodo" => $dentroDelPeriodo));
    }

    public function construyePregunta($i, $prop, $res = "") {
        $arreglo = array("id" => $prop->id_propiedad, "pregunta" => $prop->descripcion, "obligatorio" => $prop->obligatoria, "expresion" => $prop->expresion, "num" => $i);
        $in = "";
        $porDefault = siaRespuestaPredefinidaModel::select('id_respuesta_predefinida', 'valor', 'status')->where('status', '=', 1)->where('id_propiedad', '=', $prop->id_propiedad)->get()->toArray();
        $firmaGen = "onchange='detectaCambio($prop->id_propiedad);' name='inputQ" . $prop->id_propiedad . "' id='inputQ" . $prop->id_propiedad . "'";
        switch ($prop->id_tipo) {
            case 1:
                $in = "<input " . $firmaGen . " type='text' value='" . (strlen($res) ? $res : (sizeof($porDefault) ? $porDefault[0]["valor"] : "")) . "' style='width:100%;' />";
                break;
            case 2:
                $in = "<select " . $firmaGen . " class='chosen-select' tabindex='-1' style='width:100%;' data-placeholder='-- Selecciona un elemento --'>";
                $in.="<option value=''></option>";
                foreach ($porDefault as $opcion) {
                    $in.="<option value='" . $opcion["valor"] . "'" . (($opcion["id_respuesta_predefinida"] == intval($res)) ? " selected" : "") . ">" . $opcion["valor"] . "</option>";
                }
                $in.="</select>";
                break;
            case 3:
                foreach ($porDefault as $ind => $opcion) {
                    $in .= "<input " . substr($firmaGen, 0, -1) . "(" . $ind . ")'" . " type='radio' value='" . $opcion["valor"] . "'" . (($opcion["id_respuesta_predefinida"] == intval($res)) ? " checked" : "") . " style='margin-left:20px; margin-right:5px;vertical-align: top;' />" . $opcion["valor"];
                }
                break;
            case 4:
                foreach ($porDefault as $ind => $opcion) {
                    $in .= "<input " . substr($firmaGen, 0, -1) . "(" . $ind . ")'" . " type='checkbox' value='" . $opcion["valor"] . "'" . (($opcion["id_respuesta_predefinida"] == intval($res)) ? " checked" : "") . " style='margin-left:20px; margin-right:5px;vertical-align: top;' />" . $opcion["valor"] . "<br/>";
                }
                break;
            case 5:
                $in = "<textarea  " . $firmaGen . " style='width:100%;' >" . (strlen($res) ? $res : (sizeof($porDefault) ? $porDefault[0]["valor"] : "")) . "</textarea>";
                break;
            case 6:
                $in = "<input " . $firmaGen . " type='date' value='" . (strlen($res) ? $res : (sizeof($porDefault) ? $porDefault[0]["valor"] : "")) . "' style='width:100%; height: 25px;' />";
                break;
        }
        $arreglo["campo"] = $in;
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
        return View::make('missistemas.nuevos', array('menu' => $menu, 'pantallas' => $pantalla, 'grupos' => $grupos, 'id_sistema' => '0', 'active_group' => $grupos[0]["grupo"]));
    }

    public function postRegistraseccion() {
        if (Request::ajax()) {
            $datos = Input::all();

            $grupo = siaGrupoModel::select('id_grupo')->where('grupo', '=', $datos["Tipo"])->first();
            $sistema = siaSistemaModel::find($datos["Id"]);

            $periodo = siaPeriodoModel::where('status', '=', 1)->orderBy('fecha_inicio', 'desc')->first();
            if ($periodo === null) {
                return Redirect::to('Sistemas')->with('mensajeError', 'Se encuentra fuera de periodo. Operación inválida')->with('tituloMensaje', '¡Error!');
            }

            $sisPer = siaAsoSistemaPeriodoModel::where('id_sistema', '=', $sistema->id_sistema)->where('id_periodo', '=', $periodo->id_periodo)->first();

            if ($sistema->id_fase === 1) {

                foreach ($datos as $in => $preg) {
                    $idPropiedad = intval(str_replace($datos["Tipo"], '', $in));
                    $res = new siaRespuestaModel();
                    $res->id_sistema_periodo = $sisPer->id_sistema_periodo;
                    $res->id_persona = Auth::user()->persona->id_persona;
                    $res->valor = $preg;
                    $res->status = 1;
                    $res->save();
                }
                
            } else if ($sistema->id_fase == 3) {

                if ($sisPer == null) {
                    $sisPer = new siaAsoSistemaPeriodoModel();
                    $sisPer->id_periodo = $periodo->id_periodo;
                    $sisPer->id_sistema = $sistema->id_sistema;
                    $sisPer->id_observacion = 3;
                    $sisPer->nota = "Actualizacion";
                    $sisPer->status = 1;
                    $sisPer->save();
                }
                
                foreach ($datos as $in => $preg) {
                    $idPropiedad = intval(str_replace($datos["Tipo"], '', $in));
                    $res = new siaRespuestaModel();
                    $res->id_sistema_periodo = $sisPer->id_sistema_periodo;
                    $res->id_persona = Auth::user()->persona->id_persona;
                    $res->valor = $preg;
                    $res->status = 1;
                    $res->save();
                }
            }
/*
 * Logica para avanzar de pantalla.. ( Lo pienso sustitur.. si esta icompleto mostrar el boton de Guardar avance, Si termio Finalizar captura  )
 * 
            $grupo = siaGrupoModel::where('grupo', '=', $datos["Tipo"])->first();
            $grupo_anterior = $grupo->grupo;
            $bandera = false;
            $grupos = siaGrupoModel::select('id_grupo', 'grupo')->where('status', '=', 1)->orderBy('orden', 'asc')->orderBy('id_grupo', 'asc')->get();
            $grupo = null;
            foreach ($grupos as $gr) {
                if (!$bandera) {
                    if ($gr->grupo === $grupo_anterior) {
                        $bandera = true;
                    }
                } else {
                    $grupo = $gr;
                    break;
                }
            }
            
            if ($grupo == null) {
                $sistema = siaSistemaModel::find($datos["Id"]);
                if ($sistema->id_fase == 1) {
                    $sistema->id_fase = 2;
                } else {
                    $sistema->id_fase = 4;
                }
                $sistema->save();
                return Response::json(array('siguiente' => null));
            }
            */
            return Response::json(array('siguiente' => $grupo->grupo));
        }
    }

    public function postCancelarregistronuevo() {
        if (Request::ajax()) {
            $id = Input::get("_id");
            $sistema = siaSistemaModel::find($id);
            $sistemaPeriodo = siaAsoSistemaPeriodoModel::where('id_sistema', '=', $sistema->id_sistema)->first();
            DB::table("sia_respuesta")->where('id_sistema_periodo', '=', $sistemaPeriodo->id_sistema_periodo)->delete();
            $sistemaPeriodo->delete();
            $sistema->delete();
            return Response::json(array('success' => true));
        }
    }

    public function postReportarsincambios() {
        if (Request::ajax()) {
            $id = Input::get('Id');
            $periodo = siaPeriodoModel::where('status', '=', 1)->orderBy('fecha_inicio', 'desc')->first();
            if ($periodo == null) {
                return Response::json(array('titulo' => "Error", 'mensaje' => "Lo sentimos, pero se encuentra fuera de periodo"));
            }
            $sistema = siaSistemaModel::find(intval($id));
            $sistemaPeriodo = siaAsoSistemaPeriodoModel::where('id_sistema', '=', $sistema->id_sistema)->where('id_periodo', '=', $periodo->id_periodo)->first();

            if ($sistemaPeriodo == null) {
                $sistema->id_fase = 4;
                $sistema->save();
                $sistemaPeriodo = new siaAsoSistemaPeriodoModel();
                $sistemaPeriodo->id_periodo = $periodo->id_periodo;
                $sistemaPeriodo->id_sistema = $sistema->id_sistema;
                $sistemaPeriodo->id_observacion = 1;
                $sistemaPeriodo->nota = "Sin cambios";
                $sistemaPeriodo->status = 1;
                $sistemaPeriodo->save();
            }
        }
    }

    public function actualizarSistema($id) {
        $menu = parent::createMenu();
        $periodo = siaPeriodoModel::where('status', '=', 1)->orderBy('fecha_inicio', 'desc')->first();
        if ($periodo == NULL) {
            return Response::json(array('titulo' => "Error", 'mensaje' => "Lo sentimos, pero se encuentra fuera de periodo"));
        }
        $sistemaPeriodo = siaAsoSistemaPeriodoModel::where('id_sistema', '=', $id)->where('id_periodo', '=', $periodo->id_periodo)->first();
        $grupos = siaGrupoModel::select('id_grupo', 'grupo')->where('status', '=', 1)->orderBy('orden', 'asc')->orderBy('grupo', 'asc')->get();
        $secciones = array();
        foreach ($grupos as $grupo) {
            $secciones[$grupo->grupo] = array();
        }
        if ($sistemaPeriodo == NULL) {
            // empieza desde cero la actualizacion
            $group_active = $grupos[0]->grupo;
            //$propiedadesContestadas = siaAsoSistemaPropiedadModel::where('id_sistema', '=', $id)->get();
            if ($propiedadesContestadas == NULL) {
                return Response::json(array('titulo' => "Error", 'mensaje' => "Algo ha salido mal. Por favor contacte al administrador del sistema"));
            }
            // recordemos que cuando se guarde la actualización, si las preguntas son las mismas no se modificarán estos registros
            $i = 1;
            foreach ($propiedadesContestadas as $propiedadC) {
                $prop = siaPropiedadModel::where('id_propiedad', '=', $propiedadC->id_propiedad)->where('status', '=', 1)->first();
                if ($prop == NULL) {
                    continue;
                }
                /* $proRes = siaAsoPropiedadRespuestaModel::where('id_sistema_propiedad', '=', $propiedadC->id_sistema_propiedad)->orderBy('created_at', 'desc')->first();
                  $res = siaRespuestaModel::find($proRes->id_respuesta); */
                $grupo = siaGrupoModel::find($prop->id_grupo);
                $arregloSeccion = &$secciones[$grupo->grupo];
                $arregloSeccion[] = self::construyePregunta($i, $prop, $res->valor);
                $i++;
            }
        } else {
            // solo se entro al menu o se actualizo "a la mitad"
            //$propiedadesContestadas = siaAsoSistemaPropiedadModel::where('id_sistema', '=', $id)->get();
            if (sizeof($propiedadesContestadas) == 0) {
                // Solo se entro una vez a la creación y no se contesto nada.                   
                $pobligatorias = DB::select('select p.*, g.grupo, t.tipo, r.expresion from sia_cat_grupo g, sia_cat_tipo t, sia_cat_propiedad p LEFT OUTER JOIN sia_cat_reglas r on r.id_propiedad_dependiente = p.id_propiedad where p.id_grupo = g.id_grupo and t.id_tipo = p.id_tipo and p.status = 1 order by -g.orden DESC, g.grupo ASC, -p.orden DESC, p.id_propiedad ASC');
                foreach ($pobligatorias as $ind => $prop) {
                    $secciones[$prop->grupo][] = self::construyePregunta($ind + 1, $prop);
                }
                $group_active = $grupos[0]->grupo;
            } else {
                // Se dejo "a la mitad" el registro del sistema.
                // tendremos que consultar las respuestas del periodo al que estamos haciendo referencia
                $grupoAnt = "";
                $i = 1;
                foreach ($propiedadesContestadas as $propiedadC) {
                    $prop = siaPropiedadModel::where('id_propiedad', '=', $propiedadC->id_propiedad)->where('status', '=', 1)->first();
                    if ($prop == NULL) {
                        continue;
                    }
                    /* NECESITAMOS LA RESPUESTA DE ESA PROPIEDAD PARA ESE PERIODO */
                    $res = DB::select('SELECT r.* FROM sia_respuesta r
                            JOIN sia_aso_sistema_periodo sp ON sp.id_sistema_periodo = r.id_sistema_periodo
                            JOIN sia_aso_propiedad_respuesta pr ON pr.id_respuesta = r.id_respuesta
                            WHERE sp.id_sistema_periodo = ' . $sistemaPeriodo->id_sistema_periodo . ' AND pr.id_sistema_propiedad = ' . $propiedadC->id_sistema_propiedad);
                    $grupo = siaGrupoModel::find($prop->id_grupo);
                    $arregloSeccion = &$secciones[$grupo->grupo];
                    $arregloSeccion[] = self::construyePregunta($i, $prop, $res[0]->valor);
                    $i++;
                    /* LOGICA PARA SIGUIENTE GRUPO */
                    $grupoAnt = $grupo->grupo;
                }

                $grupos = siaGrupoModel::select('id_grupo', 'grupo')->where('status', '=', 1)->orderBy('orden', 'asc')->orderBy('grupo', 'asc')->get();
                $grupo = null;
                $bandera = false;
                foreach ($grupos as $gr) {
                    if (!$bandera) {
                        if ($gr->grupo === $grupoAnt) {
                            $bandera = true;
                        }
                    } else {
                        $grupo = $gr;
                        break;
                    }
                }
                $group_active = $grupo->grupo;
                $pobligatorias = DB::select('select p.*, g.grupo, t.tipo, r.expresion from sia_cat_grupo g, sia_cat_tipo t, sia_cat_propiedad p LEFT OUTER JOIN sia_cat_reglas r on r.id_propiedad_dependiente = p.id_propiedad where p.id_grupo = g.id_grupo and t.id_tipo = p.id_tipo and p.status = 1 order by -g.orden DESC, g.grupo ASC, -p.orden DESC, p.id_propiedad ASC');
                foreach ($pobligatorias as $ind => $prop) {
                    $secciones[$prop->grupo][] = self::construyePregunta($ind + 1, $prop);
                }
            }
        }
        return View::make('missistemas.modifica', array('pantallas' => $secciones, 'id_sistema' => $id, 'menu' => $menu, 'grupos' => $grupos, 'active_group' => $group_active));
    }

    public function postBajasistema() {
        if (Request::ajax()) {
            $baja = Input::all();
            $rules = array(
                "baja_razon" => "required|regex:/^[a-zA-ZáéíóúñÁÉÍÓÚÑ][a-zA-ZáéíóúñÁÉÍÓÚÑ0-9\s]*/"
            );
            $messages = array(
                "baja_razon.required" => "La razón es obligatoria.",
                "baja_razon.regex" => "La razón no es valido."
            );
            $validator = Validator::make($baja, $rules, $messages);
            if ($validator->fails()) {
                return Response::json(array('errors' => $validator->errors()->toArray()));
            }
            $id = $baja["id_hidden_sis"];
            $razon = $baja["baja_razon"];
            $sistema = siaSistemaModel::find($id);
            $periodo = siaPeriodoModel::where('status', '=', 1)->orderBy('fecha_inicio', 'desc')->first();
            $sistemaPeriodo = new siaAsoSistemaPeriodoModel();
            $sistemaPeriodo->id_sistema = $id;
            $sistemaPeriodo->id_periodo = $periodo->id_periodo;
            $sistemaPeriodo->id_observacion = 4;
            $sistemaPeriodo->nota = $razon;
            $sistemaPeriodo->status = 1;
            $sistemaPeriodo->save();

            $sistema->status = 0;
            $sistema->save();
        }
    }

}
