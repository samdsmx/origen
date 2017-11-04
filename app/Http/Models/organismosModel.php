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
        $rules['Tema'] = "required";
        $rules['Institucion'] = "required";
        $rules['Direccion'] = "required";
        $rules['Telefono'] = "required|numeric|min:8";
        $messages = array();
        $messages['Tema.requided'] = "El Tema es obligatorio";
        $messages['Institucion.requided'] = "La Institucion es obligatoria";
        $messages['Direccion.requided'] = "La Dirección es obligatoria";
        $messages['Telefono.requided'] = "El Telefono es obligatorio";
        $messages['Telefono.numeric'] = "El Telefono debe contener valores numéricos";
        $messages['Telefono.min'] = "El Telefono debe contener al menos 8 digitos";
        
        return Validator::make($datos, $rules, $messages);
    }
}
