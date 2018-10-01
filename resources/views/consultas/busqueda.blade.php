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
                <select name="motivos" id="motivos" multiple class="form-control js-example-basic-multiple" style="width:100%;" >
                    @foreach ($motivos as $motivo)
                        <option value="{{ $motivo->Tipo.'-'.$motivo->Nombre }}">{{ $motivo->Nombre }}</option>
                    @endforeach
                </select>
            </div>     

            <div class="form-group col-md-3">
                <label for="consejera">Consejera:</label>
                <select name="consejera" id="consejera" class="form-control col-md-3">
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
            </div>     

            <div class="form-group col-md-6">
                <label for="fecha">Hasta la fecha:</label>
                {!! Form::text('fechaFinal', '',  array('class' => 'form-control', 'id' => 'fechaFinal')) !!}
            </div>     
      
        </div>

        <div class="modal-footer col-md-12" style="background: #ffffff;  border-top-color: #ffffff;">
            {!! Form::reset('Limpiar', array('class' => 'btn btn-primary', 'id' => "resetear")) !!}
            {!! Form::submit('Buscar', array('class' => 'btn btn-success', 'id' => 'btnBuscarCasos')) !!}
        </div>

{!! Form::close() !!}