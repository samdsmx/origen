<?php

namespace App\Http\Models;

use Validator;
use Illuminate\Database\Eloquent\Model;


class casosModel extends Model{
    
    protected $table = 'casos';
    protected $primaryKey = 'IDCaso';
    protected $fillable = ['Nombre', 'Edad', 'EstadoCivil', 'Telefono', 'Municipio', 
        'Estado', 'Ocupacion', 'Religion', 'VivesCon', 'ComoTeEnteraste',
        'tipocaso', 'PosibleSolucion', 'Estatus', 'HorasInvertidas', 'Sexo',
        'NivelEstudios', 'LenguaIndigena', 'CP', 'Colonia', 'CorreoElectronico',
        'MedioContacto', 'Pais'];

    public static function validar($datos) {
        $rules = array(
            'Nombre' => "required",
            'ComoTeEnteraste' => [
                "required",
                "notIn:0"
            ]

        );
        $messages = array(
            'Nombre.required' => "El nombre es obligatorio",
            'ComoTeEnteraste.required' => "Indicar como se enteró es obligatorio",
            'ComoTeEnteraste.not_in' => "Indicar como se enteró es obligatorio"
        );
        return Validator::make($datos, $rules, $messages);
    }
   
}
