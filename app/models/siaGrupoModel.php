<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of siaCatGrupo
 *
 * @author Angel
 */
class siaGrupoModel extends Eloquent {

    protected $table = "sia_cat_grupo";
    protected $primaryKey = 'id_grupo';
    protected $fillable = ['grupo', 'status'];

    public function propiedades() {
        return $this->hasMany('siaPropiedadModel', 'id_propiedad');
    }

    public static function validar($datos) {
        $rules = array(
            "grupo" => "required|regex:/^[a-zA-ZáéíóúñÁÉÍÓÚÑ][a-zA-ZáéíóúñÁÉÍÓÚÑ0-9\s]*/",
            "orden" => "numeric"
        );
        $messages = array(
            "grupo.required" => "El grupo es obligatorio.",
            "grupo.regex" => "El grupo no es valido.",
            "orden.numeric" => "El orden no es valido, introduzca valores numericos.",
        );
        return Validator::make($datos, $rules, $messages);
    }

    public static function validarDuplicidad($datos, $grupo) {
        $msg = array();
        $msg += BaseController::existe("siaGrupoModel", "grupo", $datos["grupo"], $grupo->grupo);
        return $msg;
    }

}
