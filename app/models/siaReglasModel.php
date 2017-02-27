<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of siaRespuestaPredefinidaModel
 *
 * @author Sergio
 */
class siaReglasModel extends Eloquent{
    
    protected $table = "sia_cat_reglas";
    protected $primaryKey='id_regla';
    protected $fillable = ['id_propiedad_dependiente', 'expresion', 'status'];

    
}
