<?php

namespace App\Http\Controllers;

use DB, Auth, View, Session, Request, Redirect, DateTime, Response, Validator;

class PermisosUsuariosController extends BaseController {

    public function getIndex() {
        if (!parent::tienePermiso('Permisos de usuario')) {
            return Redirect::to('inicio');
        }
        $menu = parent::createMenu();
        $usUr = DB::select(
                        'select u.id_usuario, u.usuario, ur.nombre_corto, '
                        . 'group_concat('
                        . 'CONCAT_WS(\'|\',COALESCE(act.nombre,\'\'),'
                        . 'COALESCE(DATE_FORMAT(aso.fecha_inicio, \'%y-%m-%d\' ),\' --- \' ),'
                        . 'COALESCE(DATE_FORMAT(aso.fecha_fin,    \'%y-%m-%d\' ),\' --- \' ),'
                        . 'COALESCE(aso.id_usuario_actividad,\'\'),COALESCE(act.status,\'\')'
                        . ')'
                        . ' order by act.id_actividad asc ) permisos ' .
                        'from sia_usuario u ' .
                        'join sia_persona p on u.id_persona = p.id_persona ' .
                        'join sia_cat_unidad_responsable ur on p.id_unidad_responsable = ur.id_unidad_responsable ' .
                        'left join sia_aso_usuario_actividad aso on u.id_usuario = aso.id_usuario and aso.status = 1 ' .
                        'left join sia_cat_actividad act on act.id_actividad = aso.id_actividad ' .
                        'where u.status = 1 ' .
                        'group by u.id_usuario ' .
                        'order by ur.nombre_corto asc ' 
        );
        $actividades = siaActividadModel::select('id_actividad', 'nombre', 'descripcion')->where('status', '=', 1)->get();
        self::var_error_log($actividades->toArray());
        return View::make('permisosusuarios.permisosusuarios', array('menu' => $menu, "usuarios" => $usUr, "actividades" => $actividades->toArray()));
    }

    private function var_error_log($object = null) {
        ob_start();                    // start buffer capture
        var_dump($object);           // dump the values
        $contents = ob_get_contents(); // put the buffer into a variable
        ob_end_clean();                // end capture
        error_log($contents);        // log contents of the result of var_dump( $object )
    }

    public function postQuitapermiso() {
        if (Request::ajax()) {
            $datosForm = Request::all();
            $permiso = siaAsoUsuarioActividadModel::where('id_usuario_actividad', '=', $datosForm['id'])->first();
            $hoy = new DateTime('today');
            $creado = new DateTime($permiso->created_at);
            $interval = $creado->diff($hoy);
            $dias = $interval->format('%a');
            if ($dias == 0) {
                $permiso->delete();
                $mensaje = "Permiso eliminado";
                Session::flash('mensaje', $mensaje);
            } else {
                $permiso->status = 0;
                $permiso->save();
                $mensaje = "Permiso cancelado";
                Session::flash('mensaje', $mensaje);
            }
            return Response::json(array('mensaje' => $mensaje));
        }
    }

    public function postRegistrapermiso() {
        if (Request::ajax()) {
            $todos = Request::all();
            $rules = array('permiso' => "required|numeric");
            $mensajes = array(
                'permiso.required' => "Especifique el permiso",
                'permiso.numeric' => "Permiso invalido"
            );
            $validator = Validator::make($todos, $rules, $mensajes);
            if ($validator->fails()) {
                return Response::json(array('errors' => $validator->errors()->toArray()));
            }
            $mensaje = "";
            $usuarios = $todos["usuarios"];
            foreach ($usuarios as $usu) {
                $u = explode(',', $usu);
                $permUs = siaAsoUsuarioActividadModel::where('status', '=', 1)->where("id_usuario", '=', $u[0])->where('id_actividad', '=', $todos["permiso"])->get();
                if (sizeof($permUs) == 0) {
                    $permUs = new siaAsoUsuarioActividadModel ();
                    $permUs->id_usuario = intval($u[0]);
                    $permUs->id_actividad = intval($todos["permiso"]);
                    $permUs->status = 1;
                    $mensaje.="Permiso agregado a <i>" . $u[1] . "</i> con éxito.<br/><br/>";
                } else {
                    $mensaje.="Se actualizo el permiso de <i>" . $u[1] . "</i>.<br/><br/>";
                    $permUs = $permUs[0];
                }
                $permUs->fecha_inicio = ((strlen($todos["fecha_inicio"]) != 0) ? $todos["fecha_inicio"] : null);
                $permUs->fecha_fin = ((strlen($todos["fecha_fin"]) != 0) ? $todos["fecha_fin"] : null);
                $permUs->save();
            }
            $mensaje = substr($mensaje, 0, -5);
            Session::flash('mensaje', $mensaje);
            return Response::json(array('mensaje' => $mensaje));
        }
    }

}
