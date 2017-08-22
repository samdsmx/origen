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
@include('sistemas.modalResponsable')
@include('missistemas.modalBaja')
<section class="content-header">
    <h1 style="color:#605ca8;font-weight: bolder;">Consultas</h1>
    <ol class="breadcrumb">
        <li><a href="{!! url('inicio') !!}"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="#">Sistemas</a></li>
    </ol>
</section>
<section class="content">
    <div class="row" style="padding-bottom: 100px;">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <!--
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
                                    {!! $periodos !!}
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 5px;"><b>Pregunta: </b></td>
                                <td colspan="3" style="padding: 5px;">
                                    <select name="select_filter" id="selectOpcionPregunta">
                                        <option selected value="0">Sn contestar</option>
                                        @foreach($opcionesPregunta as $op)
                                        <option value="{!!$op->id_propiedad!!}-{!!$op->id_tipo!!}">{!!$op->descripcion!!}</option>	    
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
                    </fieldset>-->
                    <table id="tablaSistemas" class="table table-bordered table-striped table-dataTable text-center" width="100%">
                        <thead>
                        <th class="alert-info col-md-3">NOMBRE DEL SISTEMA</th>
                        <th class="alert-info col-md-2">PERIODO</th>
                        <th class="alert-info col-md-2">FASE</th>
                        <th class="alert-info col-md-2">OBSERVACI&Oacute;N</th>
                        <th class="alert-info col-md-2">ACCIONES</th>
                        <th class="alert-info col-md-1">FICHA</th>
                        </thead>
                        <tbody>
                            @foreach($sistemas as $sistema)
                            <tr>
                                <td class="nombreSistema" style="vertical-align: middle;" title="{!! $sistema->Sistema !!}">{!! ($sistema->nombreCompleto)?$sistema->nombreCompleto:'Sin nombre' !!}</td>
                                <td style="vertical-align: middle;">{!! $sistema->periodo !!}</td>
                                <td style="vertical-align: middle;"> {!! (($sistema->observacion != "Baja" && ($idPeriodoActual!=$sistema->id_periodo || strpos($sistema->fase,'Incom')))?'color:red;':'') !!} ">{!!($idPeriodoActual==$sistema->id_periodo || $sistema->observacion == "Baja")?$sistema->fase:"Pendiente" !!}</td>
                                <td style="vertical-align: middle;">{!! (($sistema->observacion == "Baja")?'<span title="'.$sistema->nota.'">'.$sistema->observacion.'</span>':$sistema->observacion) !!}</td>
                                <td style="vertical-align: middle;">
                                    <i class="btn fa fa-users botonUsuarios" value="{!!$sistema->id_sistema.'/'.$sistema->owner!!}" data-toggle="tooltip" data-html="html" data-placement="left" title="Responsable{!!(strpos($sistema->owner, ',') > 0 ? 's':'')!!}" 
                                       data-content="@foreach(explode(',',$sistema->owner) as $item2)     
                                       <?php $m = explode('|', $item2); ?>
                                       @if (isset($m[1])) 
                                       <p>{!!$m[1]!!}</p>
                                       @endif
                                       @endforeach">
                                    </i>                                        
                                    <div class="btn-group">
                                        <a href="{!! url('Ver/'.$sistema->id_sistema) !!}" role="button" data-toogle="tooltip" title="Ver" class="btn btn-success">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        @if (($dentroPeriodo ||  $modificarFuera) && $sistema->status ) 
                                        <a href="{!! url('ActualizaMiSistema/'.$sistema->id_sistema.'/'.(($sistema->Sistema)?$sistema->Sistema:'Sin nombre')) !!}" role="button" data-toogle="tooltip" data-placement="top" title="Actualizar" class="btn btn-primary actualizar">
                                            <i class="fa fa-level-up"></i>
                                        </a>
                                        @if($sistema->fase != 'Registro Incompleto')
                                        <button data-id="{!!$sistema->id_sistema!!}" data-target="#modalBaja" type="button" data-toggle="modal"  data-placement="top" title="Dar de baja" class="btn btn-danger baja">
                                            <i class="fa fa-times"></i>
                                        </button>
                                        @else
                                        <button type="button" class="btn btn-danger eliminar" data-toggle="modal"  data-target="#modalConfirma" data-id="{!!$sistema->id_sistema!!}" data-placement="top" title="Eliminar" >
                                            <i class="fa fa-trash-o"></i>	
                                        </button>
                                        @endif
                                        @endif
                                    </div>
                                </td>
                                <td style="vertical-align: middle;">
                                    <a href="{!! url('/Consultas/crearexcel/'.$sistema->id_sistema_periodo) !!}"><img width="35" src="{!! asset('images/xls.png' )!!}"/></a>
                                    <a href="{!! url('/Consultas/crearpdf/'.$sistema->id_sistema_periodo) !!}"><img width="35" src="{!! asset('images/pdf.png' )!!}"/></a> 
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@stop
@section('recursosExtra')
<script>
    $("i.fa").popover({'trigger': 'hover'});

    $('#tablaSistemas').DataTable({
        scrollX: false,
        responsive: true,
        searching: true,
        paging: true,
        lengthMenu: [[10, 20, 200], [10, 20, 200]],
        ordering: true,
        info: true,
        order: [[1, "desc"]],
        language: dataTablesSpanish,
        sDom: 'Rfrt <"col-md-12" <"col-md-4 pull-left"i> <"paginacion" <"opcionPaginacion"l> p > >',
        columnDefs: [{orderable: false, targets: [3, 4]}]
    });

    $("#tablaSistemas").on("click", ".baja", function() {
        $("#id_hidden_sis").attr("value", $(this).data('id'));
        $("#bajaSistema").submit(function(e) {
            e.preventDefault();
            borrarRegistro($(this).serialize(), 'MisSistemas/bajasistema');
        });
    });

    $("#tablaSistemas").on("click", ".eliminar", function() {
        $('#modalConfirmaTitle').text("Eliminar sistema");
        $("#modalConfirmaId").attr("value", $(this).data('id'));
        $("#formConfirma").submit(function(e) {
            e.preventDefault();
            borrarRegistro($(this).serialize(), 'MisSistemas/eliminar');
        });
    });    

    $('#selectOpcionPregunta').change(function() {
        var opcionPregunta = $('#selectOpcionPregunta').val();
        if (opcionPregunta == 0) {
            $('#textoOpcionPregunta').empty();
            $('#textoOpcionPregunta').html('<p><b>Respuesta</b></p>');
        }
        else {
            var opcionDividida = opcionPregunta.split('-');
            if (opcionDividida[1] == 1 || opcionDividida[1] == 5) {
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
                $('#filtroSelectGraficas').change(function() {
                    deshabilitarInput(this, '#inputTextOpcionPregunta');
                });
            }
            else if (opcionDividida[1] == 2) {
                $('#textoOpcionPregunta').empty();
                buscarInformacion(opcionDividida[1], opcionDividida[0]);
            }
            else if (opcionDividida[1] == 3) {
                $('#textoOpcionPregunta').empty();
                buscarInformacion(opcionDividida[1], opcionDividida[0]);
            }
            else if (opcionDividida[1] == 4) {
                $('#textoOpcionPregunta').empty();
                buscarInformacion(opcionDividida[1], opcionDividida[0]);
            }
            else if (opcionDividida[1] == 6) {
                $('#textoOpcionPregunta').empty();
                var fullDate = new Date();
                var twoDigitMonth = ((fullDate.getMonth().length + 1) === 1) ? (fullDate.getMonth() + 1) : '0' + (fullDate.getMonth() + 1);
                var currentDate = fullDate.getFullYear() + "-" + twoDigitMonth + "-" + fullDate.getDate();
                $('#textoOpcionPregunta').html('Respuesta: <input name="respuesta_filter" type="date" id="inputTextOpcionPregunta" step="1" value="' + currentDate + '">');
            }
            else {
                $('#textoOpcionPregunta').empty();
                mostrarMensajeError("Error al acceder a la información  solicitada, intenta de nuevo más tarde. Si el error persiste, contacta al administrador del sistema");
            }
        }
    });

    function deshabilitarInput(select, input) {
        var opcion = $(select).val();
        if (opcion == "is null" || opcion == "is not null") {
            $(input).attr('disabled', true);
        }
        else {
            $(input).removeAttr('disabled');
        }
    }

    function buscarInformacion(tipo, id) {
        $.ajax({
            url: 'Consultas/obtenerlistado/' + tipo + '/' + id,
            success: function(data) {
                if (data == 'error') {
                    mostrarMensajeError('Ha ocurrido un error debido a que la información introducida no es correcta. Vuelva a intentarlo más tarde.');
                    console.log('data = error');
                }
                else {
                    var cantidad = data.length;
                    $('#textoOpcionPregunta').html('Respuesta: <select name="respuesta_filter" id="inputTextOpcionPregunta"><select>');
                    for (var i = 0; i < cantidad; i++) {
                        $('#inputTextOpcionPregunta').append('<option value="' + data[i].id + '">' + data[i].valor + '</option>');
                    }
                }
            },
            error: function(xhr) {
                mostrarMensajeError("Ocurrio un error en el servidor. Intente de nuevo más tarde, y si persiste, por favor contacte con el administrador del sistema.");
            }
        });
    }

    $('#buscarSistemas').on("click", function() {
        //$('#cargando').attr('style', 'width: 110%; height: 100%; position: fixed; left: 0px; top:0px; background-color: rgb(255,255,255); opacity: 0.7; z-index: 8000; display: block;');
        var select = $('#selectOpcionPregunta').val();
        var estatus = $('#estatus_filter').val();
        var periodo = $('#periodo_filter').val();
        var variables;
        var texto;
        if (periodo > 0) {
            variables = $('#filtroSelectGraficas').val();
            if (variables == 'is null' || variables == 'is not null') {
                texto = '';
            }
            else if (variables == '=' || variables == '<>' || variables == 'like') {
                texto = $('#inputTextOpcionPregunta').val();
            }
            else {
                variables = '0';
                texto = $('#inputTextOpcionPregunta').val();
            }
        }
        else {
            texto = '0';
            variables = '0';
        }
        $.ajax({
            url: 'Consultas/consultasistemas/' + estatus + '/' + periodo + '/' + select + '/' + texto + '/' + variables,
            success: function(data) {
                if (data === 'error') {
                    mostrarMensajeError("Alguno de los datos proporcionados es incorrecto, favor de verificarlo");
                    console.log('data = error');
                }
                /*    else{
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
                 + '<a href="Ver/'+ data[i].sistemaid +'" role="button" data-toogle="tooltip" title="Ver" class="btn btn-success">'
                 + '<i class="fa fa-eye"></i>'
                 + '</a>'
                 + '</div>',
                 '<a href="Consultas/crearexcel/' + data[i].id_sistema_periodo + '"><img width="35" src="{!! asset('images/xls.png') !!}" /></a>'
                 + '<a href="Consultas/crearpdf/' + data[i].id_sistema_periodo + '"><img width="35" src="{!! asset('images/pdf.png') !!}" /></a>'
                 ]).draw(false);
                 }
                 $('#cargando').attr('style', 'width: 110%; height: 100%; position: fixed; left: 0px; top:0px; background-color: rgb(255,255,255); opacity: 0.7; z-index: 8000; display: none;');
                 datatable.draw();
                 }*/
            },
            error: function(xhr) {
                $('#cargando').attr('style', 'width: 110%; height: 100%; position: fixed; left: 0px; top:0px; background-color: rgb(255,255,255); opacity: 0.7; z-index: 8000; display: none;');
                mostrarMensajeError("Ocurrio un error en el servidor. Intente de nuevo más tarde, y si persiste, por favor contacte con el administrador del sistema.");
            }
        });
    });
    function mostrarMensajeError(mensaje) {
        $('#panel-messages').attr('style', 'vertical-align: middle; font-size: 20px; text-align: center; font-weight: bolder; opacity: 500; display: block;');
        $('#panel-messages').html('<div class="alert alert-danger" style="border-top-left-radius: 0px; border-top-right-radius: 0px; border-bottom-left-radius: 10px; border-bottom-right-radius:10px;">' + mensaje + '</div>');
        setTimeout(function() {
            $('#panel-messages').toggle();
        }, 3000);
    }
    $('#tablaSistemas').on('click', '.botonUsuarios', function() {
        var contenido = $(this).attr('data-content').trim().split('<p>');
		var sistema = $(this).parent().parent().children('.nombreSistema').text();
		var isistema = $(this).attr('value').split('/');
		$('#buscarResponsable').addClass('hidden');
		$('#modalResponsableAgregar').removeClass('hidden');
		$('#modalResponsableSistema').text(sistema);
		$('#modalResponsableCandidato').val('0');
		$('#modalResponsableISistema').val(isistema[0]);
		$('#modalResponsablePersonas').html('');
		var j = 0;
		for(var i=1; i<contenido.length;i++){
			var multiValorificado = isistema[1].split(',');
			var valorificado = multiValorificado[j].split('|');
			var texto = contenido[i].split('</p>');
			$('#modalResponsablePersonas').append('<tr><td class="responsable" value="'+valorificado[0]+'" >'+texto[0]+'</td><td style="padding-left: 100%;"><span class="eliminarPersona  btn btn-link" style="margin-left: 20%;"><i class="fa fa-times" aria-hidden="true"></i></span></td></tr>');
			j++;
		}
		$("#modalResponsable").modal(); 
		$('.eliminarPersona').click(function(){
			eliminarPersona(this);
		});	
	});
	$('#modalResponsableAgregar').click(function(){
		$('#buscarResponsable').removeClass('hidden');
		$(this).addClass('hidden');
	});
	$('#modalResponsableEnviar').click(function(){
		var usuario = $('#modalResponsableCandidato').val();
		var sistema = $('#modalResponsableISistema').val();
			$.ajax({url: "Consultas/agregar-responsable/"+usuario+'/'+sistema, 
				success: function(data){
					if(data[0] == 'error'){
						$('#modalResponsableMensaje').removeClass('hidden');	
						$('#modalResponsableMensaje').addClass('alert alert-danger');	
						$('#modalResponsableMensaje').text(data[1]);
						setTimeout(function(){
						$('#modalResponsableMensaje').addClass('hidden');	
						$('#modalResponsableMensaje').removeClass('alert alert-danger');	
						},4000);
					}else if(data[0]=='exito'){
						$('#modalResponsableMensaje').removeClass('hidden');	
						$('#modalResponsableMensaje').addClass('alert alert-success');	
						$('#modalResponsableMensaje').text(data[1]);	
						$('#modalResponsablePersonas').append('<tr><td class="responsable" value="'+data[3]+'" >'+data[2]+'</td><td style="padding-left: 100%;"><span class="eliminarPersona btn btn-link" style="margin-left: 20%;"><i class="fa fa-times" aria-hidden="true"></i></span></td></tr>');
						$('.eliminarPersona').click(function(){
							eliminarPersona(this);
						});	
						setTimeout(function(){
						$('#modalResponsableMensaje').addClass('hidden');	
						$('#modalResponsableMensaje').removeClass('alert alert-success');	
						},4000);
					}else{

					}
				},
				error: function(xhr){
            				alert("An error occured: " + xhr.status + " " + xhr.statusText);
        			}
			});

		$('#buscarResponsable').addClass('hidden');
		$('#modalResponsableAgregar').removeClass('hidden');
	});

	function eliminarPersona(objeto){
		var usuario = $(objeto).parent().parent().children('.responsable').attr('value');
		var sistema = $('#modalResponsableISistema').val();
			$.ajax({url: "Consultas/eliminar-responsable/"+usuario+'/'+sistema, 
				success: function(data){
					if(data[0] == 'error'){
						$('#modalResponsableMensaje').removeClass('hidden');	
						$('#modalResponsableMensaje').addClass('alert alert-danger');	
						$('#modalResponsableMensaje').text(data[1]);
						setTimeout(function(){
						$('#modalResponsableMensaje').addClass('hidden');	
						$('#modalResponsableMensaje').removeClass('alert alert-danger');	
						},4000);
					}else if(data[0]=='exito'){
						$('#modalResponsableMensaje').removeClass('hidden');	
						$('#modalResponsableMensaje').addClass('alert alert-success');	
						$('#modalResponsableMensaje').text(data[1]);	
						$(objeto).parent().parent().empty();
						setTimeout(function(){
						$('#modalResponsableMensaje').addClass('hidden');	
						$('#modalResponsableMensaje').removeClass('alert alert-success');	
						},4000);
					}else{

					}
				},
				error: function(xhr){
            				alert("An error occured: " + xhr.status + " " + xhr.statusText);
        			}
			});

		$('#buscarResponsable').addClass('hidden');
		$('#modalResponsableAgregar').removeClass('hidden');
	}
		
</script>
@stop
