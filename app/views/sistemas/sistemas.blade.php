@extends('layouts.baseInicio')
@section('titulo')
Sistemas
@stop

@section('tituloSistema')
@include('includes.tituloSistemaInicio')
@stop

@section('menu')
@include('includes.menu')
@stop

@section('opcionesDerecha')
@include('includes.opcionesDerechaInicio')
@stop

@section('encabezado') 
@stop

@section('cuerpo')
<section class="content-header">
    <h1 style="color:#605ca8;font-weight: bolder;">Consultas</h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('inicio') }}"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="#">Sistemas</a></li>
    </ol>
</section>
<section class="content">
    <div class="row" style="padding-bottom: 100px;">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <fieldset>
                        <legend>Buscar:</legend>
                        <table >
                            <tr>
                                <td style="padding: 5px;">
                                    <label>Estatus: </label>
                                </td>
                                <td style="padding: 5px;">
                                    <select id="estatus_filter" name="estatus_filter">
                                        <option value="0">-- TODOS --</option>                                                                                      
                                        <option value="1">Sin Cambios</option>                                            
                                        <option value="2">Nuevos</option>
                                        <option value="3">Actualizados - Completados</option>
                                        <option value="3">Actualizados - Sin Completar</option>  
                                        <option value="4">Baja</option>
                                        <option value="5">Migración</option>
                                    </select>
                                </td>
                                <td style="padding: 5px;">
                                    <label>Periodo: </label>
                                </td>
                                <td style="padding: 5px;">
                                    {{ $periodos }}
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 5px;"><b>Pregunta: </b></td>
                                <td colspan="3" style="padding: 5px;">
                                    <select name="select_filter" id="selectOpcionPregunta">
                                        <option selected value="0">Sn contestar</option>
                                        @foreach($opcionesPregunta as $op)
                                        <option value="{{$op->id_propiedad}}-{{$op->id_tipo}}">{{$op->descripcion}}</option>	    
                                        @endforeach
                                    </select></td>
                            </tr>
                            <tr>
                                <td  id="textoOpcionPregunta" class="form-inline" style="padding: 5px;" colspan="4">
                                    <b>Respuesta:</b>
                                </td>
                            </tr>
                        </table>
                        <div style="float: right;"> 
                            <button type="button" class="btn btn-primary actualizar" title="Buscar" id="buscarSistemas">
                                <i class="fa fa-search fa-2x"></i>
                            </button>
                        </div>
                    </fieldset>
                    <table id="tablaSistemas" class="table table-bordered table-striped table-dataTable text-center" width="100%">
                        <thead>
                        <th class="alert-info col-md-5">NOMBRE DE LOS SISTEMAS</th>
                        <th class="alert-info col-md-2">AVANCE</th>
                        <th class="alert-info col-md-2">ESTATUS</th>
                        <th class="alert-info col-md-2">ACCIONES</th>
                        <th class="alert-info col-md-1">FICHA</th>	
                        </thead>
                        <tbody>
                            @foreach($sistemas as $sistema)
                            <tr>
                                <td class="text-center text-info">{{ $sistema->sistema}}</td>
                                <td class="text-center text-info">
                                    <div class="progress progress-sm active">
                                        <div class="progress-bar progress-bar-green" 
                                             role="progressbar" aria-valuenow="{{ round($sistema->estado) }}" aria-valuemin="0" 
                                             aria-valuemax="100" style="width:{{ round($sistema->estado)}}%">
                                        </div>
                                    </div>
                                    <br/>
                                    <span>{{ round($sistema->estado) }} % completado</span>
                                </td>
                                <td class="text-center text-info">
                                    <h4>
                                        {{ $sistema->status }}
                                    </h4>
                                </td>
                                <td class="text-center text-info">
                                    <div class="btn-group">
                                        <a href="{{ url('Ver/'.$sistema->sistemaid) }}" data-toogle="tooltip" data-placement="top" title="Ver">
                                            <button type="button" class="btn btn-primary actualizar">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                        </a>
                                    </div>
                                </td>   
                                <td class="text-center text-info">
                                    @if($sistema->status == "Activo - Completado")
                                    <a href="{{ url('/Sistemas/crearexcel/'.$sistema->sistemaid) }}"><img width="35" src="{{ asset('images/xls.png' )}}"/></a>
                                    @else
                                    <a href="#"><img width="35" src="{{ asset('images/xls.png' )}}" style="opacity: 0.4;"/></a>
                                    @endif
                                    @if($sistema->status == "Activo - Completado")
                                    <a href="{{ url('/Sistemas/crearpdf/'.$sistema->sistemaid) }}"><img width="35" src="{{ asset('images/pdf.png' )}}"/></a>
                                    @else
                                    <a href="#"><img width="35" src="{{ asset('images/pdf.png' )}}" style="opacity: 0.4;"/></a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
         <div  id="cargando">
            <image src="../images/loading.gif" style="margin-top: 20%; margin-left: 45%;"/>
        </div>
    </div>
