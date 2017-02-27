    <h4> <strong>{{ $name. ' '. $lastname }}</strong> </h4>
    <h5> <strong>PRESENTE</strong> </h5>
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
<p>Si existen datos erróneos en la información presentada, notifíquelo inmediatamente para realizar los cambios correspondientes.</p>
<p>Para más información acerca de la Linea de Ayuda Origen consulte los avisos e información de ayuda que se muestran en la página principal del Sistema.</p>
<br/>
<p>
    <center>
        <h4><a href="{{ url('callcenter') }}">Sistema Callcenter Origen</a></h4>
        <br/>
        <h5>
            Pro Ayuda a la Mujer Origen A.C. Juan O´Donojú 221 Lomas Virreyes, Ciudad de México. 
            Telefono: 55 20 44 21 y 0115 Correo: kenriquez@origenac.org &copy;2017
        </h5>
        <br/>
        <div style="font-size: 10px;"><em>Por favor no respondas a este mensaje de correo electrónico.</em></div>
        <hr/>
        <div style="font-size: 10px; color: #666666;">La información de este correo así como la contenida en los documentos que se adjuntan, pueden ser objeto de solicitudes de acceso a la información. Visítanos: <a href="http://www.ipn.mx">http://www.ipn.mx</a></div>
    </center>
</p>