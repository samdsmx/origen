<?php

namespace App\Http\Controllers;

use DB, Auth, View, Session, Request, Redirect, DateTime, Response, Validator;

class UsuariosController extends BaseController {

    public function getIndex() {
        if (!parent::tienePermiso('Usuarios')) {
            return Redirect::to('inicio');
        }
        $menu = parent::createMenu();
        $datos = DB::select('select '.
            'u.id_usuario, u.nombre usuario, concat(p.nombres,\' \', p.primer_apellido, \' \', p.segundo_apellido) nombre, u.status '.
            'from consejeros u ' .
            'join persona p on p.id_persona = u.id_persona ' .
            'group by p.id_persona');
        return View::make('usuarios.usuarios', array('menu' => $menu, 'usuarios' => $datos));
    }

    public function getCambia($id) {
        $usuario = User::find($id);
        $usuario->status = ($usuario->status - 1) * -1;
        $usuario->save();
        return Redirect::to('Usuarios');
    }

    public function postBuscar() {
        if (!Request::ajax()) {
            return;
        }
        $id = Request::get('id_user');
        $datos = DB::select('select u.id_usuario, p.nombres,  p.primer_apellido, p.segundo_apellido, p.curp, p.correo, p.telefono, u.nombre usuario '
                        . 'from consejeros u join persona p on  p.id_persona = u.id_persona where u.id_usuario = ' . $id);
        if (sizeof($datos) > 0) {
            return Response::json(array('usuario' => $datos[0]));
        }
    }

    public function postEliminar() {
        if (!Request::ajax()) {
            return;
        }
        $mensaje = "";
        $usuario = User::find(Request::get('modalConfirmaId'));
        if ($usuario) {
            $usuAct = usuarioActividadModel::where('id_usuario', '=', $usuario->id_usuario)->get();
            foreach ($usuAct as $ua) {
                $ua->delete();
            }
            $persona = personaModel::find($usuario->id_persona);
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
        $datos = Request::all();
        $validator = User::validar($datos);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->errors()->toArray()));
        }
        $msg = "";
        if (empty($datos["id_user"])) {
            $usuario = new User();
            $persona = new personaModel();
            $persona->status = 1;
            $usuario->status = 1;
            $msg = User::validarDuplicidad($datos,$usuario,$persona);
        } else {
            $usuario = User::find($datos["id_user"]);
            $persona = personaModel::find($usuario->id_persona);
        }
        if (!empty($msg)) {
            return Response::json(array('errors' => $msg));
        }
        $persona->primer_apellido = $datos["apaterno"];
        $persona->segundo_apellido = $datos["amaterno"] == null ? '' : $datos["amaterno"];
        $persona->nombres = $datos["nombres"];
        $persona->curp = $datos["curp"];
        $persona->correo = $datos["correo"];
        $persona->telefono = $datos["telefono"];
        $persona->save();
        $usuario->id_persona = $persona->id_persona;
        $usuario->nombre = $datos["usuario"];
        if ($datos['pass'] != null) {
            $usuario->password = $datos["pass"];
        }
        $usuario->save();
        Session::flash('mensaje', 'Usuario actualizado');
    }

}
