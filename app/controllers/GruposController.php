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
class GruposController extends BaseController {

    public function getIndex() {
        if (!parent::tienePermiso(3)) {
            return Redirect::to('inicio');
        }
        $menu = parent::createMenu();
        $grupos = DB::select(
                        'select g.*, p.id_grupo conPropiedad ' .
                        'from sia_cat_grupo g ' .
                        'left join sia_cat_propiedad p on p.id_grupo = g.id_grupo group by g.id_grupo ' .
                        'order by -g.orden DESC, g.grupo ASC');
        return View::make('grupos.grupos', array('menu' => $menu, 'grupos' => $grupos));
    }

    public function postBuscar() {
        if (Request::ajax()) {
            $grupo = siaGrupoModel::find(Input::get('id'));
            if ($grupo) {
                return Response::json(array('grupo' => $grupo));
            } else {
                return Redirect::to('Grupos')->with('mensajeError', 'Error al buscar la sección/grupo')->with('tituloMensaje', '¡Error!');
            }
        }
    }

    public function postEliminar() {
        if (Request::ajax()) {
            $grupo = siaGrupoModel::find(Input::get('modalConfirmaId'));
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
        $datos = Input::all();
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
