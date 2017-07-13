<ul class="nav navbar-nav navbar-right">
    <li><a data-toggle="modal" data-target="#modalAcercaDe" style="cursor: pointer;"><i class='fa fa-info-circle fa-lg'></i> Acerca De</a></li>
    <li class="dropdown user user-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class='fa fa-sign-in fa-lg'></i>
            Iniciar Sesión
        </a>
        <ul id="boxLogin" class="dropdown-menu">
            <li class="user-header text-center">
                <img src="{!! asset('images/LogoMonita.png' ) !!}" style="border:0;" />
                <p>
                    Callcenter <small>El Ingreso a esta parte no esta disponible para el público en general.</small>
                </p>
            </li>
            <li class="user-body">
                {!! Form::open(array('url' => 'login', 'id' => 'formLogin', 'role' => 'form', 'method' => 'post')) !!}
                <div class='form-group'>
                    <div class='input-group'>
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        {!!Form::text('usuario', '', array('class' => 'form-control', 'id' => 'loginUsuario', 'placeholder' => 'Usuario', 'autocomplete' => 'on'))!!}
                    </div>
                </div>
                <div class='form-group'>
                    <div class='input-group'>
                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                        {!! Form::password('password', array('class' => 'form-control', 'id' => 'loginContrasena', 'placeholder' => 'Contraseña')) !!}
                    </div>
                </div>
                <div class='form-group'>
                    <button type="submit" class="btn btn-block btn-info btn-flat"><i class="fa fa-sign-in fa-lg"></i> Iniciar </button>
                </div>
                {!! Form::close() !!}
                <a data-toggle="modal" data-target="#modalRecuperaPass" style="color:#337ab7 !important; text-align:center; padding: 0; margin: 0;">Recuperar contraseña</a>
            </li>
        </ul>
    </li>
</ul>