<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of siaObservacionModel
 *
 * @author Angel
 */
class siaObservacionModel extends Eloquent {
    
    protected $table = 'sia_observacion';
    protected $primaryKey = 'id_observacion';
    protected $fillable = ['descripcion', 'satus'];
    
    public function sistemasperiodos(){
        return $this->hasMany('siaAsoSistemaPeriodoModel', 'id_sistema_periodo');
    }
}
