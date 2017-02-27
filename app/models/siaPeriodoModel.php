<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of siaPeriodoModel
 *
 * @author Angel
 */
class siaPeriodoModel extends Eloquent {

    protected $table = 'sia_periodo';
    protected $primaryKey = 'id_periodo';
    protected $fillable = ['fecha_inicio', 'fecha_fin', 'comentarios', 'status'];

    public function sistemasperiodo() {
        return $this->hasMany('siaAsoSistemaPeriodoModel', 'id_sistema_periodo');
    }

    public static function validar($datos) {
        $rules = array(
            'fecha_inicio' => "required|date",
            'fecha_fin' => "required|date",
            'comentarios' => "required|regex:/^[a-zA-ZáéíóúñÁÉÍÓÚÑ0-9][a-zA-ZáéíóúñÁÉÍÓÚÑ0-9\s]*/"
        );
        $messages = array(
            'fecha_inicio.required' => "La fecha de inicio debe es obligatoria",
            'fecha_inicio.date' => "Fecha invalida",
            'fecha_fin.required' => "La fecha de fin debe es obligatoria",
            'fecha_fin.date' => "Fecha invalida",
            'comentarios.required' => "Campo obligatorio",
            'comentarios.regex' => "Comentario invalido"
        );
        return Validator::make($datos, $rules, $messages);
    }

    public static function validarDuplicidad($datos, $periodo) {
        $msg = array();
        $msg += BaseController::existe("siaPeriodoModel", "comentarios", $datos["comentarios"], $periodo->comentarios);
        $msg += BaseController::existe("siaPeriodoModel", "fecha_inicio", $datos["fecha_inicio"], $periodo->fecha_inicio);
        $msg += BaseController::existe("siaPeriodoModel", "fecha_fin", $datos["fecha_fin"], $periodo->fecha_fin);
        return $msg;
    }

}
