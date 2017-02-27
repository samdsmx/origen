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
class ConsultasController extends BaseController {

	public function getIndex() {
		if (!parent::tienePermiso(9)) {
			return Redirect::to('inicio');
		}
		$menu = parent::createMenu();
		$periodo = siaPeriodoModel::where('status', '=', 1)->orderBy('fecha_inicio', 'desc')->first();
		$text_select_periodo = "<select class=\"select2\" name=\"periodo_filter\" id=\"periodo_filter\" >";
		$text_select_periodo.="<option value = \"0\">-- TODOS --</option>";
		$periodos = siaPeriodoModel::all();
		$opcionesPregunta = DB::select('select p.id_propiedad, p.descripcion, p.id_tipo from sia_cat_propiedad p');
		foreach ($periodos as $per) {
			if ($periodo != null && $per->id_periodo == $periodo->id_periodo) {
				$text_select_periodo.="<option value=\"" . $per->id_periodo . "\" selected >" . $per->comentarios . " ( " . $per->fecha_inicio . " - " . $per->fecha_fin . " )</option>";
			} else {
				$text_select_periodo.="<option value=\"" . $per->id_periodo . "\">" . $per->comentarios . " ( " . $per->fecha_inicio . " - " . $per->fecha_fin . " )</option>";
			}
		}
		$text_select_periodo.="</select>";
		$sistemas = self::tenerArregloSistemas(0, $periodo->id_periodo, 0, 0, 0);
		return View::make('sistemas.sistemas', array('menu' => $menu, "dentroPeriodo" => TRUE, 'periodos' => $text_select_periodo, 'ur_selected' => 0, 'opcionesPregunta' => $opcionesPregunta, 'sistemas' => $sistemas));
	}

	public function getConsultasistemas($tipo, $periodo, $selectFiltro, $respuestaFiltro, $comparador) {
		$selectFiltroDiv = explode('-', $selectFiltro);
		if (!parent::tienePermiso(9)) {
			return Redirect::to('inicio');
		}
		$validar = Validator::make(
				array('tipo' => $tipo,
			    'periodo' => $periodo,
			    'selectFiltro' => $selectFiltroDiv[0],
			    'comparador' => $comparador
				), array(
			    'tipo' => array('required', 'numeric'),
			    'periodo' => array('required', 'numeric'),
			    'selectFiltro' => array('required', 'numeric'),
			    'comparador' => 'required|max:12'
				)
		);
		if ($validar->fails()) {
			echo 'error';
		} else {
			return self::tenerArregloSistemas($tipo, $periodo, $selectFiltro, $respuestaFiltro, $comparador);
		}
	}

	private function tenerArregloSistemas($tipo, $periodo, $selectFiltro, $respuestaFiltro, $comparador) {
		$condiciones = "where 1 = 1 ";
		if ($periodo > 0) {
			$condiciones .= "and sasp.id_periodo = " . $periodo . " ";
		}
		if ($tipo >= 1 && $tipo <= 5) {
			$condiciones .= "and sasp.id_observacion = " + $tipo + " ";
		}

		if ($selectFiltro != 0) {
			if ($comparador == 0) {
				$comparador = "=";
			}
			$condiciones .= " and sr.id_respuesta = " . $selectFiltro . " and sr.valor " . $comparador . " '" . $respuestaFiltro . "'";
		}

		$sistemas = DB::select("select sasp.id_sistema as sistemaid,  (select valor from sia_respuesta where id_sistema_periodo = sasp.id_sistema_periodo "
				. "and id_propiedad = 5) as sistema, ((select count(*) from sia_respuesta where id_sistema_periodo = sasp.id_sistema_periodo)/(select count(*) "
				. "from sia_cat_propiedad where status = 1))*100 "
				. "as estado, case when sasp.id_observacion = 4 then 'Baja' when "
				. "((select count(*) from sia_respuesta where id_sistema_periodo = sasp.id_sistema_periodo)/(select count(*) "
				. "from sia_cat_propiedad where status = 1)) = 1 and sasp.id_observacion != 4 then 'Activo - Completado' when "
				. "((select count(*) from sia_respuesta "
				. "where id_sistema_periodo = sasp.id_sistema_periodo)/(select count(*) from sia_cat_propiedad where status = 1 and obligatoria = 1)) < 1 "
				. "and sasp.id_observacion != 4 "
				. "then 'Activo - Sin Completar' when sasp.id_observacion = 5 then 'Migración'  when sasp.id_observacion = 3 then 'Actualizado' "
				. "when sasp.id_observacion = 1 then 'Sin Cambios' when sasp.id_observacion = 2 then 'Nuevo' end as status "
				. "from sia_respuesta sr join sia_aso_sistema_periodo sasp "
				. "on sasp.id_sistema_periodo = sr.id_sistema_periodo "
				. $condiciones . ' GROUP BY sasp.id_sistema');
		return $sistemas;
	}

