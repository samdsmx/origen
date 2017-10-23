<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class llamadasModel extends Model{
    
    protected $table = 'llamadas';
    protected $primaryKey = 'IDCaso';
    protected $fillable = ['IDCaso', 'LlamadaNo', 'FechaLlamada', 'Consejera', 'Horainicio', 
        'Horatermino', 'ComentariosAdicionales', 'AyudaPsicologico', 'AyudaLegal', 'AyudaMedica',
        'AyudaOtros', 'DesarrolloCaso', 'CanaLegal', 'CanaOtro', 'Duracion',
        'Acceso', 'TipoViolencia', 'ModalidadViolencia'];
}
