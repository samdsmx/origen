<?php

namespace App\Http\Controllers;

use DB, Auth, View, Session, Request, Redirect, DateTime, Response, Validator, Collection,
App\Http\Models\casosModel,App\Http\Models\camposModel;
use PDF;
use Excel;


class ConsultasController extends BaseController {

	public function getIndex() {
		if (!parent::tienePermiso('Consultas')) {
			return Redirect::to('inicio');
		}
		$menu = parent::createMenu();
		$consejeras = $this->obtenerConsejerasAll();
		$motivos = DB::table('campos')
			->select('Nombre','Tipo')->where('Tipo','like','%AYUDA%')
			->get();
		return View::make('consultas.casos', array('menu' => $menu, 'consejeras' => $consejeras
			, 'motivos' => $motivos));	
		//return View::make('consultas.llamadas', array('menu' => $menu, 'modificarFuera' => parent::tienePermiso('Modificar fuera del periodo')));
	}
	
	public function postConsultarllamadas(){
        if (!Request::ajax()) {
            return;
        }
		$datos = Request::all();
		$resultados = $this->obtenerLlamadas($datos);
		return $resultados;
    }

    public function obtenerLlamadas($datos){
		if($datos['id'] == '') {
			$identificador = ['casos.IDCaso','>',0];
		} else {
			$identificador = ['casos.IDCaso','=',$datos['id']];
		}
		$nombre = ['casos.Nombre','like','%'.$datos['nombre'].'%'];
		if($datos['consejera'] > 0) {
			$consejera = ['consejeros.id_persona','=', $datos['consejera'] ];
		} else {
			$consejera = ['consejeros.id_persona','>', 0];
		}

		if($datos['fechaFinal'] === '') {
			$hoy = date('Y/m/d');
			$fechaFin = ['FechaLlamada','<',$hoy];
		} else {
			$fechaFin = ['FechaLlamada','<',$datos['fechaFinal']];
		}

		if($datos['fechaInicial'] === '') {
			$ano_anterior = mktime(0, 0, 0, date("m"),   date("d"), "1960");
			$fechaInicial = ['FechaLlamada','>',$ano_anterior];
		} else {
			$fechaInicial = ['FechaLlamada','>',$datos['fechaInicial']];
		}

		$ayuda = ['%%','%%','%%','%%'];
		if($datos['tema'] !== '') {
			foreach(explode(',',$datos['tema']) as $llave => $tema) {
				if($tema != ''){
					$tema_div = explode('-',$tema);
					switch($tema_div[0]) {
						case 'AYUDALEGAL':
							$ayuda[0] = $ayuda[0].$tema_div[1].'%';
							break;
						case 'AYUDAPSICOLOGICO':
							$ayuda[1] = $ayuda[1].$tema_div[1].'%';
							break;
						case 'AYUDAMEDICA':
							$ayuda[2] = $ayuda[2].$tema_div[1].'%';
							break;
						case 'AYUDAOTRO':
							$ayuda[3] = $ayuda[3].$tema_div[1].'%';
							break;
					}
				}
			}
		}
		
 		$llamadas_casos = DB::table('llamadas')
						->join('casos','casos.IDCaso','=','llamadas.IDCaso')
						->join('consejeros','llamadas.Consejera','=','consejeros.nombre')
						->join('persona','consejeros.id_persona','=','persona.id_persona')
						->select('casos.*','llamadas.*')
						->select('casos.IDCaso','casos.Telefono','Horainicio','LlamadaNo','casos.Nombre','FechaLlamada','nombres','primer_apellido','segundo_apellido')
						->where($identificador[0],$identificador[1],$identificador[2])
						->where($nombre[0],$nombre[1],$nombre[2])
						->where($consejera[0],$consejera[1],$consejera[2])
						->where($fechaFin[0],$fechaFin[1],$fechaFin[2])
						->where($fechaInicial[0],$fechaInicial[1],$fechaInicial[2])
						->where('llamadas.AyudaLegal','like',$ayuda[0])
						->where('llamadas.AyudaPsicologico','like',$ayuda[1])
						->where('llamadas.AyudaMedica','like',$ayuda[2])
						->where('llamadas.AyudaOtros','like',$ayuda[3])
						->groupBy('llamadas.IDCaso')
						->get();
						//->toSql();
		return $llamadas_casos;
    }



	public function obtenerConsejerasAll() {
		$consejeras = DB::table('persona')->select('id_persona','primer_apellido'
			,'segundo_apellido','nombres')->get();
		return $consejeras;
	}

	public function getConsultasistemas($tipo, $period, $selectFiltro, $respuestaFiltro, $comparador) {
		if (!parent::tienePermiso('Consultas')) {
			return Redirect::to('inicio');
		}

		$text_select_periodo = "<select class=\"select2\" name=\"periodo_filter\" id=\"periodo_filter\" >";
		$text_select_periodo.="<option value = \"0\">-- TODOS --</option>";
		$opcionesPregunta = DB::select('select p.id_propiedad, p.descripcion, p.id_tipo from propiedad p');
		foreach ($periodos as $per) {
			if ($periodo != null && $per->id_periodo == $periodo->id_periodo) {
				$text_select_periodo.="<option value=\"" . $per->id_periodo . "\" selected >" . $per->comentarios . " (" . $per->fecha_inicio . " - " . $per->fecha_fin . ")</option>";
			} else {
				$text_select_periodo.="<option value=\"" . $per->id_periodo . "\">" . $per->comentarios . " (" . $per->fecha_inicio . " - " . $per->fecha_fin . ")</option>";
			}
		}
		$text_select_periodo.="</select>";


	
		$menu = parent::createMenu();
		$dentroDelPeriodo = !($periodo == null || strtotime("now") < strtotime($periodo->fecha_inicio) || strtotime("now") > strtotime($periodo->fecha_fin));
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

				$sistemas = DB::select('select 5');
				
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
		$grupos = DB::select('select 5');
		$fecha = getdate();
		$periodo = DB::select("select 5");
		$sistema = DB::select("select 5");
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
		$respuestas = DB::select("SELECT 5");
		return $respuestas;
	}

	public function verSistema($id) {
		$menu = parent::createMenu();
		$id = intval($id);
		// Mejorar para consultar de diferentes periodos
		$secciones = parent::obtieneRespuestas($sistemaPeriodo->id_sistema_periodo);
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
			$busqueda = DB::select('select 5');
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
				$persona = personaModel::find($usuario);
				$existenciaPrevia = DB::select("select 5");
				if (sizeof($persona) > 0 && sizeof($sistemas) > 0 && sizeof($existenciaPrevia) == 0) {
					$sistemaPersona = new personaSistemaModel();
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
				$persona = personaModel::find($usuario);
				$sistemas = sistemaModel::find($sistema);
				if (sizeof($persona) > 0 && sizeof($sistemas) > 0) {
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

	public function getFollowcalls($id) {
		$llamadas_casos = DB::table('llamadas')
						->join('casos','casos.IDCaso','=','llamadas.IDCaso')
						->join('consejeros','llamadas.Consejera','=','consejeros.nombre')
						->join('persona','consejeros.id_persona','=','persona.id_persona')
						->select('casos.*','llamadas.*')
						->select('casos.IDCaso','llamadas.LlamadaNo','Horainicio','FechaLlamada','nombres','primer_apellido','segundo_apellido')
						->where('llamadas.IDCaso',$id)
						->get();
						//->toSql();
		return $llamadas_casos;
	}

}
