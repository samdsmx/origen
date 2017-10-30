<?php

namespace App\Http\Models;

use Validator;
use Illuminate\Database\Eloquent\Model;

class organismosModel extends Model{
    
    protected $table = 'organismos';
    protected $primaryKey = 'ID';
    protected $fillable = ['Tema','Objetivo', 'Institución', 'Estado', 'Direccion', 'Referencia', 'Telefono', 'Email',
        'Observaciones', 'Requisitos', 'HorariosCostos'];
    
    public static function validar($datos){
        $rules = array();
        $rules['tema'] = "required";
        $rules['institucion'] = "required";
        $rules['direccion'] = "required";
        $rules['telefono'] = "required|numeric|min:8";
        $messages = array();
        $messages['tema.requided'] = "El Tema es obligatorio";
        $messages['institucion.requided'] = "La Institucion es obligatoria";
        $messages['direccion.requided'] = "La Dirección es obligatoria";
        $messages['telefono.requided'] = "El Telefono es obligatorio";
        $messages['telefono.numeric'] = "El Telefono debe contener valores numéricos";
        $messages['telefono.min'] = "El Telefono debe contener al menos 8 digitos";
        
        return Validator::make($datos, $rules, $messages);
    }
}
