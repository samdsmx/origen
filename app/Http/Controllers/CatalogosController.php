<?php

namespace App\Http\Controllers;

use DB, Auth, View, Session, Request, Redirect, DateTime, Response, Validator;

class CatalogosController extends BaseController {

    public function getIndex() {
        if (!parent::tienePermiso('Catalogos')) {
            return Redirect::to('inicio');
        }
        $menu = parent::createMenu();
        $tipos = DB::select('select Tipo from campos group by Tipo order by Tipo ASC');
        $campos = parent::obtenerCampos($tipos[0]->Tipo);
        return View::make('catalogos.catalogos', array('menu' => $menu, 'campos' => $campos, 'tipos' => $tipos));
    }

    public function postFiltro() {
        if (!Request::ajax()) {
            return;
        }
        $datos = Request::all();
        $campos = parent::obtenerCampos($datos['tipo']);
        if ($campos) {               
            $view = View::make('catalogos.catalogos', array('menu' => [], 'campos' => $campos, 'tipos' => []));
            return $view->renderSections()['tableContent'];
        } else {
            return Redirect::to('Catalogos')->with('mensajeError', 'Error al buscar la sección/grupo');
        }
        return;
    }

    public function postBuscar() {
        if (Request::ajax()) {
            $grupo = siaGrupoModel::find(Request::get('id'));
            if ($grupo) {
                return Response::json(array('grupo' => $grupo));
            } else {
                return Redirect::to('Grupos')->with('mensajeError', 'Error al buscar la sección/grupo')->with('tituloMensaje', '¡Error!');
            }
        }
    }

    public function postEliminar() {
        if (Request::ajax()) {
            $grupo = siaGrupoModel::find(Request::get('modalConfirmaId'));
            if ($grupo) {
                $grupo->delete();
                Session::flash('mensaje', 'Grupo eliminado');
            } else {
                Session::flash('mensajeError', "Error al tratar de eliminar el grupo");
            }
        }
    }

    public function getCambia($id) {
        $grupo = siaGrupoModel::find($id);
        $propiedades = siaPropiedadModel::where('id_grupo', '=', $grupo->id_grupo)->where('status', '=', 1)->get();
        if (sizeof($propiedades) == 0) {
            $grupo->status = ($grupo->status - 1) * -1;
            $grupo->save();
            Session::flash('mensaje', 'Estatus modificado con éxito');
        } else {
            Session::flash('mensajeError', 'No se puede cambiar el estado del grupo porque tiene propiedades activas asignadas');
        }
        return Redirect::to('Grupos');
    }

    public function postRegistragrupo() {
        if (!Request::ajax()) {
            return;
        }
        $datos = Request::all();
        $validator = siaGrupoModel::validar($datos);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->errors()->toArray()));
        }
        if ($datos["id_grupo"] == "") {
            $grupo = new siaGrupoModel(null,1);
            Session::flash('mensaje', 'Grupo agregado');
        } else {
            $grupo = siaGrupoModel::find($datos["id_grupo"]);
            Session::flash('mensaje', 'Grupo modificado');
        }
        $msg = siaGrupoModel::validarDuplicidad($datos,$grupo);
        if (!empty($msg)) {
            return Response::json(array('errors' => $msg));
        }
        $grupo->grupo = $datos["grupo"];
        $grupo->orden = $datos["orden"] == '' ? null : intval($datos["orden"]);
        $grupo->save();
    }

}
