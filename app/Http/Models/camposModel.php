<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class camposModel extends Model{
    
	protected $table = 'campos';
	protected $fillable = ['Nombre','Tipo', 'activo'];

	public function __construct($Nombre = null, $Tipo = null, $activo = null) {
	    $this->Nombre = $Nombre;
	    $this->Tipo = $Tipo;
	    $this->activo = $activo;
	    return $this;
	}

	public static function validar($datos) {
	    $rules = array(
	        "Nombre" => "required|regex:/^[a-zA-ZáéíóúñÁÉÍÓÚÑ][a-zA-ZáéíóúñÁÉÍÓÚÑ0-9\s]*/",
	        "Tipo" => "required|regex:/^[a-zA-ZáéíóúñÁÉÍÓÚÑ][a-zA-ZáéíóúñÁÉÍÓÚÑ0-9\s]*/"
	    );
	    $messages = array(
	        "Nombre.required" => "El Nombre es obligatorio.",
	        "Nombre.regex" => "El Nombre no es valido.",
	       	"Tipo.required" => "El Tipo es obligatorio.",
	        "Tipo.regex" => "El Tipo no es valido."
	    );
	    return Validator::make($datos, $rules, $messages);
	}

	public static function validarDuplicidad($datos, $campos) {
	    $msg = array();
	    $msg += BaseController::existe("camposModel", "Nombre", $datos["Nombre"], $campos->Nombre);
	    $msg += BaseController::existe("camposModel", "Tipo", $datos["Tipo"], $campos->Tipo);
	    return $msg;
	}

}
