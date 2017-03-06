<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;

class siaReglasModel extends Model{
    
    protected $table = "sia_cat_reglas";
    protected $primaryKey='id_regla';
    protected $fillable = ['id_propiedad_dependiente', 'expresion', 'status'];

    
}
