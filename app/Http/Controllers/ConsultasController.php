<?php

namespace App\Http\Controllers;

use DB, Auth, View, Session, Request, Redirect, DateTime, Response, Validator, Collection;
use PDF;
use Excel;

class ConsultasController extends BaseController {

	public function getIndex() {
		if (!parent::tienePermiso(9)) {
			return Redirect::to('inicio');
		}
		$menu = parent::createMenu();
		$periodo = siaPeriodoModel::where('status', '=', 1)->orderBy('fecha_inicio', 'desc')->first();
		$text_select_periodo = "<select class=\"select2\" name=\"periodo_filter\" id=\"periodo_filter\" >";
		$text_select_periodo.="<option value = \"0\">-- TODOS --</option>";
		$periodos = siaPeriodoModel::orderBy('fecha_inicio', 'desc')->get();
		$opcionesPregunta = DB::select('select p.id_propiedad, p.descripcion, p.id_tipo from sia_cat_propiedad p');
		foreach ($periodos as $per) {
			if ($periodo != null && $per->id_periodo == $periodo->id_periodo) {
				$text_select_periodo.="<option value=\"" . $per->id_periodo . "\" selected >" . $per->comentarios . " (" . $per->fecha_inicio . " - " . $per->fecha_fin . ")</option>";
			} else {
				$text_select_periodo.="<option value=\"" . $per->id_periodo . "\">" . $per->comentarios . " (" . $per->fecha_inicio . " - " . $per->fecha_fin . ")</option>";
			}
		}
		$text_select_periodo.="</select>";
		$sistemas = DB::select('select T2.*, p.comentarios periodo, asp.id_observacion, asp.nota, o.descripcion observacion, r.valor Sistema, r2.valor nombreCompleto, asp.id_sistema_periodo
            from 
            (select s.id_sistema, s.id_fase, s.status, f.descripcion fase, max(asp.id_periodo) id_periodo, GROUP_CONCAT(DISTINCT CONCAT_WS(\'|\',ps.id_persona,concat(p.nombres,\' \', p.primer_apellido, \' \', p.segundo_apellido))) owner
                from sia_sistema s
                LEFT JOIN sia_aso_persona_sistema ps on ps.id_sistema = s.id_sistema
                LEFT JOIN sia_persona p on p.id_persona = ps.id_persona, 
                sia_aso_sistema_periodo asp, sia_cat_fase f
                where f.id_fase = s.id_fase and asp.id_sistema = s.id_sistema group by s.id_sistema) T2,
            sia_periodo p, sia_observacion o, sia_aso_sistema_periodo asp
            LEFT JOIN sia_respuesta r on r.id_sistema_periodo = asp.id_sistema_periodo and r.id_propiedad = 6
            LEFT JOIN sia_respuesta r2 on r2.id_sistema_periodo = asp.id_sistema_periodo and r2.id_propiedad = 5
            where T2.id_periodo = p.id_periodo and asp.id_sistema=T2.id_sistema and asp.id_periodo = T2.id_periodo and o.id_observacion = asp.id_observacion');
		$posiblesResponsables = DB::select('select * from sia_persona where status = 1');
		return View::make('sistemas.sistemas', array('menu' => $menu, "dentroPeriodo" => FALSE, 'periodos' => $text_select_periodo, 'ur_selected' => 0, 'opcionesPregunta' => $opcionesPregunta, 'sistemas' => $sistemas, "idPeriodoActual" => $periodo->id_periodo, 'posiblesResponsables' => $posiblesResponsables, 'modificarFuera' => parent::tienePermiso(11)));
	}

	public function getConsultasistemas($tipo, $period, $selectFiltro, $respuestaFiltro, $comparador) {
		if (!parent::tienePermiso(9)) {
			return Redirect::to('inicio');
		}

		$text_select_periodo = "<select class=\"select2\" name=\"periodo_filter\" id=\"periodo_filter\" >";
		$text_select_periodo.="<option value = \"0\">-- TODOS --</option>";
		$periodos = siaPeriodoModel::orderBy('fecha_inicio', 'desc')->get();
		$opcionesPregunta = DB::select('select p.id_propiedad, p.descripcion, p.id_tipo from sia_cat_propiedad p');
		foreach ($periodos as $per) {
			if ($periodo != null && $per->id_periodo == $periodo->id_periodo) {
				$text_select_periodo.="<option value=\"" . $per->id_periodo . "\" selected >" . $per->comentarios . " (" . $per->fecha_inicio . " - " . $per->fecha_fin . ")</option>";
			} else {
				$text_select_periodo.="<option value=\"" . $per->id_periodo . "\">" . $per->comentarios . " (" . $per->fecha_inicio . " - " . $per->fecha_fin . ")</option>";
			}
		}
		$text_select_periodo.="</select>";


		$condiciones = "where 1 = 1 ";
		if ($period > 0) {
			$condiciones .= "and sasp.id_periodo = " . $period . " ";
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
		$menu = parent::createMenu();
		$periodo = siaPeriodoModel::where('status', '=', 1)->orderBy('fecha_inicio', 'desc')->first();
		$dentroDelPeriodo = !($periodo == null || strtotime("now") < strtotime($periodo->fecha_inicio) || strtotime("now") > strtotime($periodo->fecha_fin));
		$sistemas = DB::select('select T2.*, p.comentarios periodo, asp.id_observacion, asp.nota, o.descripcion observacion, r.valor Sistema, r2.valor nombreCompleto, asp.id_sistema_periodo
            from (select s.id_sistema, s.id_fase, s.status, f.descripcion fase, max(asp.id_periodo) id_periodo
                from sia_sistema s, sia_aso_persona_sistema ps, sia_aso_sistema_periodo asp, sia_cat_fase f
                where f.id_fase = s.id_fase and asp.id_sistema = s.id_sistema and s.id_sistema = ps.id_sistema and ps.id_persona = ' . Auth::user()->persona->id_persona /* 11 */ .
				' group by id_sistema) T2,
            sia_periodo p, sia_observacion o, sia_aso_sistema_periodo asp
            LEFT JOIN sia_respuesta r on r.id_sistema_periodo = asp.id_sistema_periodo and r.id_propiedad = 6
            LEFT JOIN sia_respuesta r2 on r2.id_sistema_periodo = asp.id_sistema_periodo and r2.id_propiedad = 5
            where T2.id_periodo = p.id_periodo and asp.id_sistema=T2.id_sistema and asp.id_periodo = T2.id_periodo and o.id_observacion = asp.id_observacion');
		return View::make('sistemas.sistemas', array('menu' => $menu, "dentroPeriodo" => TRUE, 'periodos' => $text_select_periodo, 'ur_selected' => 0, 'opcionesPregunta' => $opcionesPregunta, 'sistemas' => null));
	}

	private function generaExcel($id) {
		return Excel::create('sistema'.$id, function($excel) use ($id) {
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

	private function generaReporteGeneral() {
		return Excel::create('reporteGeneral', function($excel) {
				$excel->setCreator('Centro Nacional de Calculo');

				$sistemas = DB::select('select T2.*, p.comentarios periodo, asp.id_observacion, asp.nota, o.descripcion observacion, r.valor Sistema, r2.valor nombreCompleto, asp.id_sistema_periodo
            from 
            (select s.id_sistema, s.id_fase, s.status, f.descripcion fase, max(asp.id_periodo) id_periodo, GROUP_CONCAT(DISTINCT CONCAT_WS(\'|\',ps.id_persona,concat(p.nombres,\' \', p.primer_apellido, \' \', p.segundo_apellido))) owner
                from sia_sistema s
                LEFT JOIN sia_aso_persona_sistema ps on ps.id_sistema = s.id_sistema
                LEFT JOIN sia_persona p on p.id_persona = ps.id_persona, 
                sia_aso_sistema_periodo asp, sia_cat_fase f
                where f.id_fase = s.id_fase and asp.id_sistema = s.id_sistema group by s.id_sistema) T2,
            sia_periodo p, sia_observacion o, sia_aso_sistema_periodo asp
            LEFT JOIN sia_respuesta r on r.id_sistema_periodo = asp.id_sistema_periodo and r.id_propiedad = 6
            LEFT JOIN sia_respuesta r2 on r2.id_sistema_periodo = asp.id_sistema_periodo and r2.id_propiedad = 5
            where T2.id_periodo = p.id_periodo and asp.id_sistema=T2.id_sistema and asp.id_periodo = T2.id_periodo and o.id_observacion = asp.id_observacion');
				
				$excel->sheet("reporte", function($sheet) use ($sistemas) {

					$llaves = array(
						"Objetivo del aplicativo de cómputo",
						"Número de usuarios actuales",
						"Área para la que fue desarrollado",
						"¿Cuál es el estado que guarda la aplicación actualmente?",
						"Fecha de entrada en producción",
						"Plataforma y lenguaje de programación en el que se desarrolló el aplicativo de cómputo",
						"Tamaño de memoria asignada (Servidor de aplicación)",
						"Sistema Operativo  (Servidor de aplicación)",
						"Tipo de procesador (Servidor de aplicación)",
						"Seleccionar la Importancia del sistema"
						);
					$sheet->row(1, array_merge(array(
					    'ID', 'NOMBRE COMPLETO', 'NOMBRE CORTO', 'OBSERVACION', 'FASE'), $llaves) );
					$sheet->freezeFirstRow();
					foreach($sistemas as $key => $sistema){
						$propiedadesRes = self::consultaRespuestas($sistema->id_sistema_periodo);

						$json  = json_encode($propiedadesRes);
						$propiedadesRes = json_decode($json, true);
						$roles = collect($propiedadesRes)->keyBy('propiedad');
						//var_dump($roles);
						$array = array();
						for ($i = 0; $i < count($llaves); $i++) {
							if (isset($roles[$llaves[$i]] ) )
								$array[] = $roles[$llaves[$i]]['respuesta'];
							else
								$array[] = "";
						}
						$sheet->row($key+2, array_merge(array($sistema->id_sistema_periodo, $sistema->nombreCompleto, $sistema->Sistema, $sistema->observacion, $sistema->fase), $array));
					}

					
				});
			});
	}

	public function getCrearexcel($id) {
		self::generaExcel($id)->download('xlsx');
	}

	public function getReporte() {
		self::generaReporteGeneral()->download('xlsx');
	}

	public function getCrearpdf($id) {
		$grupos = DB::select('select * from sia_cat_grupo scg left join sia_cat_propiedad scp on scg.id_grupo = scp.id_grupo '
				. 'left join sia_respuesta sr on scp.id_propiedad = sr.id_propiedad '
				. 'where sr.id_sistema_periodo = ' . $id . ' order by scg.id_grupo');
		$fecha = getdate();
		$periodo = DB::select("select * from sia_periodo where status = 1");
		$sistema = DB::select("select scf.descripcion fase, so.descripcion observacion from sia_aso_sistema_periodo sasp right join sia_sistema ss on sasp.id_sistema = ss.id_sistema right join sia_observacion so on sasp.id_observacion = so.id_observacion right join sia_cat_fase scf on ss.id_fase = scf.id_fase where sasp.id_sistema_periodo = " . $id);
		$view = View::make('formato',  array('propiedadesRes' => $grupos, 'fecha' => $fecha, 'autor' => Auth::user(), 'periodo' => $periodo, 'sistema' => $sistema))->render();
//		$pdf = App::make('dompdf.wrapper');
		$pdf = PDF::loadHTML($view);
		return $pdf->download('sistema'.$id.'.pdf');
	}

	public function getData() {
		$data = [
		    'quantity' => '1',
		    'description' => 'some ramdom text',
		    'price' => '500',
		    'total' => '500'
		];
		return $data;
	}

	private function consultaRespuestas($id_sistema_periodo) {
		$respuestas = DB::select("SELECT p.descripcion propiedad, r.valor respuesta
                 FROM sia_respuesta r, sia_cat_propiedad p
                 WHERE p.id_propiedad = r.id_propiedad and r.id_sistema_periodo = " . $id_sistema_periodo);
		return $respuestas;
	}

	public function verSistema($id) {
		$menu = parent::createMenu();
		$id = intval($id);
		$sistemaPeriodo = siaAsoSistemaPeriodoModel::where('id_sistema', '=', $id)->orderBy('id_sistema_periodo', 'desc')->first(); // Mejorar para consultar de diferentes periodos
		$secciones = parent::obtieneRespuestas($sistemaPeriodo->id_sistema_periodo);
		$grupos = siaGrupoModel::select('id_grupo', 'grupo')->where('status', '=', 1)->orderBy('orden', 'asc')->orderBy('grupo', 'asc')->get();
		return View::make('sistemas.ver', array('pantallas' => $secciones, 'id_sistema' => $id, 'menu' => $menu, 'grupos' => $grupos));
	}

	public function construyeOracion($i, $id_pregunta, $grupo, $detalleProp) {
		$arreglo = array();
		$arreglo["pregunta"] = $detalleProp;
		$arreglo["num"] = $i;
		$in = "<input type=\"text\" name=\"" . $grupo . $id_pregunta . "\" value=\"\" style=\"width:100%;\"  readonly />";
		$arreglo["campo"] = $in;
		return $arreglo;
	}

	public function getObtenerlistado($tipo, $info) {
		if (is_numeric($tipo) && is_numeric($info)) {
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

	public function getAgregarResponsable($usuario, $sistema) {
		$fechaAhora = new DateTime(date('Y-m-d H:i:s'));
		$respuesta = array();
		if (is_numeric($usuario) && is_numeric($sistema)) {
			if ($usuario <= 0) {
				$respuesta[] = 'error';
				$respuesta[] = 'Por favor seleccione un usuario valido.';
			} else if ($sistema <= 0) {
				$respuesta[] = 'error';
				$respuesta[] = 'Sistema invalido o inexistente.';
			} else {
				$persona = siaPersonaModel::find($usuario);
				$sistemas = siaSistemaModel::find($sistema);
				$existenciaPrevia = DB::select("select * from sia_aso_persona_sistema where id_persona=" . $usuario . " and id_sistema=" . $sistema);
				if (sizeof($persona) > 0 && sizeof($sistemas) > 0 && sizeof($existenciaPrevia) == 0) {
					$sistemaPersona = new siaAsoPersonaSistemaModel();
					$sistemaPersona->id_sistema = $sistema;
					$sistemaPersona->id_persona = $usuario;
					$sistemaPersona->status = 1;
					$sistemaPersona->updated_at = $fechaAhora;
					$sistemaPersona->created_at = $fechaAhora;
					$sistemaPersona->save();
					$identificador = $sistemaPersona->id_persona_sistema;
					$respuesta[] = 'exito';
					$respuesta[] = 'Usuario agregado con éxito.';
					$respuesta[] = $persona->nombres . ' ' . $persona->primer_apellido . ' ' . $persona->segundo_apellido;
					$respuesta[] = $identificador;
				} else if (sizeof($existenciaPrevia) > 0) {
					$respuesta[] = 'error';
					$respuesta[] = 'Usuario previamente registrado.';
				} else {
					$respuesta[] = 'error';
					$respuesta[] = 'Algunos datos introducidos son incorrectos, intente de nuevo más tarde.';
				}
			}
		} else {
			$respuesta[] = 'error';
			$respuesta[] = 'Algunos datos introducidos son incorrectos, intente de nuevo más tarde.';
		}
		return $respuesta;
	}

	public function getEliminarResponsable($usuario, $sistema) {
		$fechaAhora = new DateTime(date('Y-m-d H:i:s'));
		$respuesta = array();
		if (is_numeric($usuario) && is_numeric($sistema)) {
			if ($usuario <= 0) {
				$respuesta[] = 'error';
				$respuesta[] = 'Por favor seleccione un usuario valido.';
			} else if ($sistema <= 0) {
				$respuesta[] = 'error';
				$respuesta[] = 'Sistema invalido o inexistente.';
			} else {
				$persona = siaPersonaModel::find($usuario);
				$sistemas = siaSistemaModel::find($sistema);
				if (sizeof($persona) > 0 && sizeof($sistemas) > 0) {
					DB::delete("delete from sia_aso_persona_sistema where id_sistema=" . $sistema . " and id_persona=" . $usuario);
					$respuesta[] = 'exito';
					$respuesta[] = 'Usuario eliminado con éxito.';
				} else {
					$respuesta[] = 'error';
					$respuesta[] = 'Algunos datos introducidos son incorrectos, intente de nuevo más tarde.';
				}
			}
		} else {
			$respuesta[] = 'error';
			$respuesta[] = 'Algunos datos introducidos son incorrectos, intente de nuevo más tarde.';
		}
		return $respuesta;
	}

}
