@extends('layouts.imprimir')

@section('conteudo')
    @include('produtos.listagem', ['imprimir' => true])
@endsection