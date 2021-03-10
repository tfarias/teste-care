@extends('layouts.imprimir')

@section('conteudo')
    @include('nota_pessoas.listagem', ['imprimir' => true])
@endsection