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
class siaAsoSistemaPeriodoModel extends Eloquent{
    
    protected $table = 'sia_aso_sistema_periodo';
    protected $primaryKey = 'id_sistema_periodo';
    protected $fillable = ['id_sistema', 'id_periodo', 'id_observacion', 'nota', 'status'];
    
    public function sistema(){
        return $this->belongsTo('siaSistemaModel', 'id_sistema');
    }
    
    public function periodo(){
        return $this->belongsTo('siaPeriodoModel', 'id_periodo');
    }
    
    public function observacion(){
        return $this->belongsTo('siaObservacionModel', 'id_observacion');
    }
    
    public function sistemasperiodos(){
        return $this->hasMany('siaAsoSistemaPeriodoModel', 'id_sistema_periodo');
    }
}
