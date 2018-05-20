<?php

namespace App\Http\Controllers;


use DB, Auth, View, Session, Request, Redirect, DateTime, Response, Validator, Mail;

class AuthController extends BaseController {

	public function login() {
                $user_data = array(
		    'nombre' => Request::get('usuario'),
		    'password' => Request::get('password'),
		    'status' => 1
		);
		$user_data1 = array(
		    'nombre' => Request::get('usuario'),
		    'password' => Request::get('password'),
		);
    		if (Auth::attempt($user_data)) {
			return Redirect::to('inicio');
		} else {
			if (Auth::validate($user_data1)) {
				return Redirect::to('index')->with('mensajeError', 'Error al iniciar sesion. Usuario inactivo.')->with('tituloMensaje', 'Bueno, esto estuvo mal');
			} else {
				return Redirect::to('index')->with('mensajeError', 'Usuario y/o contraseña incorrectos.')->with('tituloMensaje', 'Bueno, esto estuvo mal');
			}
		}
	}

    public function recover() {
        $correo= Request::get('correo');
        $usuario = DB::select("select p.*, s.nombre, s.password, s.status from persona p, consejeros s where p.correo = '".$correo."' and s.id_persona = p.id_persona");
        if ($usuario != null && $usuario[0]->status == 1){
              $codigo= substr($usuario[0]->password,-6);
              $data = ['name' => $usuario[0]->nombres, 'lastname' => $usuario[0]->primer_apellido.' '.$usuario[0]->segundo_apellido, 'user' => $usuario[0]->nombre, 'email' => $correo, 'code' => $codigo];
              $usu = User::where('nombre', '=',  $usuario[0]->nombre)->first();
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
        if (Auth::guest()){
            return View::make('index');
        }
        if (Auth::user()->status == 1) {
            $mes = intval(date('m'));
            $llamadasMes = DB::table('llamadas')->
                select(DB::raw('count(IDCaso) as cuenta'))
                ->whereMonth('FechaLlamada','=',$mes)
                ->get();
            $menu = parent::createMenu();
            $misAtendidas = DB::table('llamadas')->
                select(DB::raw('count(IDCaso) as cuenta'))
                ->whereMonth('FechaLlamada','=',$mes)
                ->where('Consejera', DB::raw('"'.Auth::user()->nombre.'"'))
                ->get();
            return View::make('inicio', array('menu' => $menu, 
                'llamadasMes' => $llamadasMes, 'misAtendidas' => $misAtendidas));
        } else {
            Auth::logout();
            return View::make('index');
        }
    }

    public function logout() {
			try{
        Auth::logout();
			}catch(Exception $e) {
				echo $e;
			}

        return Redirect::to('index')->with('mensaje', 'Tu sesión ha sido cerrada.')->with('tituloMensaje', '¡Hasta luego!');
    }

}
