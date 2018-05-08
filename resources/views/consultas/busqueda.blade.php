{!! Form::open(array('id' => 'buscaCasos', 'method'=>'POST')) !!}

        <div class="modal-body" style="background: #ffffff;">

            <div class="form-group col-md-3">
                <label for="id">ID de caso:</label>
                {!! Form::text('id', '',  array('class' => 'form-control', 'id' => 'id')) !!}
            </div>     

            <div class="form-group col-md-3">
                <label for="nombre">Nombre:</label>
                {!! Form::text('nombre', '',  array('class' => 'form-control', 'id' => 'nombre')) !!}
            </div>

            <div class="form-group col-md-3">
                <label for="motivos">Motivos (psicológico, legal, etc):</label>
                {!! Form::text('motivos', '',  array('class' => 'form-control', 'id' => 'motivos')) !!}
            </div>     

            <div class="form-group col-md-3">
                <label for="consejera">Consejera:</label>
                <select name="consejera" id="consejera" class="form-control">
                    <option value="-1">-</option>
                    @foreach($consejeras as $v)
                    <option value="{!! $v->id_persona !!}"> 
                        {!! $v->nombres!!} {!!$v->primer_apellido !!} {!!$v->segundo_apellido!!} 
                    </option>
                    @endforeach
                </select>
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