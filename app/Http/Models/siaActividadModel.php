<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;

class siaActividadModel extends Model{
    protected $table = 'sia_cat_actividad';
    protected $primaryKey = 'id_actividad';
    protected $fillable = ['nombre','descripcion', 'status'];
}
