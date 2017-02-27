<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of siaUnidadResponsableModel
 *
 * @author Angel
 */
class siaUnidadResponsableModel extends Eloquent {

    protected $table = 'sia_cat_unidad_responsable';
    protected $primaryKey = 'id_unidad_responsable';
    protected $fillable = ['nombre_ur', 'nombre_corto', 'status'];

    public static function validar($datos) {
        $rules = array(
            'nombre_ur' => "required|regex:/^[a-zA-ZáéíóúñÁÉÍÓÚÑ][a-zA-ZáéíóúñÁÉÍÓÚÑ0-9\s]*/",
            'nombre_corto' => "required|regex:/^[a-zA-ZáéíóúñÁÉÍÓÚÑ][a-zA-ZáéíóúñÁÉÍÓÚÑ0-9\s]*/"
        );
        $messages = array(
            'nombre_ur.required' => "El nombre de la UR es obligatoria",
            'nombre_ur.regex' => "El nombre de la UR no es valido",
            'nombre_corto.required' => "El nombre corto de la UR es obligatoria",
            'nombre_corto.regex' => "El nombre corto de la UR no es valido"
        );
        return Validator::make($datos, $rules, $messages);
    }

    public static function validarDuplicidad($datos, $ur) {
        $msg = array();
        $msg += BaseController::existe("siaUnidadResponsableModel", "nombre_ur", $datos["nombre_ur"], $ur->nombre_ur);
        $msg += BaseController::existe("siaUnidadResponsableModel", "nombre_corto", $datos["nombre_corto"], $ur->nombre_corto);
        return $msg;
    }

}
