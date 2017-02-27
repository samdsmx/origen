    <h4> <strong>{{ $name. ' '. $lastname }}</strong> </h4>
    <h5> <strong>PRESENTE</strong> </h5>
<br/>
<p>Se ha solicitado el establecimiento de una nueva clave de acceso (contraseña) para la cuenta de usuario que se encuentra activa bajo la siguiente información:</p>
<p> 
    <b>Usuario: </b> {{ $user }} <br/>
    <b>Correo Electrónico: </b> {{ $email }} <br/>
</p>
<p>La contraseña temporal es:</p>
<center>
    <h4>{{ $code }}</h4>
</center>
<br/>
<p>Le pedimos ingrese y modifique la contraseña, dando clic en su perfil.</p>
<p>Si existen datos erróneos en la información presentada, notifíquelo inmediatamente al Centro Nacional de Cálculo para realizar los cambios correspondientes.</p>
<p>Para más información acerca de la Linea de Ayuda Origen consulte los avisos e información de ayuda que se muestran en la página principal del Sistema.</p>
<br/>
<br/>
<p>
    <center>
        <h4><a href="{{ url('/') }}">Sistema de Inventario de Aplicativos</a></h4>
        <a href="http://www.cenac.ipn.mx/">
            <img width="88" height="90" src="{{ asset('images/logo_cenac.gif' ) }}" />
        </a>
        <br/>
        <h5>Central Inteligente de Cómputo, 1er. Piso, Av. Juan de Dios Bátiz S/N, esquina Juan O’Gorman, Unidad Profesional “Adolfo López Mateos”, C.P. 07738, México, D.F., Delegación Gustavo A. Madero, Tels.: 57296000, 57296300 ext. 51509 y 51597 Fax ext. 46104.</h5>
        <br/>
        <div style="font-size: 10px;"><em>Por favor no respondas a este mensaje de correo electrónico.</em></div>
        <hr/>
        <div style="font-size: 10px; color: #666666;">La información de este correo así como la contenida en los documentos que se adjuntan, pueden ser objeto de solicitudes de acceso a la información. Visítanos: <a href="http://www.ipn.mx">http://www.ipn.mx</a></div>
    </center>
</p>