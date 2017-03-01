<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {
  
    protected $table = 'sia_usuario';
    protected $primaryKey = 'id_usuario';
    protected $fillable = ['id_persona', 'usuario', 'password', 'status'];
    protected $hidden = ['password', 'remember_token'];
    public $timestamp = true;
    
    public function persona(){
        return $this->belongsTo('siaPersonaModel', 'id_persona');
    }
    
    public function usuarioatividad(){
        return $this->hasMany('siaAsoUsuarioActividadModel', 'id_usuario');
    }
    
    public static function validar($datos){
        $rules = array("nombres" => "required|regex:/^[a-zA-ZáéíóúñÁÉÍÓÚÑ][a-zA-ZáéíóúñÁÉÍÓÚÑ\s]*/", "apaterno" => "required|regex:/^[a-zA-ZáéíóúñÁÉÍÓÚÑ][a-zA-ZáéíóúñÁÉÍÓÚÑ\s]*/", "amaterno" => "regex:/^[a-zA-ZáéíóúñÁÉÍÓÚÑ][a-zA-ZáéíóúñÁÉÍÓÚÑ\s]*/", "curp" => 'required|regex:/^([A-Z]{4})([0-9]{6})([A-Z]{6})([0-9]{2})+$/', "correo" => "required|email", "telefono" => "required|digits:10", "ur" => "required|numeric", "usuario" => "required|regex:/^[a-zA-Z_\-\/0-9]+/", "pass" => "required|min:4|regex:/^[a-zA-Z_\-\/0-9]+/");
        $messages = array("nombres.required" => "El nombre es obligatorio", "nombres.regex" => "El nombre no es valido", "apaterno.required" => "El A. Paterno es obligatorio", "apaterno.regex" => "El A. Paterno no es valido", "amaterno.regex" => "El A. Materno no es valido", "curp.required" => "El CURP es obligatorio", "curp.regex" => "El CURP no es valido", "correo.required" => "El correo es obligatorio", "correo.regex" => "El correo no es valido", "telefono.required" => "El telefono es obligatorio", "telefono.digits" => "El telefono debe ser de 10 digitos", "ur.required" => "La Unidad Responsable es obligatoria", "ur.numeric" => "La Unidad Responsable no es valida", "correo.numeric" => "La Unidad Responsable no es valida", "usuario.required" => "El usuario es obligatorio", "usuario.regex" => "El usuario no es valido", "pass.required" => "El password es obligatorio", "pass.min" => "El password debe tener minimo 8 caracteres", "pass.regex" => "El password no es valido");
        if ( empty($datos['pass']) && !empty($datos["id_user"]) ) {
            unset($rules["pass"]);
        }
        return Validator::make($datos, $rules, $messages);
    }
    
    public static function validarDuplicidad($datos,$usuario,$persona){
        $msg = array();
        $msg += BaseController::existe("User", "usuario", $datos["usuario"], $usuario->usuario);
        $msg += BaseController::existe("siaPersonaModel", "curp", $datos["curp"], $persona->curp);
        $msg += BaseController::existe("siaPersonaModel", "correo", $datos["correo"], $persona->correo);
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
