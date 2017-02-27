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
            <li id="{{ str_replace(' ','_',$grupo["grupo"])."-pest" }}" class="{{ str_replace(' ','_',$grupo["grupo"]) == $active_group ? "active" : "" }}"><a href="#{{str_replace(' ','_',$grupo["grupo"])."-tab"}}" data-toggle="tab"  aria-expanded="true" >{{ $grupo["grupo"] }}</a></li>
            @endforeach
        </ul>
        <div class="tab-content">
            @foreach($pantallas as $index => $seccion)
            <div class="tab-pane {{ str_replace(' ','_',$index) == $active_group ? 'active' : '' }}" id="{{str_replace(' ','_',$index).'-tab'}}">
                <div class="box-body">
                    <div class="form-group">
                        <table>
                            @foreach($seccion as $i => $prop)
                            <div style="padding:10px;" id="divQ{{ $prop['id'] }}" class="col-sm-12">
                                <label id="labelP{{$prop['id']}}" class="col-sm-6">{{') '. $prop["pregunta"] }} 
                                    @if( $prop["obligatorio"] == 1 )
                                    <span style="color: red;" aria-hidden="true">*</span>
                                    @endif
                                </label>
                                <div class="col-sm-6">{{ $prop["campo"] }}</div>
                                @if( $prop["expresion"] <> null )
                                <small><input type="hidden" value="{{ htmlspecialchars($prop['expresion']) }}" name="hidQ{{$prop['id']}}" id="hidQ{{$prop['id']}}"  /></small>   
                                @endif
                            </div>
                            @endforeach
                        </table>
                    </div>
                </div>
                <div class="modal-footer" style="background: #ffffff;">
                    <button type="button" class="btn btn-danger pideConfirmacion" data-toggle="modal" data-target="#modalConfirma">Cancelar</button>
                    <button class="btn btn-info" name="guardarSeguir">Guardar y Continuar</button>
                </div>
            </div>
            @endforeach
        </div>
    </div>    
    {{ Form::close() }}
</div>
@stop
@section('recursosExtra')
{{ HTML::script('js/nuevoSistema.js') }}
<script>

    $(".tab-pane").on("click", ".pideConfirmacion", function() {
        $('#modalConfirmaTitle').text("Se perderan todos los datos no guardados");
        $("#formConfirma").submit(function(e) {
            e.preventDefault();
            window.location.href = "MisSistemas";
        });
    });

</script>

@stop
