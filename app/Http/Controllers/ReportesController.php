<?php

namespace App\Http\Controllers;

use DB, Auth, View, Session, Request, Redirect, DateTime, Response, Validator;

class ReportesController extends BaseController {

    public function getIndex() {
        if (!parent::tienePermiso('Reportes')) {
            return Redirect::to('inicio');
        }
        $menu = parent::createMenu();

        $periodo = periodoModel::where('status', '=', 1)->orderBy('fecha_inicio', 'desc')->first();
        $fechaPeriodos = DB::select("select id_periodo, fecha_inicio, fecha_fin from periodo");
        $inicio = new DateTime($periodo->fecha_inicio);
        $fin = new DateTime($periodo->fecha_fin);
        $activo1 = ($inicio->getTimestamp() <= strtotime("now"));
        if (!$activo1) {
            $dias = -1 * (ceil(($inicio->getTimestamp() - strtotime("now")) / (60 * 60 * 24)) + 1);
        } else {
            $dias = ceil(($fin->getTimestamp() - strtotime("now")) / (60 * 60 * 24)) + 1;
            if ($dias < 0) {
                $dias = 0;
            }
        }
        $activos = DB::select('SELECT count(*) activos FROM sistema s where s.status = 1');
        $bajas = DB::select('SELECT count(*) bajas FROM sistema s where s.status = 0');
        $incompletos = DB::select('SELECT count(*) incompletos FROM sistema s where status = 1 and (id_fase = 1 or id_fase = 3)');
        $tiempoFaltante = DB::select('SELECT DATEDIFF((select fecha_fin from periodo where status = 1),current_date())+1 tiempo');
        $procesados = DB::select('SELECT count(*) cuenta '
                        . 'FROM aso_sistema_periodo s, observacion o, periodo p, sistema si, cat_fase f '
                        . 'WHERE p.id_periodo = s.id_periodo and o.id_observacion = s.id_observacion and p.status = 1 and si.status = 1 and s.id_sistema=si.id_sistema and si.id_fase = f.id_fase and (f.id_fase = 2 or f.id_fase = 4)');
        $observaciones = DB::select('SELECT o.descripcion obs, f.descripcion fase, count(*) cuenta '
                        . 'FROM aso_sistema_periodo s, observacion o, periodo p, sistema si, cat_fase f '
                        . 'WHERE p.id_periodo = s.id_periodo and o.id_observacion = s.id_observacion and p.status = 1 and s.id_sistema=si.id_sistema and si.id_fase = f.id_fase and (f.id_fase = 2 or f.id_fase = 4) '
                        . 'GROUP BY o.descripcion, f.descripcion ORDER BY cuenta asc');
        $nombresCamposT = DB::select("SELECT column_name columna, table_name tabla "
                        . "FROM information_schema.columns "
                        . "WHERE table_schema = 'origencallcenter' and column_name != 'created_at' and column_name != 'status' and column_name != 'updated_at' and column_name not like 'id%' and column_name != 'orden' and column_name != 'obligatoria'"
                        . "and table_name != 'cat_actividad' and table_name != 'cat_grupo' and table_name != 'cat_reglas' and table_name != 'cat_respuestas_predefinidas' "
                        . "and table_name != 'cat_tipo' and table_name != 'persona' and table_name != 'sentencias' and table_name != 'usuario' "
                        . "and table_name != 'aso_usuario_actividad' and table_name != 'periodo' and table_name != 'aso_sistema_periodo'"
                        . "and table_name != 'cat_unidad_responsable'"
                        . "ORDER BY table_name DESC;");
        $dash["procesados"] = $procesados[0]->cuenta;
        $dash["resultadoTareas"] = 0;
        if ($tiempoFaltante[0]->tiempo >= 1) {
            $dash["resultadoTareas"] = ($activos[0]->activos - $procesados[0]->cuenta) / $tiempoFaltante[0]->tiempo;
        }
        $dash["velocidadMedia"] = round($activos[0]->activos / ceil(($fin->getTimestamp() - $inicio->getTimestamp()) / (60 * 60 * 24)));
        $graficasPosibles = graficasGuardadasModel::getGraficas();
        $propiedades = DB::select("select id_propiedad, descripcion from cat_propiedad");
        return View::make('reportes.reportes', array(
                    'menu' => $menu,
                    'dias' => $dias,
                    'activos' => $activos[0]->activos,
                    'bajas' => $bajas[0]->bajas,
                    'incompletos' => $incompletos[0]->incompletos,
                    'observaciones' => $observaciones,
                    'periodo' => $periodo,
                    'fechaPeriodos' => $fechaPeriodos,
                    'dash' => $dash,
                    'graficasPosibles' => $graficasPosibles,
                    'nombresCamposT' => $nombresCamposT,
                    'propiedades' => $propiedades
        ));
    }

