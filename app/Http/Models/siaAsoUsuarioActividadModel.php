<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;

class siaAsoUsuarioActividadModel extends Model{
    
    protected $table = 'sia_aso_usuario_actividad';
    protected $primaryKey = 'id_usuario_actividad';
    protected $fillable = ['fecha_inicio', 'fecha_fin', 'id_usuario', 'id_actividad'];
    
    public function usuario(){
        return $this->belongsTo('App\Http\Controllers\User', 'id_usuario');
    }
    
    public function actividad(){
        return $this->belongsTo('App\Http\Controllers\siaActividadModel', 'id_actividad');
    }
}
