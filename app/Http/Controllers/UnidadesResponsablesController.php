<?php

namespace App\Http\Controllers;

use DB, Auth, View, Session, Request, Redirect, DateTime, Response, Validator;

class UnidadesResponsablesController extends BaseController {

    public function getIndex() {
        if (!parent::tienePermiso('Unidades Responsables')) {
            return Redirect::to('inicio');
        }
        $menu = parent::createMenu();
        $urs = DB::select("SELECT u.*, p.id_unidad_responsable conPersona,CONCAT_WS(' ',p2.nombres,p2.primer_apellido,p2.segundo_apellido) persona" .
                        "  FROM sia_cat_unidad_responsable u" .
                        "  left join sia_persona p on p.id_unidad_responsable = u.id_unidad_responsable" .
                        "  left join sia_persona p2 on p2.id_unidad_responsable = u.id_unidad_responsable and p2.status = 1" .
                        "  group by u.id_unidad_responsable");
        return View::make('unidadesresponsables.unidadesresponsables', array('menu' => $menu, 'urs' => $urs));
    }

    public function getCambia($id) {
        $ur = siaUnidadResponsableModel::find($id);
        $ur->status = ($ur->status - 1) * -1;
        $ur->save();
        return Redirect::to('UnidadesResponsables');
    }

    public function postRegistraur() {
        if (Request::ajax()) {
            $datos = Request::all();
            $validator = siaUnidadResponsableModel::validar($datos);
            if ($validator->fails()) {
                return Response::json(array('errors' => $validator->errors()->toArray()));
            }
            if (strcmp($datos["id_unidad_responsable"], "") == 0) {
                $ur = new siaUnidadResponsableModel();
                $ur->status = 1;
                Session::flash('mensaje', 'Unidad responsable agregada');
            } else {
                $ur = siaUnidadResponsableModel::find(intval($datos["id_unidad_responsable"]));
                Session::flash('mensaje', 'Unidad responsable modificada');
            }
            $msg = siaUnidadResponsableModel::validarDuplicidad($datos,$ur);
            if (!empty($msg)) {
                return Response::json(array('errors' => $msg));
            }
            $ur->nombre_ur = $datos["nombre_ur"];
            $ur->nombre_corto = $datos["nombre_corto"];
            $ur->save();
        }
    }

    public function postBuscar() {
        if (Request::ajax()) {
            $ur = siaUnidadResponsableModel::find(Request::get('id'));
            if ($ur) {
                return Response::json(array('ur' => $ur));
            }
        }
    }

    public function postEliminar() {
        if (!Request::ajax()) {
            return;
        }
        $ur = siaUnidadResponsableModel::find(Request::get('modalConfirmaId'));
        if ($ur) {
            $ur->delete();
            Session::flash('mensaje', 'Unidad responsable eliminada');
        } else {
            Session::flash('mensajeError', "Error al tratar de eliminar la Unidad Responsable");
        }
    }

}
