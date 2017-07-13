<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;

class siaTipoModel extends Model{
    
    protected $table="sia_cat_tipo";
    protected $primaryKey = "id_tipo";
    protected $fillable = ['tipo', 'status'];
    
    public function propiedades(){
        return $this->hasMany('App\Http\Controllers\siaPropiedadModel', 'id_propiedad');
    }
}
