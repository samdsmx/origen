<?php

namespace App\Http\Controllers;

use DB, Auth, View, Session, Request, Redirect, DateTime, Response, Validator, App\Http\Models\camposModel;

class BaseController extends Controller {

    protected function setupLayout() {
        if (!is_null($this->layout)) {
            $this->layout = View::make($this->layout);
        }
    }

    public static function existe($model, $campo, $val, $org = "") {
        $mensaje = array();
        $model="App\Http\Controllers\\".$model;
        if ($val != $org) {
            $registro = $model::where($campo, '=', $val)->first();
            if (!empty($registro)) {
                $mensaje = array($campo => "Valor existente");
            }
        }
        return $mensaje;
    }

    protected function tienePermiso($nombre) {
        if (Auth::guest()){
            return false;
        }
        $actividad = siaActividadModel::where('nombre', '=', $nombre)->where('status', '=', 1)->first();
        $permiso = siaAsoUsuarioActividadModel::where('id_usuario', '=', Auth::user()->id_usuario)->where('id_actividad', '=', $actividad->id_actividad)->where('status', '=', 1)->first();
        if ($actividad && $permiso) {
            $inicio = null;
            $fin = null;
            if (strcmp($permiso->fecha_inicio, "") != 0) {
                $inicio = new DateTime($permiso->fecha_inicio);
            }
            if (strcmp($permiso->fecha_fin, "") != 0) {
                $fin = new DateTime($permiso->fecha_fin);
            }
            $activo1 = ($inicio == null || $inicio->getTimestamp() <= strtotime("now"));
            $activo2 = ($fin == null || $fin->getTimestamp() >= strtotime("now"));
            if (!$activo1 || !$activo2) {
                return false;
            }
        } else {
            return false;
        }
        return true;
    }

    protected function createMenu() {
        $usuario = Auth::user();
        $menu = array();
        $actividadesUsuario = DB::select('select ua.fecha_inicio, ua.fecha_fin, a.nombre, a.descripcion, a.icono, a.url, a.color from sia_cat_actividad a '
                        . 'join sia_aso_usuario_actividad ua on ua.id_actividad = a.id_actividad where ua.id_usuario = ' . $usuario->id_usuario . ' and ua.status = 1 and a.status = 1 order by a.id_actividad Asc');
        foreach ($actividadesUsuario as $ausu) {
            $opcion = array();
            $inicio = null;
            $fin = null;
            if (strcmp($ausu->fecha_inicio, "") != 0) {
                $inicio = new DateTime($ausu->fecha_inicio);
            }
            if (strcmp($ausu->fecha_fin, "") != 0) {
                $fin = new DateTime($ausu->fecha_fin);
            }
            $activo1 = ($inicio == null || $inicio->getTimestamp() <= strtotime("now"));
            $activo2 = ($fin == null || $fin->getTimestamp() >= strtotime("now"));
            if ($activo1 && $activo2) {
                $opcion["icono"] = $ausu->icono;
                $opcion["url"] = url('/') . $ausu->url;
                $opcion["texto"] = $ausu->nombre;
                $opcion["desc"] = $ausu->descripcion;
                $opcion["color"] = $ausu->color;
                $menu[$opcion["url"]] = $opcion;
            }
        }
        return $menu;
    }

    public function obtenerCampos($tipo){
        return camposModel::where([['activo', '=', '1'], ['Tipo', '=', $tipo ]])->get()->toArray();
    }

}
