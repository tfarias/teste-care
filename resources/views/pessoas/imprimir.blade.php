@extends('layouts.imprimir')

@section('conteudo')
    @include('pessoas.listagem', ['imprimir' => true])
@endsection