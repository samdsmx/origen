

    <div class="modal-body" id="MSOrganismos-body" style="background: #ffffff;">
        <div class="row">
            <div class="form-group col-md-6">
                <label for="temaBus">Tema:</label>
                <select name="tema" id="temaBus" multiple class="form-control js-example-basic-multiple" style="width:100%;" >
                    @foreach ($catalogo_tema as $t)
                        <option value="{{$t['Nombre']}}">{{$t['Nombre']}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="objetivo">Palabras Clave:</label>
                {!! Form::text('objetivo', '', array('id' => 'objetivo', 'class' => 'form-control', 'style' => 'resize : none;', 'rows' => '3' )) !!}
            </div>
        </div>
        <div class="row">
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
            <button type="button" class="btn btn-success pull-left" data-toggle="modal" data-target="#modalRegistroOrganismo" >
                <span class="fa fa-plus-circle fa-lg"></span>&nbsp;Agregar Organismo
            </button>
            {!! Form::reset('Limpiar', array('class' => 'btn btn-primary', 'id' => "resetearBusqueda")) !!}
            {!! Form::submit('Buscar', array('class' => 'btn btn-success', 'id' => 'btnBuscarOrganismos')) !!}
        </div>
        <div class="row" id="tablaMuestreo" style="display: none;">
            <table id="tablaBusquedaOrganismos" style="padding-left:5%;" class="table table-bordered table-striped table-dataTable text-center">
                <thead>
                    <th class="alert-info col-md-3">TEMA</th>
                    <th class="alert-info col-md-2">INSTITUCI&Oacute;N</th>
                    <th class="alert-info col-md-2">ESTADO</th>
                    <th class="alert-info col-md-2">ACCIONES</th>
                </thead>
                <tbody id="contenidoBusquedaOrganismos"></tbody>
            </table>
        </div>
        <style>

        </style>
    </div>
