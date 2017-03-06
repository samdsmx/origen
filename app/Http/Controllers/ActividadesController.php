<?php

namespace App\Http\Controllers;

use DB, Auth, View, Session, Request, Redirect, DateTime, Response, Validator;

class ActividadesController extends BaseController {

    public function getIndex() {
        if (!parent::tienePermiso(1)){
            return Redirect::to('inicio');
            }
        $menu = parent::createMenu();
        $actividades = siaActividadModel::all();
        return View::make('actividades.actividades', array('menu' => $menu, 'actividades' => $actividades));
    }

    public function getCambia($id) {
        $actividad = siaActividadModel::find($id);
        $actividad->status = ($actividad->status - 1) * -1;
        $actividad->save();
        Session::flash('mensaje', 'Estatus modificado con éxito');
        return Redirect::to('Actividades');
    }

    public function postModificadesc() {
        if (Request::ajax()) {
            $id = Request::get('pk');
            $valor = Request::get('value');
            $actividad = siaActividadModel::find($id);
            if (!preg_match("/^[a-zA-Z0-9 ñáéíóúÑÁÉÍÓÚ]*$/", $valor)) {
                $resp = array(
                    'success' => "false",
                    'msg' => "No permitido",
                    'value' => $actividad->descipcion
                );
                echo json_encode($resp);
            } else {
                $actividad->nombre = $valor;
                $actividad->save();
            }
        }
    }

}
