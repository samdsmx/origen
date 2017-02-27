<li class="dropdown user user-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <span>{{ Auth::user()->usuario }}</span>
    </a>
    <ul class="dropdown-menu">
        <li class="user-header">
            <p>
                <b>{{ Auth::user()->persona->nombres." ".Auth::user()->persona->primer_apellido." ".Auth::user()->persona->segundo_apellido }} </b>
            </p>
        </li>                
        <li class="user-footer">
            <div class="pull-left">
                <button type="button" class="btn btn-default btn-flat open-UserUpdaterModal" data-toggle="modal" data-target="#modalRegistroUsuario" data-id="{{Auth::user()->id_usuario}}">
                <i class='fa fa-user'></i>&nbsp;Perfil</button>
            </div>
            <div class="pull-right">
                <a href="{{ url('logout')}} " class="btn btn-default btn-flat"><i class='fa fa-sign-out'></i>&nbsp;Cerrar Sesión</a>
            </div>
        </li>
    </ul>
</li>