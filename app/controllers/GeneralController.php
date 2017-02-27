<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GeneralController
 *
 * @author Angel
 */
class GeneralController extends BaseController {

    public function getIndex() {
        if (Auth::guest()) {
            return View::make('index');
        } else {
            return Redirect::to('inicio');
        }
    }

}
