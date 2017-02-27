@extends('layouts.baseIndex')
@section('titulo')
    Index
@stop

@section('tituloSistema')
    @include('includes.tituloSistemaIndex')
@stop
@section('opcionesDerecha')
    @include('includes.opcionesDerechaIndex')
@stop
@section('cuerpo')
    @include('includes.modalAcercaDe') 
    @include('includes.modalRecuperaPass') 
@stop
@section ('recursosExtra')
@stop

