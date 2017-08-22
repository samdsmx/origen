<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class organismosModel extends Model{
    
    protected $table = 'organismos';
    protected $fillable = ['Tema','Objetivo', 'Institución', 'Estado', 'Direccion', 'Referencia', 'Telefono', 'Email',
        'Observaciones', 'Requisitos', 'HorariosCostos'];
}
