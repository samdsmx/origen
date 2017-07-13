<?php

namespace App\Http\Controllers;

use DB, Auth, View, Session, Request, Redirect, DateTime, Response, Validator;

class GeneralController extends BaseController {

    public function getIndex() {
        if (Auth::guest()) {
            return View::make('index');
        } else {
            return Redirect::to('inicio');
        }
    }

}
