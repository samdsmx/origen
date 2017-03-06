<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;

class siaSistemaModel extends Model{
    
    protected $table='sia_sistema';
    protected $primaryKey = 'id_sistema';
    protected $fillable = ['id_fase', 'status'];
    
    public function __construct($id_fase=null,$status=1){
        //parent::__construct();
        $this->id_fase = $id_fase;
        $this->status = $status;
        return $this;
        }
    
    public function fase(){
        return $this->belongsTo('App\Http\Controllers\siaFaseModel', 'id_fase');
    }
    
    public function sistemaperiodos(){
        return $this->hasMany('App\Http\Controllers\siaAsoSistemaPeriodoModel', 'id_sistema_model');
    }
    
    public function sistemapropiedades(){
        return $this->hasMany('App\Http\Controllers\siaAsoSistemaPropiedadModel', 'id_sistema_propiedad');
    }
    
}
