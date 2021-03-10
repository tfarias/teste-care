@extends('layouts.imprimir')

@section('conteudo')
    @include('rota.listagem', ['imprimir' => true])
@endsection