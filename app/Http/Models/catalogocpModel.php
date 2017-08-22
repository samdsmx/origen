<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class catalogocpModel extends Model{
    
    protected $table = 'catalogoCP';
    protected $primaryKey = 'id';
    protected $fillable = ['estado', 'municipio', 'cp', 'colonia'];
}
