{!! Form::open(array('id' => 'buscaOrganismos', 'method'=>'POST')) !!}

        <div class="modal-body" style="background: #ffffff;">

            <div class="form-group col-md-6">
                <label for="tema">Tema:</label>
                <select name="tema" id="tema" multiple class="form-control js-example-basic-multiple" style="width:100%;" >
                    @foreach ($catalogo_tema as $t)
                        <option value="{{$t['Nombre']}}">{{$t['Nombre']}}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group col-md-6">
                <label for="objetivo">Palabras Clave:</label>
                {!! Form::text('objetivo', '', array('id' => 'objetivo', 'class' => 'form-control', 'style' => 'resize : none;', 'rows' => '3' )) !!}
            </div>
            
            <div class="form-group col-md-6">
                <label for="institucion">Institucion:</label>
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
       
        </div>

        <div class="modal-footer" style="background: #ffffff;  border-top-color: #ffffff;">
            {!! Form::reset('Limpiar', array('class' => 'btn btn-primary', 'id' => "resetear")) !!}
            {!! Form::submit('Buscar', array('class' => 'btn btn-success', 'id' => 'btnBuscarOrganismos')) !!}
        </div>

{!! Form::close() !!}