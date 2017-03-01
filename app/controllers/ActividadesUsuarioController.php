<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ActividadesUsuarioController
 *
 * @author Angel
 */
class ActividadesUsuarioController extends BaseController {

    public function getIndex() {
        if (!parent::tienePermiso(7)) {
            return Redirect::to('inicio');
        }
        $menu = parent::createMenu();
        $datos = DB::select('select u.id_usuario, u.usuario, concat(p.nombres,\' \', p.primer_apellido, \' \', p.segundo_apellido) nombre, ur.nombre_ur unidad, u.status, r.id_persona + ps.id_persona conRespuesta  ' .
                        'from sia_usuario u ' .
                        'join sia_persona p on  p.id_persona = u.id_persona ' .
                        'join sia_cat_unidad_responsable ur on ur.id_unidad_responsable = p.id_unidad_responsable ' .
                        'left join sia_respuesta r on r.id_persona = p.id_persona ' .
                        'left join sia_aso_persona_sistema ps on ps.id_persona = p.id_persona ' .
                        'group by p.id_persona');
        $urs = siaUnidadResponsableModel::where('status', '=', 1)->orderBy('nombre_ur', 'asc')->get();
        return View::make('actividadesusuario.actividadesusuario', array('menu' => $menu, 'usuarios' => $datos, 'urs' => $urs));
    }

    public function getCambia($id) {
        $usuario = User::find($id);
        $usuario->status = ($usuario->status - 1) * -1;
        $usuario->save();
        return Redirect::to('ActividadesUsuario');
    }

    public function postBuscar() {
        if (Request::ajax()) {
            $id = Input::get('id_user');
            error_log($id);
            $datos = DB::select('select u.id_usuario, p.nombres,  p.primer_apellido, p.segundo_apellido, p.curp, p.correo, p.telefono, p.id_unidad_responsable, ur.nombre_ur, u.usuario '
                            . 'from sia_usuario u join sia_persona p on  p.id_persona = u.id_persona join sia_cat_unidad_responsable ur on '
                            . 'ur.id_unidad_responsable = p.id_unidad_responsable where u.id_usuario = ' . $id);
            if (sizeof($datos) > 0) {
                return Response::json(array('usuario' => $datos[0]));
            }
        }
    }

    public function postEliminar() {
        if (!Request::ajax()) {
            return;
        }
        $mensaje = "";
        $usuario = User::find(Input::get('modalConfirmaId'));
        if ($usuario) {
            $usuAct = siaAsoUsuarioActividadModel::where('id_usuario', '=', $usuario->id_usuario)->get();
            foreach ($usuAct as $ua) {
                $ua->delete();
            }
            $persona = siaPersonaModel::find($usuario->id_persona);
            $usuario->delete();
            $persona->delete();
            Session::flash('mensaje', 'Usuario eliminado' . $mensaje);
        } else {
            Session::flash('mensajeError', "Error al tratar de eliminar al usuario");
        }
    }

    public function postRegistrausuario() {
        if (!Request::ajax()) {
            return;
        }
        $datos = Input::all();
        $validator = User::validar($datos);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->errors()->toArray()));
        }
        if (empty($datos["id_user"])) {
            $usuario = new User();
            $persona = new siaPersonaModel();
            $persona->status = 1;
            $usuario->status = 1;
        } else {
            $usuario = User::find($datos["id_user"]);
            $persona = siaPersonaModel::find($usuario->id_persona);
        }
        $msg = User::validarDuplicidad($datos,$usuario,$persona);
        if (!empty($msg)) {
            return Response::json(array('errors' => $msg));
        }
        $persona->primer_apellido = $datos["apaterno"];
        $persona->segundo_apellido = $datos["amaterno"] == null ? '' : $datos["amaterno"];
        $persona->nombres = $datos["nombres"];
        $persona->curp = $datos["curp"];
        $persona->correo = $datos["correo"];
        $persona->telefono = $datos["telefono"];
        $persona->id_unidad_responsable = $datos["ur"];
        $persona->save();
        $usuario->id_persona = $persona->id_persona;
        $usuario->usuario = $datos["usuario"];
        if ($datos['pass'] != null) {
            $usuario->password = $datos["pass"];
        }
        $usuario->save();
        Session::flash('mensaje', 'Usuario actualizado');
    }

}
