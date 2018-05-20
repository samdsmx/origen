<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;

class actividadModel extends Model{
    protected $table = 'actividad';
    protected $primaryKey = 'id_actividad';
    protected $fillable = ['nombre','descripcion', 'status'];
}
