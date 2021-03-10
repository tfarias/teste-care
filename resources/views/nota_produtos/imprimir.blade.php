@extends('layouts.imprimir')

@section('conteudo')
    @include('nota_produtos.listagem', ['imprimir' => true])
@endsection