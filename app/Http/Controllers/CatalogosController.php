<?php

namespace App\Http\Controllers;

use DB, Auth, View, Session, Request, Redirect, DateTime, Response, Validator, App\Http\Models\camposModel;

class CatalogosController extends BaseController {

    public function getIndex() {
        if (!parent::tienePermiso('Catalogos')) {
            return Redirect::to('inicio');
        }
        $menu = parent::createMenu();
        $tipos = DB::select('select Tipo from campos group by Tipo order by Tipo ASC');
        $campos = DB::select('select * from campos where Tipo = "'. $tipos[0]->Tipo .'" order by Nombre ASC');
        return View::make('catalogos.catalogos', array('menu' => $menu, 
            'campos' => $campos, 
            'tipos' => $tipos));
    }

    public function postFiltro() {
        if (!Request::ajax()) {
            return;
        }
        $datos = Request::all();
        $campos = DB::select('select * from campos where Tipo = "'. $datos['tipo'] .'" order by Nombre ASC');
        if ($campos) {               
            $view = View::make('catalogos.catalogos', array('menu' => [], 'campos' => $campos, 'tipos' => []));
            return $view->renderSections()['tableContent'];
        } else {
            return Redirect::to('Catalogos')->with('mensajeError', 'Error al buscar la sección/grupo');
        }
        return;
    }

    public function postEliminar() {
        if (Request::ajax()) {
            $datos = explode('-',Request::get('modalConfirmaId'));
            $grupo = DB::table('campos')
                        ->select('Nombre','Tipo')
                        ->where('Tipo','like','%'.$datos[0].'%')
                        ->where('Nombre','like','%'.$datos[1].'%')
                        ->delete();
            if ($grupo) {
                Session::flash('mensaje', 'Grupo eliminado');
            } else {
                Session::flash('mensajeError', "Error al tratar de eliminar el grupo");
            }
        }
    }

    public function getCambia($tipo, $nombre) {
        DB::select('UPDATE campos SET activo = ((activo - 1) * -1) WHERE Nombre = "'.$nombre.'" AND Tipo = "'.$tipo.'" ');
        Session::flash('mensaje', 'Estatus modificado con éxito');
        return Redirect::to('Catalogos');
    }

    public function postRegistragrupo() {
        if (!Request::ajax()) {
            return;
        }
        $datos = Request::all();

        $grupo = $datos['grupo'];
        $orden = $datos['orden'];
        $id_grupo = $datos['id_grupo'];
        $id_orden = $datos['id_orden'];
        if($id_grupo == '') {
            DB::table('campos')->insert(
                ['Nombre'=> $orden,'Tipo'=>$grupo,'activo'=>1]
            );     
            Session::flash('mensaje', 'Grupo añadido');
        } else {
            DB::table('campos')
                ->where('Tipo',$id_grupo)
                ->where('Nombre',$id_orden)
                ->update(
                    ['Tipo'=>$grupo,'Nombre'=>$orden]
                );
            Session::flash('mensaje', 'Grupo editado');
        }
    }

}
