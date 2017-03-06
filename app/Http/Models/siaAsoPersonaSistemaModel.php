<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;

class siaAsoPersonaSistemaModel extends Model{

    protected $table = 'sia_aso_persona_sistema';
    protected $primaryKey = 'id_persona_sistema';
    protected $fillable = ['id_sistema', 'id_persona', 'status'];

    public function __construct($id_sistema = null, $id_persona =null,  $status = 1) {
        //parent::__construct();
        $this->id_persona = $id_persona;
        $this->id_sistema = $id_sistema;
        $this->status = $status;
        return $this;
    }

    public function sistema() {
        return $this->belongsTo('App\Http\Controllers\siaSistemaModel', 'id_sistema');
    }

    public function persona() {
        return $this->belongsTo('App\Http\Controllers\siaPersonaModel', 'id_persona');
    }

}
