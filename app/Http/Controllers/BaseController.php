<?php

namespace App\Http\Controllers;

use DB, Auth, View, Session, Request, Redirect, DateTime, Response, Validator;

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

    protected function apuntaPeriodoActual($sistema) {
        $periodo = siaPeriodoModel::where('status', '=', 1)->orderBy('fecha_inicio', 'desc')->first();
        $sistemaPeriodoRes = siaAsoSistemaPeriodoModel::where('id_sistema', '=', $sistema->id_sistema)->orderBy('id_periodo', 'desc')->first();
        if ($sistemaPeriodoRes == null || $sistemaPeriodoRes->id_periodo != $periodo->id_periodo) {
            $sistemaPeriodo = new siaAsoSistemaPeriodoModel();
            $sistemaPeriodo->id_sistema = $sistema->id_sistema;
            $sistemaPeriodo->id_periodo = $periodo->id_periodo;
            $sistemaPeriodo->status = 1;
            if ($sistemaPeriodoRes == null) {
                $sistemaPeriodo->id_observacion = 2;
                $sistemaPeriodo->nota = "Nuevo Sistema";
            } else {
                $sistemaPeriodo->id_observacion = 5;
                $sistemaPeriodo->nota = "migracion respuestas del periodo anterior";
                $sistema->id_fase=3;                
                $sistema->save();
            }
            $sistemaPeriodo->save();
        } else {
            $sistemaPeriodo = $sistemaPeriodoRes;
        }
        if ($sistemaPeriodoRes != null && $sistemaPeriodoRes->id_periodo != $periodo->id_periodo) {
            $propiedadesContestadas = siaRespuestaModel::where('id_sistema_periodo', '=', $sistemaPeriodoRes->id_sistema_periodo)->get();
            foreach ($propiedadesContestadas as $propiedadC) {
                $res = new siaRespuestaModel();
                $res->id_sistema_periodo = $sistemaPeriodo->id_sistema_periodo;
                $res->id_propiedad = $propiedadC->id_propiedad;
                $res->id_persona = Auth::user()->persona->id_persona;
                $res->valor = $propiedadC->valor;
                $res->status = 1;
                $res->save();
            }
        }
        return $sistemaPeriodo;
    }

    protected function obtieneRespuestas($id_sistema_periodo) {
        $secciones = array();
        $propiedadesContestadas = siaRespuestaModel::where('id_sistema_periodo', '=', $id_sistema_periodo)->get();
        foreach ($propiedadesContestadas as $i => $propiedadC) {
            $prop = siaPropiedadModel::where('id_propiedad', '=', $propiedadC->id_propiedad)->where('status', '=', 1)->first();
            $grupo = siaGrupoModel::find($prop->id_grupo);
            $secciones[$grupo->grupo][$prop->id_propiedad] = self::construyeOracionConRespuesta($i + 1, $prop->id_propiedad, $grupo, $prop->descripcion, $propiedadC->valor, $propiedadC->id_respuesta);
        }
        return $secciones;
    }

    private function construyeOracionConRespuesta($i, $id_pregunta, $grupo, $detalleProp, $res, $id_respuesta) {
        $arreglo = array();
        $arreglo["id_respuesta"] = $id_respuesta;
        $arreglo["res"] = $res;
        $arreglo["pregunta"] = $detalleProp;
        $arreglo["num"] = $i;
        if (strlen($res) < 50) {
            $in = "<input type='text' name='" . $grupo->grupo . $id_pregunta . "' style='width:100%;' value='" . $res . "' readonly/>";
        } else {
            $in = "<textarea style='width:100%;' readonly>" . $res . "</textarea>";
        }
        $arreglo["campo"] = $in;
        return $arreglo;
    }

}
