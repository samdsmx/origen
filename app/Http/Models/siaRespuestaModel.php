<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Database\Eloquent\Model;

class siaRespuestaModel extends Model {

    protected $table = 'sia_respuesta';
    protected $primaryKey = 'id_respuesta';
    protected $fillable = ['id_sistema_periodo', 'id_persona', 'id_propiedad', 'valor', 'status'];

    public function __construct($id_sistema_periodo = null, $id_persona = null, $id_propiedad = null, $status = 1) {
        parent::__construct();
        $this->id_sistema_periodo = $id_sistema_periodo;
        $this->id_persona = $id_persona;
        $this->id_propiedad = $id_propiedad;
        $this->status = $status;
        return $this;
    }

    public function sistemasperiodos() {
        return $this->belongsTo('App\Http\Controllers\siaAsoSistemaPeriodoModel', 'id_sistema_periodo');
    }

    public function propiedad() {
        return $this->belongsTo('App\Http\Controllers\siaPropiedadModel', 'id_propiedad');
    }

    public function persona() {
        return $this->belongsTo('App\Http\Controllers\siaPersonaModel', 'id_persona');
    }

    public static function validar($datos, $req, &$respuestas) {
        $a = str_getcsv($datos, ",", "'");
        foreach ($a as $result) {
            $b = explode(":", $result);
            $key = ((($pos = strpos($b[0], "(")) > 0) ? substr($b[0], 0, $pos) : $b[0]);
            $r = implode(':', array_slice($b, 1));
            if (!array_key_exists($key, $respuestas)) {
                $respuestas[$key] = $r;
            } else {
                $respuestas[$key] .= ";" . $r;
            }
        }
        $rules = array();
        $messages = array();
        $req = explode(",", $req);
        foreach ($req as $r) {
            $r = str_replace("obl", "input", $r);
            $rules[$r] = "required";
            $messages[$r . ".required"] = "La propiedad es obligatoria.";
        }
        return Validator::make($respuestas, $rules, $messages);
    }

}