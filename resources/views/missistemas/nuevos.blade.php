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
    <h1 style="color:#605ca8;font-weight: bolder;">{!!$nombre!!}</h1>
    <ol class="breadcrumb">
        <li><a href="{!! url('inicio') !!}"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="{!! url('MisSistemas') !!}">Mis Sistemas</a></li>
        <li><a href="#">Propiedades</a></li>
    </ol>
</section>

<section class="content">
    {!! Form::open(array('id'=>'guardaAvance')) !!}
    <input type="hidden" value="{!!$sp->id_sistema!!}" name="_id" id="_id" />       
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            @foreach($grupos as $in => $grupo)
            <li id="{!! str_replace(' ','_',$grupo["grupo"])."-pest" !!}" class="{!! str_replace(' ','_',$grupo["grupo"]) == $active_group ? "active" : "" !!}" value="{!! $grupo["grupo"] !!}">
                <a href="#{!!str_replace(' ','_',$grupo["grupo"])."-tab"!!}" data-toggle="tab" aria-expanded="true">
                    {!! $grupo["grupo"] !!} 
                    <i class="fa fa-check" style="color: green" aria-hidden="true"></i>
                </a>               
            </li>
            @endforeach
        </ul>
        <div class="tab-content">
            @foreach($pantallas as $index => $seccion)
            <div class="tab-pane {!! str_replace(' ','_',$index) == $active_group ? 'active' : '' !!}" id="{!!str_replace(' ','_',$index).'-tab'!!}">
                <div class="box-body">
                    <div class="form-group">
                        @foreach($seccion as $i => $prop)
                        <div style="padding:10px; margin-bottom: 0px;" id="divQ{!! $prop['id'] !!}" class="form-group col-sm-12">
                            <label id="labelP{!!$prop['id']!!}" class="col-sm-6">{!!') '. $prop["pregunta"]!!} 
                                @if( $prop["obligatorio"] == 1 )
                                <span id="oblQ{!!$prop['id']!!}" style="color: red;" aria-hidden="true">*</span>
                                @endif
                            </label>
                            <div class="col-sm-6">{!! $prop["campo"] !!}</div>
                            @if( $prop["expresion"] <> null )
                            <small><input type="hidden" value="{!! htmlspecialchars($prop['expresion']) !!}" name="hidQ{!!$prop['id']!!}" id="hidQ{!!$prop['id']!!}"  /></small>   
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer contenedorEnviar" style="background: #ffffff;">
                    <button type="button" class="btn btn-danger pideConfirmacion" data-toggle="modal" data-target="#modalConfirma">Cancelar</button>
                    <button class="btn btn-info guardarSeguir"  name="guardarSeguir">Guardar y Continuar</button>
                    <button class="btn btn-info guardarTerminar hidden"  name="guardarTerminar">Guardar y Terminar</button>
                </div>
            </div>
            @endforeach
        </div>
    </div>    
    {!! Form::close() !!}
</section>
@stop
@section('recursosExtra')
{!! Html::script('js/nuevoSistema.js') !!}
<script>

    $(".tab-pane").on("click", ".pideConfirmacion", function() {
        $('#modalConfirmaTitle').text("Se perderán todos los datos no guardados");
        $("#formConfirma").submit(function(e) {
            e.preventDefault();
            history.go( - 1);
        });
    });
    
    function guardar(){
        var activo = $('.nav').find('li.active').attr("value");
        var res = $("#" + activo.replace(/\s/g, "_") + "-tab > div.box-body > div.form-group > div:visible > div > .elemento").map(function() {
            if ((this.type == 'checkbox' || this.type == 'radio') && (!this.selected && !this.checked)){
                return;
            }
            return "'" + this.id + ":" + this.value + "'";
        }).get().toString();
        var obl = $("#" + activo.replace(/\s/g, "_") + "-tab > div.box-body > div.form-group > div:visible > label >").map(function() {
            return this.id;
        }).get().toString();
        var data = {obl:obl, res:res, Tipo:activo, Id:$('#_id').val()};
        //console.log(data);
        $.ajax({
            type: "POST",
            url: "{!! url('MisSistemas') !!}/registra",
            data: data,
            success: function(response) {
                $('div').removeClass('has-error');
                $('input').removeAttr("title");
                if (response.errors) {
                    $.each(response.errors, function(index, error) {
                        //alert(index + " " + error );
                        var d = index.replace("input", "div");
                        $("#" + d).addClass("has-error");
                        $("#" + index).attr("title", error);
                    });
                } else {
                    var respuestaTem = response.siguiente.split('/');
                    var sitio1 = respuestaTem[1].split(' ').join('_');
                    var sitio = respuestaTem[0].split(' ').join('_');
                    $('#'+sitio+'-tab').removeClass('active');
                    $('#'+sitio1+'-tab').addClass('active');
                    $('#'+sitio+'-pest').removeClass('active');
                    $('#'+sitio1+'-pest').addClass('active');
                    $('html, body').animate({ scrollTop: 0 }, 'fast');
                    mostrarMensaje("Sistema actualizado", "alert-success");
                    //console.log(sitio+' '+sitio1+'-pest');
                    $("#_id").attr("value",response.id);   
                }
                return true;
            },
            error: function(xhr, status, error) {
                alert("error en el servidor");
                return false;
            }
        });   
    return true;
    }
    
    function terminar(){
        var data = {Id:$('#_id').val()};
        //console.log(data);
        $.ajax({
            type: "POST",
            url: "{!! url('MisSistemas') !!}/termina",
            data: data,
            success: function(response) {
                if (response.mensaje) {
                    mostrarMensaje("<p>" + response.mensaje + "</p>");
                } else {
                    $('html, body').animate({ scrollTop: 0 }, 'fast');
                    mostrarMensaje("Registrado completo", "alert-success");
                    window.location.href = "{!! url('MisSistemas') !!}";
                }
            },
            error: function(xhr, status, error) {
                alert("error en el servidor");
            }
        });      
    }
        
    $('button[name="guardarSeguir"]').click(function(e) {
        e.preventDefault();
        guardar();
    });
    
    $('.guardarTerminar').last().click(function(e){
        e.preventDefault();
        if (guardar()){
            terminar();
            }
        });

    window.onload= function activarBtn(){
        $('.guardarTerminar').last().removeClass('hidden');
        $('.guardarSeguir').last().addClass('hidden');
        }

</script>

@stop