	private function generaExcel($id) {
		return Excel::create('Sistema', function($excel) use ($id) {
				$propiedadesRes = self::consultaRespuestas($id);
				$excel->setCreator('Centro Nacional de Calculo');
				$excel->sheet("sistema", function($sheet) use ($propiedadesRes) {
					$array = array();
					for ($i = 0; $i < count($propiedadesRes); $i++) {
						$array[$i] = array($i + 1, $propiedadesRes[$i]->propiedad, $propiedadesRes[$i]->respuesta);
					}
					$sheet->fromArray($array);
					$sheet->freezeFirstRow();
					$sheet->cells('A1:C1', function($cells) {
						$cells->setBackground('#1974A9');
						$cells->setAlignment('center');
						$cells->setFontColor('#ffffff');
						$cells->setFont(array('bold' => true));
					});

					$sheet->row(1, array(
					    'ID', 'PROPIEDAD', 'RESPUESTA'
					));

					$sheet->freezeFirstRow();

					$sheet->getStyle('B2:B' . count($array))->getAlignment()->setWrapText(true);

					$sheet->cells('A2:C' . count($array), function($cells) {
						$cells->setAlignment('left');
					});
				});
			});
	}

	private function generaPDF($id) {
		return Excel::create('Sistema', function($excel) use ($id) {
				$propiedadesRes = self::consultaRespuestas($id);
				$excel->setCreator('Centro Nacional de Calculo');
				$excel->sheet("sistema", function($sheet) use ($propiedadesRes) {
					$sheet->loadView('formato',array('propiedadesRes' => $propiedadesRes));
				});
			});
	}

	public function getCrearexcel($id) {
		self::generaExcel($id)->download('xlsx');
	}

	public function getCrearpdf($id) {
		self::generaPDF($id)->export('pdf');
	}

