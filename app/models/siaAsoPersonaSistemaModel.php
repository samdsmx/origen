<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of siaAsoSistemaPeriodoModel
 *
 * @author Angel
 */
class siaAsoPersonaSistemaModel extends Eloquent{
    
    protected $table = 'sia_aso_persona_sistema';
    protected $primaryKey = 'id_persona_sistema';
    protected $fillable = ['id_sistema', 'id_persona', 'status'];
    
    public function sistema(){
        return $this->belongsTo('siaSistemaModel', 'id_sistema');
    }
    
    public function persona(){
        return $this->belongsTo('siaPersonaModel', 'id_persona');
    }
    
}
