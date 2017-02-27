<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of siaPropiedad
 *
 * @author Angel
 */
class siaPropiedadModel extends Eloquent{
    
    protected $table = "sia_cat_propiedad";
    protected $primaryKey = 'id_propiedad';
    protected $fillable=['id_tipo','id_grupo','descripcion', 'obligatoria', 'orden', 'status'];
    
    public function tipo(){
        return $this->belongsTo('siaTipoModel', 'id_tipo');
    }
    
    public function grupo(){
        return $this->belongsTo('siaGrupoModel', 'id_grupo');
    }
    
    public static function validar($datos) {
        $rules = array(
            "id_tipo" => "required|numeric",
            "id_grupo" => "required|numeric",
            "orden" => "numeric",
            "descripcion" => "required|regex:/^[a-zA-ZáéíóúñÁÉÍÓÚÑ¿][a-zA-ZáéíóúñÁÉÍÓÚÑ?0-9\s]*/");
        $messages = array(
            "id_tipo.required" => "El TIPO de propiedad es obligatorio.",
            "id_tipo.numeric" => "El TIPO de propiedad es invalido.",
            "id_grupo.required" => "El GRUPO de  la propiedad es obligatorio.",
            "id_grupo.numeric" => "El GRUPO de la propiedad es invalido.",
            "orden.numeric" => "El ORDEN no es valido, introduzca valores numericos.",
            "descripcion.required" => "La DESCRIPCIÓN es obligatoria.",
            "descripcion.regex" => "La DESCRIPCIÓN no es valida.");
        return Validator::make($datos, $rules, $messages);
    }

    public static function validarDuplicidad($datos, $propiedad) {
        $msg = array();
        if (strcmp($datos["descripcion"],'Descripción') == 0 || empty($datos["descripcion"]) || strcmp($datos["descripcion"],'Empty') == 0 ){
            $msg += array("descripcion" => "Valor no valido");
            }
        $msg += BaseController::existe("siaPropiedadModel", "descripcion", $datos["descripcion"], $propiedad->descripcion);
        return $msg;
    }    
    
}
