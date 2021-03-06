<?php

namespace App\Http\Controllers;

use Hash, Validator;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements  AuthenticatableContract, CanResetPasswordContract {
  
    use Authenticatable, CanResetPassword;

    protected $table = 'consejeros';
    protected $primaryKey = 'id_usuario';
    protected $fillable = ['id_persona', 'nombre', 'password', 'status', 'acceso'];
    protected $hidden = ['password', 'remember_token'];
    public $timestamp = true;
    
    public function persona(){
        return $this->belongsTo('App\Http\Controllers\personaModel', 'id_persona');
    }
       
    public static function validar($datos){
        $rules = array("nombres" => "required|regex:/^[a-zA-ZáéíóúñÁÉÍÓÚÑ][a-zA-ZáéíóúñÁÉÍÓÚÑ\s]*/", "apaterno" => "required|regex:/^[a-zA-ZáéíóúñÁÉÍÓÚÑ][a-zA-ZáéíóúñÁÉÍÓÚÑ\s]*/", "amaterno" => "regex:/^[a-zA-ZáéíóúñÁÉÍÓÚÑ][a-zA-ZáéíóúñÁÉÍÓÚÑ\s]*/", "curp" => 'required|regex:/^([A-Z]{4})([0-9]{6})([A-Z]{6})([0-9]{2})+$/', "correo" => "required|email", "telefono" => "required|min:5", "pass" => "required|min:4|regex:/^[a-zA-Z_\-\/0-9]+/");
        $messages = array("nombres.required" => "El nombre es obligatorio", "nombres.regex" => "El nombre no es valido", "apaterno.required" => "El A. Paterno es obligatorio", "apaterno.regex" => "El A. Paterno no es valido", "amaterno.regex" => "El A. Materno no es valido", "curp.required" => "El CURP es obligatorio", "curp.regex" => "El CURP no es valido", "correo.required" => "El correo es obligatorio", "correo.regex" => "El correo no es valido", "telefono.required" => "El telefono es obligatorio", "telefono.min" => "La extensión debe ser al menos de 5 digitos", "usuario.required" => "El usuario es obligatorio", "usuario.regex" => "El usuario no es valido", "pass.required" => "El password es obligatorio", "pass.min" => "El password debe tener minimo 8 caracteres", "pass.regex" => "El password no es valido");
        if ( empty($datos['pass']) && !empty($datos["id_user"]) ) {
            unset($rules["pass"]);
        }
        return Validator::make($datos, $rules, $messages);
    }
    
    public static function validarDuplicidad($datos,$usuario,$persona){
        $msg = array();
        $msg += BaseController::existe("User", "nombre", $datos["usuario"], $usuario->nombre);
        $msg += BaseController::existe("personaModel", "curp", $datos["curp"], $persona->curp);
        $msg += BaseController::existe("personaModel", "correo", $datos["correo"], $persona->correo);
        return $msg;
        } 
    
    public function getAuthIdentifier() {
        return $this->getKey();
    }

    public function getAuthPassword() {
        return $this->password;
    }

    public function getReminderEmail() {
        return $this->email;
    }

    public function setPasswordAttribute($string) {
        $this->attributes['password'] = Hash::make($string);
    }

    public function getRememberToken() {
        
    }

    public function getRememberTokenName() {
        
    }

    public function setRememberToken($value) {
        
    }

}
