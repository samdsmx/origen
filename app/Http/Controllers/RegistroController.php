<?php

namespace App\Http\Controllers;

use DB, Auth, View, Session, Request, Redirect, DateTime, Response, Validator;

class RegistroController extends BaseController {

    public function getIndex() {
        if (!parent::tienePermiso('Registro')){
            return Redirect::to('inicio');
            }
        $menu = parent::createMenu();
        return View::make('registro.registro', array('menu' => $menu));
    }

}
