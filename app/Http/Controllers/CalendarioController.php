<?php

namespace App\Http\Controllers;

use DB, Auth, View, Session, Request, Redirect, DateTime, Response, Validator;

class CalendarioController extends BaseController {

    public function getIndex() {
        if (!parent::tienePermiso('Calendario')) {
            return Redirect::to('inicio');
        }
        $menu = parent::createMenu();

        return View::make('calendario.calendario', array('menu' => $menu));
    }

}