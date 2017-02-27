<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of siaAsoUsuarioActividad
 *
 * @author Angel
 */
class siaAsoUsuarioActividadModel extends Eloquent{
    
    protected $table = 'sia_aso_usuario_actividad';
    protected $primaryKey = 'id_usuario_actividad';
    protected $fillable = ['fecha_inicio', 'fecha_fin', 'id_usuario', 'id_actividad'];
    
    public function usuario(){
        return $this->belongsTo('User', 'id_usuario');
    }
    
    public function actividad(){
        return $this->belongsTo('siaActividadModel', 'id_actividad');
    }
}
