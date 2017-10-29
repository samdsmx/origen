{!! Form::open(array('id' => 'buscaCasos', 'method'=>'POST')) !!}

        <div class="modal-body" style="background: #ffffff;">

            <div class="form-group col-md-3">
                <label for="clave">Clave:</label>
                {!! Form::text('clave', '', array('id' => 'clave', 'class' => 'form-control', 'style' => 'resize : none;', 'rows' => '3' )) !!}
            </div>
            
            <div class="form-group col-md-3">
                <label for="nombre">Nombre:</label>
                {!! Form::text('nombre', '',  array('class' => 'form-control', 'id' => 'nombre')) !!}
            </div>

            <div class="form-group col-md-3">
                <label for="telefono">Telefono:</label>
                {!! Form::text('telefono', '',  array('class' => 'form-control', 'id' => 'telefono')) !!}
            </div>     

            <div class="form-group col-md-3">
                <label for="fecha">Fecha:</label>
                {!! Form::text('fecha', '',  array('class' => 'form-control', 'id' => 'fecha')) !!}
            </div>     
      
        </div>

        <div class="modal-footer" style="background: #ffffff;  border-top-color: #ffffff;">
            {!! Form::reset('Limpiar', array('class' => 'btn btn-primary', 'id' => "resetear")) !!}
            {!! Form::submit('Buscar', array('class' => 'btn btn-success', 'id' => 'btnBuscarCasos')) !!}
        </div>

{!! Form::close() !!}