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
class PeriodosController extends BaseController {

    public function getIndex() {
        if (!parent::tienePermiso(4)) {
            return Redirect::to('inicio');
        }
        $menu = parent::createMenu();
        $periodos = DB::select(
                        'select p.*, sp.id_periodo conSistemaPeriodo ' .
                        'from sia_periodo p ' .
                        'left join sia_aso_sistema_periodo sp on p.id_periodo = sp.id_periodo ' .
                        'group by p.id_periodo ' .
                        'order by p.fecha_fin DESC, p.fecha_inicio DESC');
        return View::make('periodos.periodos', array('menu' => $menu, 'periodos' => $periodos));
    }

    public function postBuscar() {
        if (Request::ajax()) {
            $id = Input::get('id');
            $periodo = siaPeriodoModel::find($id);
            if ($periodo) {
                return Response::json(array('periodo' => $periodo));
            } else {
                Session::flash('mensajeError', "Error al tratar de encontrar el periodo");
            }
        }
    }

    public function postEliminar() {
        if (Request::ajax()) {
            $periodo = siaPeriodoModel::find(Input::get('modalConfirmaId'));
            if ($periodo) {
                $periodo->delete();
                Session::flash('mensaje', 'Periodo eliminado');
            } else {
                Session::flash('mensajeError', "Error al tratar de eliminar el periodo");
            }
        }
    }

    public function getCambia($id) {
        $permiso = siaPeriodoModel::find($id);
        if ($permiso->status == 0) {
            $permisos = siaPeriodoModel::all();
            foreach ($permisos as $per) {
                $per->status = 0;
                $per->save();
            }
            $permiso->status = 1;
        } else {
            $permiso->status = 0;
        }
        $permiso->save();
        return Redirect::to('Periodos');
    }

    public function postRegistraperiodo() {
        if (!Request::ajax()) {
            return;
        }
        $datos = Input::all();
        $validator = siaPeriodoModel::validar($datos);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->errors()->toArray()));
        }
        if ($datos["id_periodo"] == "") {
            $periodo = new siaPeriodoModel();
            $periodo->status = 0;
            Session::flash('mensaje', 'Periodo agregado');
        } else {
            $periodo = siaPeriodoModel::find($datos["id_periodo"]);
            Session::flash('mensaje', 'Periodo modificado');
        }
        $msg = siaPeriodoModel::validarDuplicidad($datos, $periodo);
        if (!empty($msg)) {
            return Response::json(array('errors' => $msg));
        }
        $periodo->fecha_inicio = $datos["fecha_inicio"];
        $periodo->fecha_fin = $datos["fecha_fin"];
        $periodo->comentarios = $datos["comentarios"];
        $periodo->save();
    }

}
