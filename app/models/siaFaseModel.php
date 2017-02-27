<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of siaFaseModel
 *
 * @author Angel
 */
class siaFaseModel extends Eloquent{
    
    protected $table = 'sia_cat_fase';
    protected $primaryKey = 'id_fase';
    protected $fillable = ['descripcion', 'status'];
    
    public function sistemas(){
        return $this->hasMany('siaSistemaModel', 'id_sistema');
    }
}
