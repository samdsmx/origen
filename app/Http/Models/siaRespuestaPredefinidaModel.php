<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;

class siaRespuestaPredefinidaModel extends Model{
    
    protected $table = "sia_cat_respuestas_predefinidas";
    protected $primaryKey='id_respuesta_predefinida';
    protected $fillable = ['id_propiedad', 'valor', 'status'];
    
    public function propiedad(){
        return $this->belongsTo('App\Http\Controllers\siapropiedadModel', 'id_propiedad');
    }
    
}
