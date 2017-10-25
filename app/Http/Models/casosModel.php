<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class casosModel extends Model{
    
    protected $table = 'casos';
    protected $primaryKey = 'IDCaso';
    protected $fillable = ['Nombre', 'Edad', 'EstadoCivil', 'Telefono', 'Municipio', 
        'Estado', 'Ocupacion', 'Religion', 'VivesCon', 'ComoTeEnteraste',
        'tipocaso', 'PosibleSolucion', 'Estatus', 'HorasInvertidas', 'Sexo',
        'NivelEstudios', 'LenguaIndigena', 'CP', 'Colonia', 'CorreoElectronico',
        'MedioContacto', 'Pais'];
    
    
}
