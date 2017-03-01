<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of siaSistemaModel
 *
 * @author Angel
 */
class siaSistemaModel extends Eloquent{
    
    protected $table='sia_sistema';
    protected $primaryKey = 'id_sistema';
    protected $fillable = ['id_fase', 'status'];
    
    public function __construct($id_fase=null,$status=1){
        //parent::__construct();
        $this->id_fase = $id_fase;
        $this->status = $status;
        return $this;
        }
    
    public function fase(){
        return $this->belongsTo('siaFaseModel', 'id_fase');
    }
    
    public function sistemaperiodos(){
        return $this->hasMany('siaAsoSistemaPeriodoModel', 'id_sistema_model');
    }
    
    public function sistemapropiedades(){
        return $this->hasMany('siaAsoSistemaPropiedadModel', 'id_sistema_propiedad');
    }
    
}
