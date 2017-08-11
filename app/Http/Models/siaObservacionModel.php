<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;

class siaObservacionModel extends Model{
    
    protected $table = 'sia_observacion';
    protected $primaryKey = 'id_observacion';
    protected $fillable = ['descripcion', 'satus'];
    
    public function sistemasperiodos(){
        return $this->hasMany('App\Http\Controllers\siaAsoSistemaPeriodoModel', 'id_sistema_periodo');
    }
}
