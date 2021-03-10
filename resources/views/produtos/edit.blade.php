@extends('layouts.template')

@section('conteudo')
<div class="this-place">
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li><a href="{{route('produtos.index')}}">Produtos</a></li>
            <i class="fa fa-chevron-right"></i>
            <li>
                <span>Editar</span>
            </li>
        </ul>
    </div>
    <div class="clearfix"></div>
    <h1 class="page-title">Produtos</h1>
    <div class="clearfix"></div>
    <div class="row area">
                <div class="col-md-12">
                            <div class="produtos form">
                                    @include('partials.preenchimento_obrigatorio')
                                     @include('produtos.form')
                            </div>
            </div>
    </div>
</div>
@endsection