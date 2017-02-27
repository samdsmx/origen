<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of siaTipo
 *
 * @author Angel
 */
class siaTipoModel extends Eloquent{
    
    protected $table="sia_cat_tipo";
    protected $primaryKey = "id_tipo";
    protected $fillable = ['tipo', 'status'];
    
    public function propiedades(){
        return $this->hasMany('siaPropiedadModel', 'id_propiedad');
    }
}
