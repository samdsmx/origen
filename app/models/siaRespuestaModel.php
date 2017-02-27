<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of siaRespuesta
 *
 * @author Angel
 */
class siaRespuestaModel extends Eloquent{
    
    protected $table = 'sia_respuesta';
    protected $primaryKey = 'id_respuesta';
    protected $fillable = ['id_sistema_periodo', 'id_persona', 'valor', 'status'];
    
    public function sistemasperiodos(){
        return $this->belongsTo('siaAsoSistemaPeriodoModel', 'id_sistema_periodo');
    }
    
    public function persona(){
        return $this->belongsTo('siaPersonaModel', 'id_persona');
    }
    
    public function propiedadrespuesta(){
        return $this->hasMany('siaAsoPropiedadRespuestaModel', 'id_propiedad_respuesta');
    }
    
}
