<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;

class personaModel extends Model{
    
    protected $table = 'persona';
    protected $primaryKey = 'id_persona';
    protected $fillable = ['primer_apellido', 'segundo_apellido', 'nombres', 'curp', 'correo', 'telefono', 'status'];
    
    public $timestamp = true;
       
    public function usuario(){
        return $this->hasOne('App\Http\Controllers\User', 'id_usuario');
    }
    
    public function nombre_completo(){
        return $this->nombres.' '.$this->primer_apellido.' '.$this->segundo_apellido;
    }
}
