<div class="modal fade bs-example-modal-md" id="modalRegistroOrganismo" tabindex="-1" role="dialog" aria-hidden="true">
    {!! Form::open(array('id' => 'registraOrganismo', 'method'=>'post')) !!}
    <div class="modal-dialog modal-md" >
        <div class="modal-content" style="background: transparent" >
            <div class="modal-header" 
                 style="background-color: #ff8018; border-top: 1px solid #fda65f; 
                 border-bottom: 5px solid #fda65f; border-radius: 5px 5px 0 0;">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Cerrar</span>
                </button>
                <h4 class="modal-title" id="registroLabel" 
                    style="color: #ffffff; text-align: center; font-weight: bolder;">
                    Organismos
                </h4>
            </div>
            <div class="modal-body" style="background: #ffffff; padding-bottom: 10px;">
                <input type="hidden" value="" name ="id_organismo" id="id_organismo" />
                
                <div class="form-group col-md-6">
                    <label for="tema">*Tema:</label>
                    <select name="tema" id="tema" multiple class="form-control js-example-basic-multiple col-lg-12" >
                        @foreach ($catalogo_tema as $t)
                            <option value="{{$t['Nombre']}}">{{$t['Nombre']}}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group col-md-6">
                    <label for="objetivo">Objetivo:</label>
                    {!! Form::textarea('objetivo', '', array('id' => 'objetivo', 'class' => 'form-control', 'style' => 'resize : none;', 'rows' => '3' )) !!}
                </div>
                
                <div class="form-group col-md-6">
                    <label for="institucion">*Institucion:</label>
                    {!! Form::text('institucion', '',  array('class' => 'form-control', 'id' => 'institucion')) !!}
                </div>
                
                <div class="form-group col-md-6">
                    <label for="estado">Estado:</label>
                    <select name="estado" id="estado" class="form-control">
                        <option value="-1">-</option>
                        @foreach ($estados as $k => $v)
                            <option value="{{$v}}">{{$v}}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group col-md-6">
                    <label for="direccion">*Direccion:</label>
                    {!! Form::textarea('direccion', '', array('id' => 'direccion', 'class' => 'form-control', 'style' => 'resize : none;', 'rows' => '3' )) !!}
                </div>
                
                <div class="form-group col-md-6">
                    <label for="referencia">Referencia:</label>
                    {!! Form::textarea('referencia', '', array('id' => 'referencia', 'class' => 'form-control', 'style' => 'resize : none;', 'rows' => '3' )) !!}
                </div>
                
                <div class="form-group col-md-6">
                    <label for="telefono">*Telefono:</label>
                    {!! Form::text('telefono', '', array('id' => 'telefono', 'class' => 'form-control' )) !!}
                </div>
                
                <div class="form-group col-md-6">
                    <label for="email">Email:</label>
                    {!! Form::text('email', '', array('id' => 'email', 'class' => 'form-control' )) !!}
                </div>
                
                <div class="form-group col-md-12">
                    <label for="observaciones">Observaciones:</label>
                    {!! Form::textarea('observaciones', '', array('id' => 'observaciones', 'class' => 'form-control', 'style' => 'resize : none;', 'rows' => '3' )) !!}
                </div>
                
                <div class="form-group col-md-6">
                    <label for="requisitos">Requisistos:</label>
                    {!! Form::textarea('requisitos', '', array('id' => 'requisitos', 'class' => 'form-control', 'style' => 'resize : none;', 'rows' => '3' )) !!}
                </div>
                
                <div class="form-group col-md-6">
                    <label for="hycostos">Horarios y Costos:</label>
                    {!! Form::textarea('hycostos', '', array('id' => 'hycostos', 'class' => 'form-control', 'style' => 'resize : none;', 'rows' => '3' )) !!}
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