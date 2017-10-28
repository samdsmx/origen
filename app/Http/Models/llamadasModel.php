<?php

namespace App\Http\Models;

use Validator;
use Illuminate\Database\Eloquent\Model;

class llamadasModel extends Model{
    
    protected $table = 'llamadas';
    protected $primaryKey = 'IDCaso';
    protected $fillable = ['IDCaso', 'LlamadaNo', 'FechaLlamada', 'Consejera', 'Horainicio', 
        'Horatermino', 'ComentariosAdicionales', 'AyudaPsicologico', 'AyudaLegal', 'AyudaMedica',
        'AyudaOtros', 'DesarrolloCaso', 'CanaLegal', 'CanaOtro', 'Duracion',
        'Acceso', 'TipoViolencia', 'ModalidadViolencia'];
  
 	public static function validar($datos) {
        $rules = array(
            'motivos' => "accepted"
        );
        $messages = array(
            'motivos.accepted' => "Es requerido indicar algun motivo de llamada"
        );
        return Validator::make($datos, $rules, $messages);
    }


}
