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
                    <li id="{{ $grupo["grupo"]."-pest" }}" class="{{ $in == 0 ? "active" : "" }}"><a href="#{{$grupo["grupo"]."-tab"}}" data-toggle="tab"  aria-expanded="true" >{{ $grupo["grupo"] }}</a></li>
                @endforeach
            </ul>
            <div class="tab-content">
                @foreach($pantallas as $index => $seccion)
                    <div class="tab-pane {{ $index == $grupos[0]["grupo"] ? 'active' : '' }}" id="{{$index."-tab"}}">
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
                    </div>
                @endforeach
            </div>
            <!-- /.tab-content -->
        </div>    
        {{ Form::close() }}
    </div>
@stop
