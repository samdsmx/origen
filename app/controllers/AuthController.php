<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AuthController
 *
 * @author Angel
 */
class AuthController extends BaseController {

    public function login() {
        $user_data = array(
            'usuario' => Input::get('usuario'),
            'password' => Input::get('password'),
        );
        if (Auth::attempt($user_data)) {
            return Redirect::to('inicio');
        } else {
            return Redirect::to('index')->with('mensajeError', 'Usuario y/o contraseña incorrectos.')->with('tituloMensaje', 'Bueno, esto estuvo mal');
        }
    }

    public function recover() {
        $correo=Input::get('correo');
        $usuario = DB::select("select p.*, s.usuario, s.password, s.status from sia_persona p, sia_usuario s where p.correo = '".$correo."'");
        if ($usuario != null && $usuario[0]->status == 1){
              $codigo= substr($usuario[0]->password,-6);
              $data = ['name' => $usuario[0]->nombres, 'lastname' => $usuario[0]->primer_apellido.' '.$usuario[0]->segundo_apellido, 'user' => $usuario[0]->usuario, 'email' => $correo, 'code' => $codigo];
              $usu = User::where('usuario', '=',  $usuario[0]->usuario)->first();
              $usu->password = $codigo;
              $usu->save();
              Mail::send('emails.enviarUsuarioAPeticion', $data, function ($message) use ($correo) {
                    $message->subject('Clave Temporal de acceso');
                    $message->to($correo);
                });
            return Redirect::to('index')->with('mensaje', 'Se ha enviado un correo a la dirección ' . $correo . ' con una contraseña temporal.')->with('tituloMensaje', 'Correo Enviado');
            }
            else{
                return Redirect::to('index')->with('mensajeError', 'No existe un usuario con el correo '.$correo)->with('tituloMensaje', 'Correo no registrado.');
            }
        
    }

    public function inicio() {
        if (Auth::user()->status == 1) {
            $menu = parent::createMenu();
            return View::make('inicio', array('menu' => $menu));
        } else {
            Auth::logout();
            return View::make('index');
        }
    }

    public function logout() {
        Auth::logout();
        return Redirect::to('index')->with('mensaje', 'Tu sesión ha sido cerrada.')->with('tituloMensaje', '¡Hasta luego!');
    }

}
