<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class catalogocpModel extends Model{
    
    protected $table = 'catalogoCP';
    protected $primaryKey = 'id';
    protected $fillable = ['idEstado', 'estado', 'idMunicipio', 'municipio', 'cuidad', 'zona', 'cp', 'asentamiento', 'tipo'];
}
