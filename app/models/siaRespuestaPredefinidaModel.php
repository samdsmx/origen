<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of siaRespuestaPredefinidaModel
 *
 * @author Angel
 */
class siaRespuestaPredefinidaModel extends Eloquent{
    
    protected $table = "sia_cat_respuestas_predefinidas";
    protected $primaryKey='id_respuesta_predefinida';
    protected $fillable = ['id_propiedad', 'valor', 'status'];
    
    public function propiedad(){
        return $this->belongsTo('siapropiedadModel', 'id_propiedad');
    }
    
}
