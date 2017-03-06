<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Database\Eloquent\Model;

class siaAsoSistemaPeriodoModel extends Model{
    
    protected $table = 'sia_aso_sistema_periodo';
    protected $primaryKey = 'id_sistema_periodo';
    protected $fillable = ['id_sistema', 'id_periodo', 'id_observacion', 'nota', 'status'];
    
    public function sistema(){
        return $this->belongsTo('App\Http\Controllers\siaSistemaModel', 'id_sistema');
    }
    
    public function periodo(){
        return $this->belongsTo('App\Http\Controllers\siaPeriodoModel', 'id_periodo');
    }
    
    public function observacion(){
        return $this->belongsTo('App\Http\Controllers\siaObservacionModel', 'id_observacion');
    }

    public static function validar($datos) {
        $rules = array(
            "baja_razon" => "required|regex:/^[a-zA-ZáéíóúñÁÉÍÓÚÑ][a-zA-ZáéíóúñÁÉÍÓÚÑ0-9\s]*/"
        );
        $messages = array(
            "baja_razon.required" => "La razón es obligatoria.",
            "baja_razon.regex" => "La razón no es valida."
        );
        return Validator::make($datos, $rules, $messages);
    }    

}
