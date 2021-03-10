@extends('layouts.template')

@section('conteudo')
<div class="this-place">
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li><a href="{{route('nota_pessoas.index')}}">Nota Pessoas</a></li>
            <i class="fa fa-chevron-right"></i>
            <li>
                <span>Cadastrar</span>
            </li>
        </ul>
    </div>
    <div class="clearfix"></div>
    <h1 class="page-title">Nota Pessoas</h1>
    <div class="clearfix"></div>
    <div class="row area">
                <div class="col-md-12">
                      <div class="nota_pessoas form">
                            @include('partials.preenchimento_obrigatorio')
                            @include('nota_pessoas.form')
                      </div>
            </div>
    </div>
</div>
@endsection