</section>
@stop
@section('recursosExtra')
{{ HTML::script('js/plugins/gauge.js') }}
<script>
    
    $('#tablaSistemas').DataTable({
        scrollX: false,
        responsive: true,
        searching: true,
        paging: true,
        lengthMenu: [[5, 10, 15, 20], [5, 10, 15, 20]],
        ordering: true,
        info: true,
        order: [[0, "asc"]],
        language: dataTablesSpanish,
        sDom: 'Rfrt <"col-md-12" <"col-md-4 pull-left"i> <"paginacion" <"opcionPaginacion"l> p > >',
        columnDefs: [{orderable: false, targets: [0, 1]}]
    });
    
    $('#selectOpcionPregunta').change(function(){
    var opcionPregunta = $('#selectOpcionPregunta').val();
            if (opcionPregunta == 0){
    $('#textoOpcionPregunta').empty();
            $('#textoOpcionPregunta').html('<p><b>Respuesta</b></p>');
    } else{
    var opcionDividida = opcionPregunta.split('-');
            if (opcionDividida[1] == 1 || opcionDividida[1] == 5){
    $('#textoOpcionPregunta').empty();
            $('#textoOpcionPregunta').html('<b>Respuesta:</b> <div id="variablesOpcionPregunta">'
            + '<select name="select_respuesta_filter" id="filtroSelectGraficas" class="form-control col-lg-5 col-md-5 col-sm-5 col-xs-5">'
            + '<option value="=" selected>=</option>'
            + '<option value="<>">&#60;&#62;</option>'
            + '<option value="like"> like </option>'
            + '<option value="is null"> is null </option>'
            + '<option value="is not null"> not null </option>'
            + '</select> '
            + '<input name="respuesta_filter" type="text" id="inputTextOpcionPregunta" class="form-control col-lg-5 col-md-5 col-sm-5 col-xs-5">'
            + '</div>');
            $('#filtroSelectGraficas').change(function(){
    deshabilitarInput(this, '#inputTextOpcionPregunta');
    });
    } else if (opcionDividida[1] == 2){
    $('#textoOpcionPregunta').empty();
            buscarInformacion(opcionDividida[1], opcionDividida[0]);
    } else if (opcionDividida[1] == 3){
    $('#textoOpcionPregunta').empty();
            buscarInformacion(opcionDividida[1], opcionDividida[0]);
    } else if (opcionDividida[1] == 4){
    $('#textoOpcionPregunta').empty();
            buscarInformacion(opcionDividida[1], opcionDividida[0]);
    } else if (opcionDividida[1] == 6){
    $('#textoOpcionPregunta').empty();
            var fullDate = new Date();
            var twoDigitMonth = ((fullDate.getMonth().length + 1) === 1)? (fullDate.getMonth() + 1) : '0' + (fullDate.getMonth() + 1);
            var currentDate = fullDate.getFullYear() + "-" + twoDigitMonth + "-" + fullDate.getDate();
            $('#textoOpcionPregunta').html('Respuesta: <input name="respuesta_filter" type="date" id="inputTextOpcionPregunta" step="1" value="' + currentDate + '">');
    } else{
    $('#textoOpcionPregunta').empty();
            mostrarMensajeError("Error al acceder a la información  solicitada, intenta de nuevo más tarde. Si el error persiste, contacta al administrador del sistema");
    }
    }
    });
            function deshabilitarInput(select, input){
            var opcion = $(select).val();
                    if (opcion == "is null" || opcion == "is not null"){
            $(input).attr('disabled', true);
            } else{
            $(input).removeAttr('disabled');
            }
            }

    function buscarInformacion(tipo, id){
    $.ajax({
    url: 'Consultas/obtenerlistado/' + tipo + '/' + id,
            success: function(data){
            if (data == 'error'){
            mostrarMensajeError('Ha ocurrido un error debido a que la información introducida no es correcta. Vuelva a intentarlo más tarde.');
                    console.log('nice try');
            } else{
            var cantidad = data.length;
                    $('#textoOpcionPregunta').html('Respuesta: <select name="respuesta_filter" id="inputTextOpcionPregunta"><select>');
                    for (var i = 0; i < cantidad; i++){
            $('#inputTextOpcionPregunta').append('<option value="' + data[i].id + '">' + data[i].valor + '</option>');
            }
            }
            },
            error: function(xhr){
            mostrarMensajeError("Ocurrio un error en el servidor. Intente de nuevo más tarde, y si persiste, por favor contacte con el administrador del sistema.");
            }
    });
            }

    $('.sinCambios').click(function(e) {
    e.preventDefault();
            var data = "Id=" + $(this).data("id");
            $.ajax({
            type: 'POST',
                    data: data,
                    url: 'Sistemas/reportarsincambios',
                    success: function(response) {
                    if (response.mensaje) {
                    mostrarMensaje("<p>" + response.mensaje + "</p>");
                    } else {
                    window.location.href = "Sistemas";
                    }
                    },
                    error: function(xhr){
                    mostrarMensajeError("Ocurrio un error en el servidor. Intente de nuevo más tarde, y si persiste, por favor contacte con el administrador del sistema.");
                    }
            });
    });
            $('#buscarSistemas').on("click", function() {
    $('#cargando').attr('style', 'width: 110%; height: 100%; position: fixed; left: 0px; top:0px; background-color: rgb(255,255,255); opacity: 0.7; z-index: 8000; display: block;');
            var select = $('#selectOpcionPregunta').val();
            var estatus = $('#estatus_filter').val();
            var periodo = $('#periodo_filter').val();
            var variables = 0;
            var texto = 0;
            if (periodo > 0){
    variables = $('#filtroSelectGraficas').val();
            if (variables == 'is null' || variables == 'is not null'){
    texto = '';
    } else if (variables == '=' || variables == '<>' || variables == 'like'){
    texto = $('#inputTextOpcionPregunta').val();
    } else{
    variables = '0';
            texto = $('#inputTextOpcionPregunta').val();
    }
    } else{
    texto = '0';
            variables = '0';
    }

    $.ajax({
    url:'Consultas/consultasistemas/' + estatus + '/' + periodo + '/' + select + '/' + texto + '/' + variables,
            success: function(data){
            if (data === 'error'){
            mostrarMensajeError("Alguno de los datos proporcionados es incorrecto, favor de verificarlo");
                    console.log('Nice try');
            } else{
            datatable = $('#tablaSistemas').DataTable();
                    datatable.clear();
                    datatable.draw();
                    var tamano = data.length;
                    for (var i = 0; i < tamano; i++){
            datatable.row.add([
                    data[i].sistema,
                    '<div class="progress progress-sm active">'
                    + '<div class="progress-bar progress-bar-green" '
                    + 'role="progressbar" aria-valuenow="' + Math.round(data[i].estado) + '" aria-valuemin="0" '
                    + 'aria-valuemax="100" style="width: ' + Math.round(data[i].estado) + '%">'
                    + '<br/>'
                    + '</div>'
                    + '</div>'
                    + '<br/>'
                    + Math.round(data[i].estado)
                    + ' % completado',
                    data[i].status,
                    '<div class="btn-group">'
                    + '<a href="{{ url('Ver / '.$sistema->sistemaid) }}" data-toogle="tooltip" data-placement="top" title="Ver">'
                    + '<button type="button" class="btn btn-primary actualizar">'
                    + '<i class="fa fa-eye"></i>'
                    + '</button>'
                    + '</a>'
                    + '</div>',
                    '<a href="#"><img width="35" src="{{ asset('images / xls.png' )}}" style="opacity: 0.4;"/></a>'
                    + '<a href="#"><img width="35" src="{{ asset('images / pdf.png' )}}" style="opacity: 0.4;"/></a>'
            ]).draw(false);
            }
            $('#cargando').attr('style', 'width: 110%; height: 100%; position: fixed; left: 0px; top:0px; background-color: rgb(255,255,255); opacity: 0.7; z-index: 8000; display: none;');
                    datatable.draw();
            }
            },
            error: function(xhr){
            $('#cargando').attr('style', 'width: 110%; height: 100%; position: fixed; left: 0px; top:0px; background-color: rgb(255,255,255); opacity: 0.7; z-index: 8000; display: none;');
                    mostrarMensajeError("Ocurrio un error en el servidor. Intente de nuevo más tarde, y si persiste, por favor contacte con el administrador del sistema.");
            }
    });
    });
            function mostrarMensajeError(mensaje){
            $('#panel-messages').attr('style', 'vertical-align: middle; font-size: 20px; text-align: center; font-weight: bolder; opacity: 500; display: block;');
                    $('#panel-messages').html('<div class="alert alert-danger" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-left-radius: 10px; border-bottom-right-radius:10px;">' + mensaje + '</div>');
                    setTimeout(function(){
                    $('#panel-messages').toggle();
                    }, 3000);
                    }
</script>
@stop