    public function postPeriodo() {
        $fecha = Request::get('fecha');
        if (is_numeric($fecha)) {
            $observaciones = DB::select('SELECT o.descripcion, count(*) cuenta
                                FROM aso_sistema_periodo s, observacion o, periodo p
                                where p.id_periodo = ' . $fecha . ' and o.id_observacion = s.id_observacion and p.status = 1
                                group by o.descripcion order by cuenta asc');
            if (count($observaciones) == 0) {
                echo 'vacio';
            } else {
                return $observaciones;
            }
        } else {
            echo 'noNumerico';
        }
    }

    public function getGraficar($valor) {
        if (is_numeric($valor)) {
            $numeroGraficas = graficasGuardadasModel::getInfoGraficas($valor);

            $tipoGrafica = $numeroGraficas['tipoGrafica'];
            $elementosGrafica = graficasGuardadasModel::getInfoElementos($valor);

            $resultado = array();
            $resultado[] = $tipoGrafica . ':' . '0';
            foreach ($elementosGrafica as $key => $valor) {
                if (strlen($valor[4]) > 2) {
                    $busqueda = DB::select($valor[3] . ' where ' . $valor[4]);
                } else {
                    $busqueda = DB::select($valor[3]);
                }
                $resultado[] = $valor[2] . ':' . $busqueda[0]->cuenta;
            }
            return $resultado;
        }
    }

    public function postPeriodos() {
        $tipo = Request::get('tipo');
        $resultado = array();
        if (is_numeric($tipo)) {
            if ($tipo == 1) {
                $resultado = DB::select('select fecha_inicio, fecha_fin from periodo order by fecha_inicio');
            } else if ($tipo == 2) {
                $resultado = DB::select('select year(fecha_inicio) anio, IF(MONTH(fecha_fin) < 7, 1, 2) semestre from periodo group by semestre, year(fecha_inicio) order by year(fecha_inicio)');
            } else if ($tipo == 3) {
                $resultado = DB::select('select year(fecha_inicio) anio from periodo group by year(fecha_inicio) order by year(fecha_inicio)');
            }
            return $resultado;
        } else {
            echo 'fallo';
        }
    }

    public function postGraficap() {
        $tipotg = Request::get('tipotg');

        if (is_numeric($tipotg)) {
            if ($tipotg == 2) {
                $periodo = Request::get('periodo');
                $comparado = Request::get('comparado');
                $idGrafica = Request::get('idgrafica');

                $periodoSeparado = explode(':', $periodo);

                if (sizeof($periodoSeparado) == 1) {

                    $numeroGraficas = graficasGuardadasModel::getInfoGraficas($idGrafica);

                    $tipoGrafica = $numeroGraficas['tipoGrafica'];
                    $elementosGrafica = graficasGuardadasModel::getInfoElementos($idGrafica);
                    $condicion = "";



                    $resultado = array();
                    $resultado[] = $tipoGrafica . ':' . $comparado;
                    foreach ($elementosGrafica as $key => $valor) {
                        if (strlen($valor[4]) > 2) {
                            if ($elementosGrafica[0][1] == 1) {
                                $condicion = " where p.fecha_inicio like '" . $periodoSeparado[0] . "%' and p.fecha_fin like '" . $periodoSeparado[0] . "%' and o.id_observacion = s.id_observacion and o.descripcion = '" . $valor[2] . "'";
                            } else {
                                $condicionTemporal = explode('and', $valor[4]);

                                $condicion = " where sp.fecha_inicio like '" . $periodoSeparado[0] . "%' and sp.fecha_fin like '" . $periodoSeparado[0] . "%' and " . $condicionTemporal[1];
                            }
                            $busqueda = DB::select($valor[3] . $condicion);
                        } else {
                            $busqueda = DB::select($valor[3]);
                        }
                        $resultado[] = $valor[2] . ':' . $busqueda[0]->cuenta;
                    }
                    if (comparado != 0) {
                        foreach ($elementosGrafica as $key => $valor) {
                            if (strlen($valor[4]) > 2) {
                                if ($elementosGrafica[0][1] == 1) {
                                    $condicion = " where p.fecha_inicio like '" . $comparado . "%' and p.fecha_fin like '" . $comparado . "%' and o.id_observacion = s.id_observacion and o.descripcion = '" . $valor[2] . "'";
                                } else {
                                    $condicionTemporal = explode('and', $valor[4]);

                                    $condicion = " where sp.fecha_inicio like '" . $comparado . "%' and sp.fecha_fin like '" . $comparado . "%' and " . $condicionTemporal[1];
                                }
                                $busqueda = DB::select($valor[3] . $condicion);
                            } else {
                                $busqueda = DB::select($valor[3]);
                            }
                            $resultado[] = $valor[2] . ':' . $busqueda[0]->cuenta;
                        }
                    }
                    return $resultado;
                } else if (sizeof($periodoSeparado) == 2) {
                    if (strlen($periodoSeparado[0]) == 4) {
                        $semestre1i = "01-01";
                        $semestre1f = "06-30";

                        $semestre2i = "07-01";
                        $semestre2f = "12-31";

                        $semestrei = "";
                        $semestref = "";

                        if ($periodoSeparado[1] == 1) {
                            $semestrei = $semestre1i;
                            $semestref = $semestre1f;
                        } else if ($periodoSeparado[1] == 2) {

                            $semestrei = $semestre2i;
                            $semestref = $semestre2f;
                        }

                        $numeroGraficas = graficasGuardadasModel::getInfoGraficas($idGrafica);

                        $tipoGrafica = $numeroGraficas['tipoGrafica'];
                        $elementosGrafica = graficasGuardadasModel::getInfoElementos($idGrafica);
                        $condicion = "";



                        $resultado = array();
                        $resultado[] = $tipoGrafica . ':' . $comparado;
                        foreach ($elementosGrafica as $key => $valor) {
                            if (strlen($valor[4]) > 2) {
                                if ($elementosGrafica[0][1] == 1) {
                                    $condicion = " where p.fecha_inicio >= '" . $periodoSeparado[0] . "-" . $semestrei . "' and p.fecha_fin <= '" . $periodoSeparado[0] . "-" . $semestref . "' and o.id_observacion = s.id_observacion and o.descripcion = '" . $valor[2] . "'";
                                } else {
                                    $condicionTemporal = explode('and', $valor[4]);

                                    $condicion = " where sp.fecha_inicio >= '" . $periodoSeparado[0] . "-" . $semestrei . "' and sp.fecha_fin <= '" . $periodoSeparado[0] . "-" . $semestref . "' and " . $condicionTemporal[1];
                                }
                                $busqueda = DB::select($valor[3] . $condicion);
                            } else {
                                $busqueda = DB::select($valor[3]);
                            }
                            $resultado[] = $valor[2] . ':' . $busqueda[0]->cuenta;
                        }
                        if ($comparado != 0) {
                            $comparadoSep = explode(":", $comparado);
                            $semestre1i = "01-01";
                            $semestre1f = "06-30";

                            $semestre2i = "07-01";
                            $semestre2f = "12-31";

                            $semestrei1 = "";
                            $semestref1 = "";

                            if ($comparadoSep[1] == 1) {
                                $semestrei1 = $semestre1i;
                                $semestref1 = $semestre1f;
                            } else if ($comparadoSep[1] == 2) {
                                $semestrei1 = $semestre2i;
                                $semestref1 = $semestre2f;
                            }
                            foreach ($elementosGrafica as $key => $valor) {
                                if (strlen($valor[4]) > 2) {
                                    if ($elementosGrafica[0][1] == 1) {
                                        $condicion = " where p.fecha_inicio >= '" . $comparadoSep[0] . "-" . $semestrei1 . "' and p.fecha_fin <= '" . $comparadoSep[0] . "-" . $semestref1 . "' and o.id_observacion = s.id_observacion and o.descripcion = '" . $valor[2] . "'";
                                    } else {
                                        $condicionTemporal = explode('and', $valor[4]);

                                        $condicion = " where sp.fecha_inicio >= '" . $comparadoSep[0] . "-" . $semestrei1 . "' and sp.fecha_fin <= '" . $comparadoSep[0] . "-" . $semestref1 . "' and " . $condicionTemporal[1];
                                    }
                                    $busqueda = DB::select($valor[3] . $condicion);
                                } else {
                                    $busqueda = DB::select($valor[3]);
                                }
                                $resultado[] = $valor[2] . ':' . $busqueda[0]->cuenta;
                            }
                        }
                        return $resultado;
                    } else {
                        $numeroGraficas = graficasGuardadasModel::getInfoGraficas($idGrafica);

                        $tipoGrafica = $numeroGraficas['tipoGrafica'];
                        $elementosGrafica = graficasGuardadasModel::getInfoElementos($idGrafica);
                        $condicion = "";



                        $resultado = array();
                        $resultado[] = $tipoGrafica . ':' . $comparado;
                        foreach ($elementosGrafica as $key => $valor) {
                            if (strlen($valor[4]) > 2) {
                                if ($elementosGrafica[0][1] == 1) {
                                    $condicion = " where p.fecha_inicio = '" . $periodoSeparado[0] . "' and p.fecha_fin = '" . $periodoSeparado[1] . "' and o.id_observacion = s.id_observacion and o.descripcion = '" . $valor[2] . "'";
                                } else {
                                    $condicionTemporal = explode('and', $valor[4]);

                                    $condicion = " where sp.fecha_inicio = '" . $periodoSeparado[0] . "' and sp.fecha_fin = '" . $periodoSeparado[1] . "' and " . $condicionTemporal[1];
                                }
                                $busqueda = DB::select($valor[3] . $condicion);
                            } else {
                                $busqueda = DB::select($valor[3]);
                            }
                            $resultado[] = $valor[2] . ':' . $busqueda[0]->cuenta;
                        }
                        if ($comparado != 0) {
                            $comparadoSep = explode(":", $comparado);
                            foreach ($elementosGrafica as $key => $valor) {
                                if (strlen($valor[4]) > 2) {
                                    if ($elementosGrafica[0][1] == 1) {
                                        $condicion = " where p.fecha_inicio = '" . $comparadoSep[0] . "' and p.fecha_fin = '" . $comparadoSep[1] . "' and o.id_observacion = s.id_observacion and o.descripcion = '" . $valor[2] . "'";
                                    } else {
                                        $condicionTemporal = explode('and', $valor[4]);

                                        $condicion = " where sp.fecha_inicio = '" . $comparadoSep[0] . "' and sp.fecha_fin = '" . $comparadoSep[1] . "' and " . $condicionTemporal[1];
                                    }
                                    $busqueda = DB::select($valor[3] . $condicion);
                                } else {
                                    $busqueda = DB::select($valor[3]);
                                }
                                $resultado[] = $valor[2] . ':' . $busqueda[0]->cuenta;
                            }
                        }
                        return $resultado;
                    }
                }
            } else if ($tipotg == 1) {
                $tipo = Request::get('tipo');
                $elemento = Request::get('elemento');
                $filtro = Request::get('filtro');
                $condiciones = '';
                $filtroc = Request::get('filtroc');
                $periodo = Request::get('periodo');
                $comparado = Request::get('comparado');
                $resultado = array();
                $condicionPeriodo = '';
                if (strlen($periodo) > 1) {
                    $periodoSeparado = explode(':', $periodo);
                    if (sizeof($periodoSeparado) == 1) {
                        $condicionPeriodo = " and sp.fecha_inicio like '" . $periodoSeparado[0] . "%' and sp.fecha_fin like '" . $periodoSeparado[0] . "%'";
                    } else {
                        if (strlen($periodoSeparado[0]) == 4) {
                            $semestre1i = "01-01";
                            $semestre1f = "06-30";

                            $semestre2i = "07-01";
                            $semestre2f = "12-31";

                            $semestrei = "";
                            $semestref = "";

                            if ($periodoSeparado[1] == 1) {
                                $semestrei = $semestre1i;
                                $semestref = $semestre1f;
                            } else if ($periodoSeparado[1] == 2) {

                                $semestrei = $semestre2i;
                                $semestref = $semestre2f;
                            }
                            $condicionPeriodo = " and sp.fecha_inicio >= '" . $periodoSeparado[0] . "-" . $semestrei . "' and sp.fecha_fin <= '" . $periodoSeparado[0] . "-" . $semestref . "'";
                        } else {
                            $condicionPeriodo = " and sp.fecha_inicio = '" . $periodoSeparado[0] . "' and sp.fecha_fin = '" . $periodoSeparado[1] . "'";
                        }
                    }
                }


                $elementoDividido = explode(',', $elemento);
                $resultado[] = $tipo . ':' . $comparado;
                foreach ($elementoDividido as $el) {
                    $partesEl = explode(':', $el);
                    $tabla = $partesEl[0];
                    $campo = $partesEl[1];
                    if ($filtro != '0' && strlen($condicionPeriodo) > 1 && !($tabla == 'cat_propiedad' || $tabla == 'respuesta')) {
                        $condiciones = 't.' . $campo . ' ' . $filtro . ' ' . $filtroc . $condicionPeriodo;
                    } else if ($filtro != '0' && strlen($condicionPeriodo) <= 1 && !($tabla == 'cat_propiedad' || $tabla == 'respuesta')) {
                        $condiciones = 't.' . $campo . ' ' . $filtro . ' ' . $filtroc;
                    } else if (strlen($condicionPeriodo) > 1 && !($tabla == 'cat_propiedad' || $tabla == 'respuesta')) {
                        $condiciones = $condicionPeriodo;
                    }
                    if ($tabla == 'observacion') {
                        if ($filtro != '0') {
                            $busqueda = DB::select('select count(*) cuenta from aso_sistema_periodo sasp '
                                            . 'join sistema ss on sasp.id_sistema = ss.id_sistema join periodo sp on sasp.id_periodo = sp.id_periodo '
                                            . 'join observacion t on sasp.id_observacion = t.id_observacion where ' . $condiciones);
                            $resultado[] = $campo . ' ' . $filtro . ' ' . $filtroc . ':' . $busqueda[0]->cuenta;
                        } else {
                            $busquedaTem = DB::select('select ' . $campo . ' buscador from observacion');
                            foreach ($busquedaTem as $bt) {
                                $busqueda = DB::select('select count(*) cuenta from aso_sistema_periodo sasp '
                                                . 'join sistema ss on sasp.id_sistema = ss.id_sistema join periodo sp on sasp.id_periodo = sp.id_periodo '
                                                . 'join observacion t on sasp.id_observacion = t.id_observacion '
                                                . 'where t.' . $campo . '="' . $bt->buscador . '"' . $condiciones);
                                $resultado[] = $bt->buscador . ':' . $busqueda[0]->cuenta;
                            }
                        }
                    } else if ($tabla == 'cat_fase') {
                        if ($filtro != '0') {
                            $busqueda = DB::select('select count(*) cuenta from aso_sistema_periodo sasp join sistema ss on sasp.id_sistema = ss.id_sistema join periodo sp on sasp.id_periodo = sp.id_periodo join observacion t on sasp.id_observacion = t.id_observacion where ' . $condiciones);
                            $resultado[] = $campo . ' ' . $filtro . ' ' . $filtroc . ':' . $busqueda[0]->cuenta;
                        } else {
                            $busquedaTem = DB::select('select ' . $campo . ' buscador from ' . $tabla);
                            foreach ($busquedaTem as $bt) {
                                $busqueda = DB::select('select count(*) cuenta from aso_sistema_periodo sasp join sistema ss on sasp.id_sistema = ss.id_sistema join periodo sp on sasp.id_periodo = sp.id_periodo join cat_fase t on ss.id_fase = t.id_fase where t.' . $campo . '="' . $bt->buscador . '"' . $condiciones);
                                $resultado[] = $bt->buscador . ':' . $busqueda[0]->cuenta;
                            }
                        }
                    } else if ($tabla == 'cat_propiedad') {
                        $adicional = Request::get('adicional');

                        $busquedaTem = DB::select('select * from respuesta where id_propiedad = ' . $adicional . ' group by valor');
                        foreach ($busquedaTem as $bt) {
                            $busqueda = DB::select('select count(*) cuenta from aso_sistema_periodo sasp join sistema ss on sasp.id_sistema = ss.id_sistema join periodo sp on sasp.id_periodo = sp.id_periodo join respuesta sr on sr.id_sistema_periodo = sasp.id_sistema_periodo join cat_propiedad t on sr.id_propiedad = t.id_propiedad where  1=1 and sr.valor = "' . $bt->valor . '" ' . $condicionPeriodo);
                            $resultado[] = $bt->valor . ':' . $busqueda[0]->cuenta;
                        }
                    } else if ($tabla == 'respuesta') {
                        $adicional = Request::get('adicional');
                        if ($filtro != '0') {
                            $busquedaTem = DB::select('select * from respuesta where id_propiedad = ' . $adicional . ' and valor ' . $filtro . ' ' . $filtroc . ' group by valor');
                            foreach ($busquedaTem as $bt) {
                                $busqueda = DB::select('select count(*) cuenta from aso_sistema_periodo sasp join sistema ss on sasp.id_sistema = ss.id_sistema join periodo sp on sasp.id_periodo = sp.id_periodo join respuesta sr on sr.id_sistema_periodo = sasp.id_sistema_periodo join cat_propiedad t on sr.id_propiedad = t.id_propiedad where  1=1 and sr.valor = "' . $bt->valor . '" ' . $condicionPeriodo);
                                $resultado[] = $bt->valor . ':' . $busqueda[0]->cuenta;
                            }
                        } else {
                            $busquedaTem = DB::select('select * from respuesta where id_propiedad = ' . $adicional . ' group by valor');
                            foreach ($busquedaTem as $bt) {
                                $busqueda = DB::select('select count(*) cuenta from aso_sistema_periodo sasp join sistema ss on sasp.id_sistema = ss.id_sistema join periodo sp on sasp.id_periodo = sp.id_periodo join respuesta sr on sr.id_sistema_periodo = sasp.id_sistema_periodo join cat_propiedad t on sr.id_propiedad = t.id_propiedad where  1=1 and sr.valor = "' . $bt->valor . '" ' . $condicionPeriodo);
                                $resultado[] = $bt->valor . ':' . $busqueda[0]->cuenta;
                            }
                        }
                    }
                }
                if ($comparado != 0) {
                    $periodoSeparado = explode(':', $comparado);
                    if (sizeof($periodoSeparado) == 1) {
                        $condicionPeriodo = " and sp.fecha_inicio like '" . $periodoSeparado[0] . "%' and sp.fecha_fin like '" . $periodoSeparado[0] . "%'";
                    } else {
                        if (strlen($periodoSeparado[0]) == 4) {
                            $semestre1i = "01-01";
                            $semestre1f = "06-30";

                            $semestre2i = "07-01";
                            $semestre2f = "12-31";

                            $semestrei = "";
                            $semestref = "";

                            if ($periodoSeparado[1] == 1) {
                                $semestrei = $semestre1i;
                                $semestref = $semestre1f;
                            } else if ($periodoSeparado[1] == 2) {

                                $semestrei = $semestre2i;
                                $semestref = $semestre2f;
                            }
                            $condicionPeriodo = " and sp.fecha_inicio >= '" . $periodoSeparado[0] . "-" . $semestrei . "' and sp.fecha_fin <= '" . $periodoSeparado[0] . "-" . $semestref . "'";
                        } else {
                            $condicionPeriodo = " and sp.fecha_inicio = '" . $periodoSeparado[0] . "' and sp.fecha_fin = '" . $periodoSeparado[1] . "'";
                        }
                    }
                    foreach ($elementoDividido as $el) {
                        $partesEl = explode(':', $el);
                        $tabla = $partesEl[0];
                        $campo = $partesEl[1];
                        if ($filtro != '0' && strlen($condicionPeriodo) > 1) {
                            $condiciones = 't.' . $campo . ' ' . $filtro . ' ' . $filtroc . $condicionPeriodo;
                        } else if ($filtro != '0' && strlen($condicionPeriodo) <= 1) {
                            $condiciones = 't.' . $campo . ' ' . $filtro . ' ' . $filtroc;
                        } else if (strlen($condicionPeriodo) > 1) {
                            $condiciones = $condicionPeriodo;
                        }
                        if ($tabla == 'observacion') {
                            if ($filtro != '0') {
                                $busqueda = DB::select('select count(*) cuenta from aso_sistema_periodo sasp '
                                                . 'join sistema ss on sasp.id_sistema = ss.id_sistema join periodo sp on sasp.id_periodo = sp.id_periodo '
                                                . 'join observacion t on sasp.id_observacion = t.id_observacion where ' . $condiciones);
                                $resultado[] = $campo . ' ' . $filtro . ' ' . $filtroc . ':' . $busqueda[0]->cuenta;
                            } else {
                                $busquedaTem = DB::select('select ' . $campo . ' buscador from observacion');
                                foreach ($busquedaTem as $bt) {
                                    $busqueda = DB::select('select count(*) cuenta from aso_sistema_periodo sasp '
                                                    . 'join sistema ss on sasp.id_sistema = ss.id_sistema join periodo sp on sasp.id_periodo = sp.id_periodo '
                                                    . 'join observacion t on sasp.id_observacion = t.id_observacion '
                                                    . 'where t.' . $campo . '="' . $bt->buscador . '"' . $condiciones);
                                    $resultado[] = $bt->buscador . ':' . $busqueda[0]->cuenta;
                                }
                            }
                        } else if ($tabla == 'cat_fase') {
                            if ($filtro != '0') {
                                $busqueda = DB::select('select count(*) cuenta from aso_sistema_periodo sasp join sistema ss on sasp.id_sistema = ss.id_sistema join periodo sp on sasp.id_periodo = sp.id_periodo join observacion t on sasp.id_observacion = t.id_observacion where ' . $condiciones);
                                $resultado[] = $campo . ' ' . $filtro . ' ' . $filtroc . ':' . $busqueda[0]->cuenta;
                            } else {
                                $busquedaTem = DB::select('select ' . $campo . ' buscador from ' . $tabla);
                                foreach ($busquedaTem as $bt) {
                                    $busqueda = DB::select('select count(*) cuenta from aso_sistema_periodo sasp join sistema ss on sasp.id_sistema = ss.id_sistema join periodo sp on sasp.id_periodo = sp.id_periodo join cat_fase t on ss.id_fase = t.id_fase where t.' . $campo . '="' . $bt->buscador . '"' . $condiciones);
                                    $resultado[] = $bt->buscador . ':' . $busqueda[0]->cuenta;
                                }
                            }
                        } else if ($tabla == 'cat_propiedad') {
                            $adicional = Request::get('adicional');

                            $busquedaTem = DB::select('select * from respuesta where id_propiedad = ' . $adicional . ' group by valor');
                            foreach ($busquedaTem as $bt) {
                                $busqueda = DB::select('select count(*) cuenta from aso_sistema_periodo sasp join sistema ss on sasp.id_sistema = ss.id_sistema join periodo sp on sasp.id_periodo = sp.id_periodo join respuesta sr on sr.id_sistema_periodo = sasp.id_sistema_periodo join cat_propiedad t on sr.id_propiedad = t.id_propiedad where  1=1 and sr.valor = "' . $bt->valor . '" ' . $condicionPeriodo);
                                $resultado[] = $bt->valor . ':' . $busqueda[0]->cuenta;
                            }
                        } else if ($tabla == 'respuesta') {
                            $adicional = Request::get('adicional');
                            if ($filtro != '0') {
                                $busquedaTem = DB::select('select * from respuesta where id_propiedad = ' . $adicional . ' and valor ' . $filtro . ' ' . $filtroc . ' group by valor');
                                foreach ($busquedaTem as $bt) {
                                    $busqueda = DB::select('select count(*) cuenta from aso_sistema_periodo sasp join sistema ss on sasp.id_sistema = ss.id_sistema join periodo sp on sasp.id_periodo = sp.id_periodo join respuesta sr on sr.id_sistema_periodo = sasp.id_sistema_periodo join cat_propiedad t on sr.id_propiedad = t.id_propiedad where  1=1 and sr.valor = "' . $bt->valor . '" ' . $condicionPeriodo);
                                    $resultado[] = $bt->valor . ':' . $busqueda[0]->cuenta;
                                }
                            } else {
                                $busquedaTem = DB::select('select * from respuesta where id_propiedad = ' . $adicional . ' group by valor');
                                foreach ($busquedaTem as $bt) {
                                    $busqueda = DB::select('select count(*) cuenta from aso_sistema_periodo sasp join sistema ss on sasp.id_sistema = ss.id_sistema join periodo sp on sasp.id_periodo = sp.id_periodo join respuesta sr on sr.id_sistema_periodo = sasp.id_sistema_periodo join cat_propiedad t on sr.id_propiedad = t.id_propiedad where  1=1 and sr.valor = "' . $bt->valor . '" ' . $condicionPeriodo);
                                    $resultado[] = $bt->valor . ':' . $busqueda[0]->cuenta;
                                }
                            }
                        }
                    }
                }
                return $resultado;
            }
        }
    }

    public function postExcel() {
        $informacionTabulada = Request::get('informacionTabulada');
        $fechasTabulada = Request::get('fechasTabuladas');
        $fechasDivididas = explode('%', $fechasTabulada);
        $elementosGraficar = array();
        $infoDividida = explode('%', $informacionTabulada);
        $infoDividida2 = explode(':', $infoDividida[0]);
        if ($infoDividida2[1] == 0) {
            for ($i = 1; $i < sizeof($infoDividida); $i++) {
                $temporal = explode(':', $infoDividida[$i]);
                $elementosGraficar[$i] = array($temporal[0], $temporal[1]);
            }

            Excel::create('Información graficada', function($excel) use ($elementosGraficar, $fechasDivididas) {
                $excel->setTitle('Tabla de información');

                $excel->setCreator('CENAC');

                $excel->setDescription('Tabla que contiene la información graficada');

                $excel->sheet('Información', function($sheet) use ($elementosGraficar, $fechasDivididas) {

                    $sheet->fromArray($elementosGraficar, null, 'A2');
                    $sheet->row(1, array(
                        $fechasDivididas[0], ''
                    ));

                    $sheet->row(2, array(
                        'Nombre', 'Cantidad de sistemas'
                    ));
                    $sheet->cells('A1:B2', function($cells) {
                        $cells->setBackground('#1974A9');
                        $cells->setAlignment('center');
                        $cells->setFontColor('#ffffff');
                        $cells->setFont(array('bold' => true));
                    });
                });
            })->export('xlsx');
        } else {
            $cantidadMedia = sizeof($infoDividida) / 2;
            for ($i = 1; $i < $cantidadMedia; $i++) {
                $valorTem = $cantidadMedia + $i;
                $temporal = explode(':', $infoDividida[$i]);
                $temporal2 = explode(':', $infoDividida[$valorTem]);
                $elementosGraficar[$i] = array($temporal[0], $temporal[1], $temporal2[0], $temporal2[1]);
            }

            Excel::create('Información graficada', function($excel) use ($elementosGraficar, $fechasDivididas) {
                $excel->setTitle('Tabla de información');

                $excel->setCreator('CENAC');

                $excel->setDescription('Tabla que contiene la información graficada');

                $excel->sheet('Información', function($sheet) use ($elementosGraficar, $fechasDivididas) {

                    $sheet->fromArray($elementosGraficar, null, 'A2');
                    $sheet->row(1, array(
                        $fechasDivididas[0], '', $fechasDivididas[0], ''
                    ));
                    $sheet->row(2, array(
                        'Nombre', 'Cantidad de sistemas', 'Nombre', 'Cantidad de sistemas'
                    ));
                    $sheet->cells('A1:D2', function($cells) {
                        $cells->setBackground('#1974A9');
                        $cells->setAlignment('center');
                        $cells->setFontColor('#ffffff');
                        $cells->setFont(array('bold' => true));
                    });
                });
            })->export('xlsx');
        }
    }

}
