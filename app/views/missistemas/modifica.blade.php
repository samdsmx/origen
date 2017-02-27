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
    <div id="panel-table" style="padding-top: 25px">
        {{ Form::open() }}
        <input type="hidden" value="{{$id_sistema}}" name="_id" id="_id" />       
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                @foreach($grupos as $in => $grupo)
                    <li id="{{ $grupo["grupo"]."-pest" }}" class="{{ $grupo["grupo"] == $active_group ? "active" : "" }}"><a href="#{{$grupo["grupo"]."-tab"}}" data-toggle="{{ $grupo["grupo"] == $active_group ? "tab" : "" }}"  aria-expanded="true" >{{ $grupo["grupo"] }}</a></li>
                @endforeach
            </ul>
            <div class="tab-content">
                @foreach($pantallas as $index => $seccion)
                    <div class="tab-pane {{ $index == $active_group ? 'active' : '' }}" id="{{$index."-tab"}}">
                        <div class="box-body">
                            <div class="form-group">
                                <table>
                                @foreach($seccion as $prop)
                                <tr>
                                    <td class="col-sm-6" style="padding-bottom: 1em;"><label>{{ $prop["num"].') '.$prop["pregunta"] }}</label></td>
                                    <td class="col-sm-6" style="padding-bottom: 1em;">{{ $prop["campo"] }}</td>
                                </tr>
                                @endforeach
                                </table>
                            </div>
                        </div>
                        <button class="btn btn-info" name="guardarSeguir" >Guardar y Continuar</button>
                    </div>
                @endforeach
            </div>
            <!-- /.tab-content -->
        </div>    
        {{ Form::close() }}
    </div>
@stop
@section('recursosExtra')
<script>
    $('button[name="guardarSeguir"]').click(function(e){
        e.preventDefault();
        var activo = $('.nav').find('li.active').text();
        var _id = $('#_id').val();
        var data = "Tipo="+activo+"&";
        data+="Id="+_id+"&"
        data += $('[id^='+activo+']').serialize();
        $.ajax({
            type: "POST",
            url: "../MisSistemas/registraseccion",
            data: data,
            success: function(response){
                $("[id^='___']").remove();
                if(response.errors){
                    $.each(response.errors, function(index, error){
                        var campo = $("#"+index);
                        campo.addClass("has-error"); 
                        var datos = '<div class="input-group-addon alert-danger" id="___'+index+'">'+error+'</div>'
                        campo.parent().append(datos);
                    });
                    
                    alert(campo);
                } else if(response.mensaje){
                    mostrarMensaje("<p>"+response.mensaje+"</p>");
                } else {
                    if (response.siguiente != null){
                        var pest = $('.nav-tabs > .active');
                        pest.find('a').removeAttr("data-toggle");
                        var sig = $('#'+response.siguiente+"-pest");
                        sig.find('a').attr('data-toggle', "tab");
                        sig.find('a').trigger('click');
                    } else  if(response.siguiente == null){
                        window.location.href = "Sistemas";
                    }
                }
            },
            error: function(xhr, status, error){
                alert("error en el servidor");
            } 
        });
    });

</script>
@stop
