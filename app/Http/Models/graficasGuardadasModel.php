<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;

class graficasGuardadasModel extends Model{

	public static function getGraficas() {
		$graficasGuardadas = array
		    (
		    array('id' => 1, 'nombre' => 'Altas, bajas y cambios en los sistemas', 'tipoGrafica' => 3),
		    array('id' => 2, 'nombre' => 'Sistema completos vs imcompletos', 'tipoGrafica' => 2),
		    array('id' => 3, 'nombre' => 'Personalizada', 'tipoGrafica' => 0)
		);
		return $graficasGuardadas;
	}

	public static function getInfoGraficas($id) {
		$graficasGuardadas = array
		    (
		    array('id' => 1, 'nombre' => 'Altas, bajas y cambios en los sistemas', 'tipoGrafica' => 3),
		    array('id' => 2, 'nombre' => 'Sistema completos vs imcompletos', 'tipoGrafica' => 2),
		    array('id' => 3, 'nombre' => 'Personalizada', 'tipoGrafica' => 0)
		);
		$resultado = array();
		foreach ($graficasGuardadas as $key => $value) {
			$indice = array_search($id, $value);
			if ($indice) {
				$resultado[] = $graficasGuardadas[$key];
			}
		}

		return $resultado[0];
	}

	public static function getInfoElementos($idGrafica) {
		$elementosBase = array
		    (
		    array(1, 1, 'Baja', ' select count(*) cuenta FROM aso_sistema_periodo s left join observacion o on s.id_observacion = o.id_observacion left join periodo p on s.id_periodo = p.id_periodo', 'p.status = 1 and o.descripcion = "Baja"'),
		    array(2, 1, 'Sin cambio', ' select count(*) cuenta FROM aso_sistema_periodo s left join observacion o on s.id_observacion = o.id_observacion left join periodo p on s.id_periodo = p.id_periodo', 'p.status = 1 and o.descripcion = "Sin Cambio"'),
		    array(3, 1, 'Actualizado', ' select count(*) cuenta FROM aso_sistema_periodo s left join observacion o on s.id_observacion = o.id_observacion left join periodo p on s.id_periodo = p.id_periodo', 'p.status = 1 and o.descripcion = "Actualizado"'),
		    array(4, 1, 'Nuevo', 'select count(*) cuenta FROM aso_sistema_periodo s left join observacion o on s.id_observacion = o.id_observacion left join periodo p on s.id_periodo = p.id_periodo', 'p.status = 1 and o.descripcion = "Nuevo"'),
		    array(5, 1, 'Migración', 'select count(*) cuenta FROM aso_sistema_periodo s left join observacion o on s.id_observacion = o.id_observacion left join periodo p on s.id_periodo = p.id_periodo', 'p.status = 1 and o.descripcion = "Migracion"'),
		    array(6, 2, 'Incompletos', 'select count(*) cuenta from sistema ss left join aso_sistema_periodo sasp on ss.id_sistema = sasp.id_sistema left join periodo sp on sp.id_periodo = sasp.id_periodo ', 'ss.status = 1 and (ss.id_fase = 1 or ss.id_fase = 3)'),
		    array(7, 2, 'Completos', 'select count(*) cuenta from sistema ss left join aso_sistema_periodo sasp on ss.id_sistema = sasp.id_sistema left join periodo sp on sp.id_periodo = sasp.id_periodo ', 'ss.status = 1 and (ss.id_fase = 2 or ss.id_fase = 4)')
		);
		$resultado = array();
		foreach ($elementosBase as $key => $value) {
			$indice = $idGrafica == $value[1] ? true : false;
			if ($indice) {
				$resultado[] = $elementosBase[$key];
			}
		}
		return $resultado;
	}

}