	private function consultaRespuestas($id_sistema_periodo) {
		$respuestas = DB::select("SELECT p.descripcion propiedad, r.valor respuesta
                                 FROM sia_respuesta r, sia_cat_propiedad p
                                 WHERE p.id_propiedad = r.id_propiedad and r.id_sistema_periodo = " . $id_sistema_periodo);
		return $respuestas;
	}

	public function verSistema($id) {
		$menu = parent::createMenu();
		$secciones = array();
		$id = intval($id);
		//Se debe ocupar el periodo del que selecciono, por lo que en la consulta se debe mostrar de todos los periodos
		//$sistemaPeriodo = siaAsoSistemaPeriodoModel::where('id_sistema', '=', $id)->where('id_periodo', '=', $periodo->id_periodo)->first();
		$sistemaPeriodo = siaAsoSistemaPeriodoModel::where('id_sistema', '=', $id)->orderBy('id_sistema_periodo', 'desc')->first();
		if ($sistemaPeriodo == NULL) {
			return Response::json(array('titulo' => "Error", 'mensaje' => "Algo ha salido mal. Por favor contacte al administrador del sistema"));
		} else {
			$propiedadesContestadas = siaAsoSistemaPropiedadModel::where('id_sistema', '=', $id)->get();
			if (sizeof($propiedadesContestadas) == 0) {
				// Solo se entro una vez a la creación y no se contesto nada.
				$grupos = siaGrupoModel::select('id_grupo', 'grupo')->where('status', '=', 1)->orderBy('orden', 'asc')->orderBy('id_grupo', 'asc')->get();
				$arregloSeccion = array();
				foreach ($grupos as $g) {
					$arregloSeccion [$g->grupo] = array();
				}
				$pobligatorias = siaPropiedadModel::select('id_propiedad', 'id_tipo', 'id_grupo', 'descripcion')->where('status', '=', 1)->orderBy('orden', 'asc')->orderBy('id_propiedad', 'asc')->get()->toArray();
				$i = 1;
				foreach ($grupos as $grup) {
					$arregloSeccion = &$secciones[$grup->grupo];
					foreach ($pobligatorias as $ind => $prop) {
						// esto ayudara a contruir la pregunta junto con su campo de respuesta
						if ($prop["id_grupo"] == $grup->id_grupo) {
							$arregloSeccion[] = self::construyeOracion($i, $prop['id_propiedad'], $grup["grupo"], $prop['descripcion']);
							$i++;
							unset($pobligatorias[$ind]);
						}
					}
				}
				$group_active = $grupos[0]->grupo;
			} else {
				// Se dejo "a la mitad" el registro del sistema.
				// tendremos que consultar las respuestas del periodo al que estamos haciendo referencia                
				$grupos_anteriores = array();
				$periodo = siaPeriodoModel::where('status', '=', 1)->orderBy('fecha_inicio', 'desc')->first();
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
					$arregloSeccion[] = self::construyeOracionConRespuesta($i, $prop->id_propiedad, $grupo, $prop->id_tipo, $prop->descripcion, $res[0]->valor);
					$i++;
					/* LOGICA PARA SIGUIENTE GRUPO */
					$grupoAnt = $grupo->grupo;
					if (!in_array($grupoAnt, $grupos_anteriores)) {
						$grupos_anteriores[] = $grupoAnt;
					}
				}
				$grupos = siaGrupoModel::select('id_grupo', 'grupo')->where('status', '=', 1)->orderBy('orden', 'asc')->orderBy('id_grupo', 'asc')->get()->toArray();
				foreach ($grupos as $i => $grup) {
					if (in_array($grup["grupo"], $grupos_anteriores)) {
						unset($grupos[$i]);
					}
				}
				$pobligatorias = siaPropiedadModel::select('id_propiedad', 'id_tipo', 'id_grupo', 'descripcion')->where('status', '=', 1)->orderBy('orden', 'asc')->orderBy('id_propiedad', 'asc')->get()->toArray();
				$i = 1;
				foreach ($grupos as $grup) {
					$arregloSeccion = &$secciones[$grup["grupo"]];
					foreach ($pobligatorias as $ind => $prop) {
						if ($prop["id_grupo"] == $grup["id_grupo"]) {
							$arregloSeccion[] = self::construyeOracion($i, $prop['id_propiedad'], $grup["grupo"], $prop['descripcion']);
							$i++;
							unset($pobligatorias[$ind]);
						}
					}
				}
			}
		}
		$grupos = siaGrupoModel::select('id_grupo', 'grupo')->where('status', '=', 1)->orderBy('orden', 'asc')->orderBy('id_grupo', 'asc')->get();
		return View::make('sistemas.ver', array('pantallas' => $secciones, 'id_sistema' => $id, 'menu' => $menu, 'grupos' => $grupos));
	}

	public function construyeOracionConRespuesta($i, $id_pregunta, $grupo, $id_tipo, $detalleProp, $res) {
		$arreglo = array();
		$in = "";
		$arreglo["pregunta"] = $detalleProp;
		$arreglo["num"] = $i;
		if ($id_tipo == 1) { // Abierta
			$in = "<input type=\"text\" name=\"" . $grupo->grupo . $id_pregunta . "\" style=\"width:100%;\" value=\"" . $res . "\" readonly/>";
		} else if ($id_tipo == 2) { // Lista
			$porDefault = siaRespuestaPredefinidaModel::select('id_respuesta_predefinida', 'valor', 'status')->where('id_respuesta_predefinida', '=', $res)->get()->toArray();
			$in = "<input type=\"text\" name=\"" . $grupo->grupo . $id_pregunta . "\" style=\"width:100%\" value=\"" . $porDefault[0]["valor"] . "\"  readonly />";
		}
		$arreglo["campo"] = $in;
		return $arreglo;
	}

	public function construyeOracion($i, $id_pregunta, $grupo, $detalleProp) {
		$arreglo = array();
		$in = "";
		$arreglo["pregunta"] = $detalleProp;
		$arreglo["num"] = $i;
		$in = "<input type=\"text\" name=\"" . $grupo . $id_pregunta . "\" value=\"\" style=\"width:100%;\"  readonly />";
		$arreglo["campo"] = $in;
		return $arreglo;
	}

	public function getObtenerlistado($tipo, $info) {
		if (is_numeric($tipo) && is_numeric($info)) {
			$busqueda = array();
			$busqueda = DB::select('select id_respuesta_predefinida id, valor from sia_cat_respuestas_predefinidas where id_propiedad = ' . $info);
			if (sizeof($busqueda) > 0) {
				return $busqueda;
			} else {
				echo 'error';
			}
		} else {
			echo 'error';
		}
	}

}
