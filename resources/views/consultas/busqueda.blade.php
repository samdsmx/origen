{!! Form::open(array('id' => 'buscaCasos', 'method'=>'POST')) !!}

        <div class="modal-body" style="background: #ffffff;">

            <div class="form-group col-md-4">
                <label for="telefono">ID de caso:</label>
                {!! Form::text('edad', '',  array('class' => 'form-control', 'id' => 'edad')) !!}
            </div>     

            <div class="form-group col-md-4">
                <label for="nombre">Nombre:</label>
                {!! Form::text('nombre', '',  array('class' => 'form-control', 'id' => 'nombre')) !!}
            </div>

            <div class="form-group col-md-4">
                <label for="telefono">Motivos (psicológico, legal, etc):</label>
                {!! Form::text('motivos', '',  array('class' => 'form-control', 'id' => 'motivos')) !!}
            </div>     

            <div class="form-group col-md-4">
                <label for="consejera">Consejera:</label>
            </div>     

            <div class="form-group col-md-6">
                <label for="fecha">De la fecha:</label>
                {!! Form::text('fechaInicial', '',  array('class' => 'form-control', 'id' => 'fechaInicial')) !!}
                {!! Form::checkbox('multiplesFechas', 'true',  array('class' => 'form-control', 'id' => 'multiplesFechas',)) !!}
                <label for="fecha">Quiero un rango de fechas:</label>
            </div>     

            <div class="form-group col-md-6">
                <label for="fecha">Hasta la fecha:</label>
                {!! Form::text('fechaFinal', '',  array('class' => 'form-control', 'id' => 'fechaFinal')) !!}
            </div>     
      
        </div>

        <div class="modal-footer" style="background: #ffffff;  border-top-color: #ffffff;">
            {!! Form::reset('Limpiar', array('class' => 'btn btn-primary', 'id' => "resetear")) !!}
            {!! Form::submit('Buscar', array('class' => 'btn btn-success', 'id' => 'btnBuscarCasos')) !!}
        </div>

{!! Form::close() !!}