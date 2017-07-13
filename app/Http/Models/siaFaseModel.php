<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;

class siaFaseModel extends Model{
    
    protected $table = 'sia_cat_fase';
    protected $primaryKey = 'id_fase';
    protected $fillable = ['descripcion', 'status'];
    
    public function sistemas(){
        return $this->hasMany('App\Http\Controllers\siaSistemaModel', 'id_sistema');
    }
}
