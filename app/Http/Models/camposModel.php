<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class camposModel extends Model{
    
    protected $table = 'campos';
    protected $fillable = ['Nombre','Tipo', 'activo'];
}
