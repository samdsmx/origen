<div class="modal fade bs-example-modal-md" id="modalRegistroOrganismo" tabindex="-1" role="dialog" aria-hidden="true">
    {!! Form::open(array('id' => 'registraOrganismo', 'method'=>'post')) !!}
    <div class="modal-dialog modal-md" >
        <div class="modal-content" style="background: transparent" >
            <div class="modal-header"
                 style="background-color: #ff8018; border-top: 1px solid #fda65f;
                 border-bottom: 5px solid #fda65f; border-radius: 5px 5px 0 0;">
                <button onclick="limpiarCampos()" type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Cerrar</span>
                </button>
                <h4 class="modal-title" id="registroLabel"
                    style="color: #ffffff; text-align: center; font-weight: bolder;">
                    Organismos
                </h4>
            </div>
            <div class="modal-body" style="background: #ffffff; padding-bottom: 10px;">
                <input type="hidden" value="" name ="ID" id="ID" />

                <div class="form-group col-md-6">
                    <label for="Tema">*Tema:</label>
                    <select name="Tema" id="Tema" multiple class="form-control js-example-basic-multiple col-lg-12" >
                        @foreach ($catalogo_tema as $t)
                            <option value="{{$t['Nombre']}}">{{$t['Nombre']}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label for="Objetivo">Objetivo:</label>
                    {!! Form::textarea('Objetivo', '', array('id' => 'Objetivo', 'class' => 'form-control', 'style' => 'resize : none;', 'rows' => '3' )) !!}
                </div>

                <div class="form-group col-md-6">
                    <label for="Institucion">*Institucion:</label>
                    {!! Form::text('Institucion', '',  array('class' => 'form-control', 'id' => 'Institucion')) !!}
                </div>

                <div class="form-group col-md-6">
                    <label for="Estado">Estado:</label>
                    <select name="Estado" id="Estado" class="form-control">
                        <option value="-1">-</option>
                        @foreach ($estados as $k => $v)
                            <option value="{{$v}}">{{$v}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label for="Direccion">*Direccion:</label>
                    {!! Form::textarea('Direccion', '', array('id' => 'Direccion', 'class' => 'form-control', 'style' => 'resize : none;', 'rows' => '3' )) !!}
                </div>

                <div class="form-group col-md-6">
                    <label for="Referencia">Referencia:</label>
                    {!! Form::textarea('Referencia', '', array('id' => 'Referencia', 'class' => 'form-control', 'style' => 'resize : none;', 'rows' => '3' )) !!}
                </div>

                <div class="form-group col-md-6">
                    <label for="Telefono">*Telefono:</label>
                    {!! Form::text('Telefono', '', array('id' => 'Telefono', 'class' => 'form-control' )) !!}
                </div>

                <div class="form-group col-md-6">
                    <label for="Email">Email:</label>
                    {!! Form::text('Email', '', array('id' => 'Email', 'class' => 'form-control' )) !!}
                </div>

                <div class="form-group col-md-12">
                    <label for="Observaciones">Observaciones:</label>
                    {!! Form::textarea('Observaciones', '', array('id' => 'Observaciones', 'class' => 'form-control', 'style' => 'resize : none;', 'rows' => '3' )) !!}
                </div>

                <div class="form-group col-md-6">
                    <label for="Requisitos">Requisistos:</label>
                    {!! Form::textarea('Requisitos', '', array('id' => 'Requisitos', 'class' => 'form-control', 'style' => 'resize : none;', 'rows' => '3' )) !!}
                </div>

                <div class="form-group col-md-6">
                    <label for="HorariosCostos">Horarios y Costos:</label>
                    {!! Form::textarea('HorariosCostos', '', array('id' => 'HorariosCostos', 'class' => 'form-control', 'style' => 'resize : none;', 'rows' => '3' )) !!}
                </div>
            </div>
            <div class="modal-footer" style="background: #ffffff;">
                {!! Form::reset('Borrar', array('class' => 'btn btn-primary', 'id' => "resetear")) !!}
                {!! Form::submit('Guardar', array('class' => 'btn btn-success', 'id' => 'btnRegistraOrganismo')) !!}
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>
