<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Validator;

class siaGrupoModel extends Model{

    protected $table = "sia_cat_grupo";
    protected $primaryKey = 'id_grupo';
    protected $fillable = ['grupo', 'status'];

    public function __construct($grupo = null, $status = null) {
        $this->grupo = $grupo;
        $this->status = $status;
        return $this;
    }

    public function propiedades() {
        return $this->hasMany('App\Http\Controllers\siaPropiedadModel', 'id_propiedad');
    }

    public static function validar($datos) {
        $rules = array(
            "grupo" => "required|regex:/^[a-zA-ZáéíóúñÁÉÍÓÚÑ][a-zA-ZáéíóúñÁÉÍÓÚÑ0-9\s]*/",
            "orden" => "numeric"
        );
        $messages = array(
            "grupo.required" => "El grupo es obligatorio.",
            "grupo.regex" => "El grupo no es valido.",
            "orden.numeric" => "El orden no es valido, introduzca valores numericos.",
        );
        return Validator::make($datos, $rules, $messages);
    }

    public static function validarDuplicidad($datos, $grupo) {
        $msg = array();
        $msg += BaseController::existe("siaGrupoModel", "grupo", $datos["grupo"], $grupo->grupo);
        return $msg;
    }

}
