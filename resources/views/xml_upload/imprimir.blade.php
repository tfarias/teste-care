@extends('layouts.imprimir')

@section('conteudo')
    @include('xml_upload.listagem', ['imprimir' => true])
@endsection