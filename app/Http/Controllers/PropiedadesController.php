<?php

namespace App\Http\Controllers;

use DB, Auth, View, Session, Request, Redirect, DateTime, Response, Validator;

class PropiedadesController extends BaseController {

    public function getIndex() {
        if (!parent::tienePermiso(5)) {
            return Redirect::to('inicio');
        }
        $menu = parent::createMenu();
        $tiposPropidad = DB::table('sia_cat_tipo')->where('status', '=', '1')->orderBy('id_tipo', 'ASC')->get();
        $gruposPropiedad = DB::table('sia_cat_grupo')->where('status', '=', '1')->orderBy('orden', 'asc')->orderBy('id_grupo', 'asc')->get();
        $propiedades = DB::select('select p.*, g.grupo, t.tipo, sp.id_propiedad conRespuesta ' .
                        'from sia_cat_grupo g, sia_cat_tipo t, sia_cat_propiedad p ' .
                        'left join sia_respuesta sp on sp.id_propiedad = p.id_propiedad ' .
                        'where p.id_grupo = g.id_grupo and t.id_tipo = p.id_tipo ' .
                        'group by p.id_propiedad ' .
                        'order by -g.orden DESC, g.id_grupo ASC, -p.orden DESC, p.id_propiedad ASC');
        return View::make('propiedades.propiedades', array('menu' => $menu, 'tipos' => $tiposPropidad, 'grupos' => $gruposPropiedad, 'propiedades' => $propiedades));
    }

    public function postBuscar() {
        if (Request::ajax()) {
            $id = Request::get('id');
            $propiedad = siaPropiedadModel::find($id);
            $respuestas = DB::select("SELECT pr.id_propiedad, pr.valor, pr.status FROM sia_cat_respuestas_predefinidas pr WHERE pr.id_propiedad = " . $id . " AND pr.status = 1");
            $cadena = DB::select("SELECT expresion from sia_cat_reglas WHERE id_propiedad_dependiente = " . $id . "");
            if ($propiedad) {
                return Response::json(array('propiedad' => $propiedad, 'repuestas' => $respuestas, 'cadena' => $cadena));
            } else {
                Session::flash('mensajeError', "Error al tratar de encontrar la propiedad");
            }
        }
    }

    public function postEliminar() {
        if (!Request::ajax()) {
            return;
        }
        $propiedad = siaPropiedadModel::find(Request::get('modalConfirmaId'));
        if ($propiedad) {
            $respuestas = siaRespuestaPredefinidaModel::where('id_propiedad', '=', $propiedad->id_propiedad)->get();
            foreach ($respuestas as $r) {
                $r->delete();
            }
            $reglas = siaReglasModel::where('id_propiedad_dependiente', '=', $propiedad->id_propiedad)->get();
            foreach ($reglas as $r) {
                $r->delete();
            }
            $propiedad->delete();
            Session::flash('mensaje', 'Pregunta/Propiedad eliminada');
        } else {
            Session::flash('mensajeError', "Error al tratar de eliminar la pregunta");
        }
    }

    public function getObligatoriacambia($id) {
        $prop = siaPropiedadModel::find($id);
        $prop->obligatoria = ($prop->obligatoria - 1) * -1;
        $prop->save();
        return Redirect::to('Propiedades');
    }

    public function getStatuscambia($id) {
        $prop = siaPropiedadModel::find($id);
        $prop->status = ($prop->status - 1) * -1;
        $prop->save();
        return Redirect::to('Propiedades');
    }

    public function postRegistraprop() {
        if (!Request::ajax()) {
            return;
        }
        $datos = Request::all();
        $validator = siaPropiedadModel::validar($datos);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->errors()->toArray()));
        }
        
        if ($datos["id_propiedad"] == "") {
            $propiedad = new siaPropiedadModel();
            $propiedad->status = 1;
            Session::flash('mensaje', 'Pregunta/Propiedad agregada');
        } else {
            $propiedad = siaPropiedadModel::find($datos["id_propiedad"]);
            Session::flash('mensaje', 'Pregunta/Propiedad modificada');
        }
        $msg = siaPropiedadModel::validarDuplicidad($datos, $propiedad);
        if (!empty($msg)) {
            return Response::json(array('errors' => $msg));
        }
        
        $propiedad->id_tipo = intval($datos['id_tipo']);
        $propiedad->id_grupo = intval($datos['id_grupo']);
        $propiedad->descripcion = $datos['descripcion'];
        $propiedad->obligatoria = intval($datos['obligatoria']);
        $propiedad->orden = $datos['orden'] == '' ? null : intval($datos['orden']);
        $propiedad->save();
        self::actualizaRespuestasPredefinidas($datos['hiddenPredefinidas'], $propiedad->id_propiedad);
        self::actualizaReglas($propiedad->id_propiedad, $datos['valorConAn']);
    }

    private function actualizaReglas($id_propiedad, $valor) {
        $expresion = DB::select("SELECT * from sia_cat_reglas WHERE id_propiedad_dependiente = " . $id_propiedad );
         if (count($expresion) == 0) {
            $obj = new siaReglasModel();
            $obj->status = 1;
        } else {
            $obj = siaReglasModel::find($expresion[0]->id_regla);
        }
        if (!empty($valor)){
            $obj->id_propiedad_dependiente = $id_propiedad;
            $obj->expresion = $valor;
            $obj->save();
            }
            else if (!empty($obj->id_regla)) {
                $obj->delete();    
            }
    }

    private function actualizaRespuestasPredefinidas($defecto, $prop) {
        $anteriores = siaRespuestaPredefinidaModel::select('valor')->where('status', '=', 1)->where('id_propiedad', '=', $prop)->get()->toArray();
        $ant = array();
        foreach ($anteriores as $a) {
            $ant[] = $a['valor'];
        }
        
        $respuestas = array();
        if (!empty($defecto)) {
            $respuestas = explode(',', $defecto);
        }
        
        if (count($ant)>0){
            $paraEliminar = array_diff($ant, $respuestas);
            foreach ($paraEliminar as $valor) {
                $propiedad = siaRespuestaPredefinidaModel::where('valor', '=', $valor)->where('id_propiedad', '=', $prop)->first();
                $propiedad->delete();
            }
        }
        
        if (count($respuestas)>0){
            $paraAgregar = array_diff($respuestas, $ant);
            foreach ($paraAgregar as $valor) {
                $obj = new siaRespuestaPredefinidaModel();
                $obj->id_propiedad = $prop;
                $obj->valor = $valor;
                $obj->status = 1;
                $obj->save();
            }
        } 
    }

    public function getPregunta($grupo) {
        $respuesta = DB::select("select p.id_propiedad id, p.descripcion "
                        . "from sia_cat_propiedad p, sia_cat_grupo g, sia_cat_tipo t "
                        . "where p.id_grupo = g.id_grupo and t.id_tipo = p.id_tipo and g.id_grupo = " . $grupo . " and p.status = 1 "
                        . "order by -g.orden DESC, g.id_grupo ASC, -p.orden DESC, p.id_propiedad ASC;");
        return Response::json($respuesta);
    }

}
