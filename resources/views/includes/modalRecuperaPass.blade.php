<div class="modal fade" id="modalRecuperaPass" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                <h4 class="modal-title" id="acercaDeLabel">Recuperación de contraseña</h4>
            </div>
            {!! Form::open(array('url' => 'recover', 'id' => 'formLogin', 'role' => 'form', 'method' => 'post')) !!}
            <div class="modal-body">
                <div class='form-group'>
                    <div class='input-group'>
                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                        <input type="text" id="correo"  name="correo" class="form-control" placeholder="Correo electronico" />
                    </div>
                    <p style="text-align: center; padding: 10px;">
                    Recibira un correo con una contraseña temporal. Le pedimos ingrese al sistema y la cambia para mayor seguridad.
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                {!! Form::submit('Enviar', array('class' => 'btn btn-success', 'id' => 'btnGuardausuario')) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>