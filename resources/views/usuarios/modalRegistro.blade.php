<div class="modal fade bs-example-modal-lg" id="modalRegistroUsuario" tabindex="-1" role="dialog" aria-hidden="true">
    {!! Form::open(array('id' => 'registraUsuario')) !!}
    <div class="modal-dialog modal-lg" >
        <div class="modal-content" style="background: transparent" >
            <div class="modal-header" style="background-color: #3498DB; border-top: 1px solid #70B6E5;border-bottom: 5px solid #2372A7; border-radius: 5px 5px 0 0;">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                <h4 class="modal-title" id="registroLabel" style="color: #ffffff; text-align: center; font-weight: bolder;">Nuevo usuario</h4>
            </div>
            <div class="modal-body" style="background: #ffffff; padding-bottom: 10px;">
                <input type="hidden" value="" name ="id_user" id="id_user" />
                <div class="row text-center">
                    <div class="col-lg-4">
                        <div class='form-group' id="dnombres">
                            {!! Form::text("nombres", '' , array_merge(['class' => 'form-control', 'placeholder' => "Nombre(s)", "id" => "nombres"] )) !!}
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class='form-group' id="dapaterno">
                            {!! Form::text("apaterno", '' , array_merge(['class' => 'form-control', 'placeholder' => "Apellido Paterno", "id" => "apaterno"] )) !!}
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class='form-group' id="damaterno">
                            {!! Form::text("amaterno", '' , array_merge(['class' => 'form-control', 'placeholder' => "Apellido Materno", "id" => "amaterno"] )) !!}
                        </div>
                    </div>
                </div>
                <div class="row text-center">
                    <div class="col-lg-4">
                        <div class='form-group' id="dcurp">
                            <input type="text" id="curp"  name="curp" class="form-control" placeholder="CURP" />
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class='form-group' id="dcorreo">
                            <input type="text" id="correo"  name="correo" class="form-control" placeholder="Correo electronico" />
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class='form-group' id="dtelefono">
                            <input type="text" id="telefono"  name="telefono" class="form-control" placeholder="Telefono o extension" />
                        </div>
                    </div>
                </div>
                <div class="row text-center">
                    <div class="col-lg-6">
                        <div class='form-group' id="dusuario">
                            <input type="text" id="usuario"  name="usuario" class="form-control" placeholder="Usuario" />
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class='form-group' id="dpass">
                            <input type="password" id="pass"  name="pass" class="form-control" placeholder="Password"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="background: #ffffff;">
                {!! Form::reset('Limpiar', array('class' => 'btn btn-primary', 'id' => "resetearUsuario")) !!}
                {!! Form::submit('Guardar', array('class' => 'btn btn-success', 'id' => 'btnGuardausuario')) !!}
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>