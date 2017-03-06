<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;

class siaPersonaModel extends Model{
    
    protected $table = 'sia_persona';
    protected $primaryKey = 'id_persona';
    protected $fillable = ['primer_apellido', 'segundo_apellido', 'nombres', 'curp', 'correo', 'telefono', 'id_unidad_responsable', 'status'];
    
    public $timestamp = true;
    
    public function ur(){
        return $this->belongsTo('App\Http\Controllers\siaUnidadResponsableModel', 'id_unidad_responsable');
    }
    
    public function usuario(){
        return $this->hasOne('App\Http\Controllers\User', 'id_usuario');
    }
    
    public function nombre_completo(){
        return $this->nombres.' '.$this->primer_apellido.' '.$this->segundo_apellido;
    }
}
