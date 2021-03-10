@extends('layouts.template')

@section('conteudo')
<div class="this-place">
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li><a href="{{route('rota.index')}}">Rotas</a></li>
            <i class="fa fa-chevron-right"></i>
            <li>
                <span>Cadastrar</span>
            </li>
        </ul>
    </div>
    <div class="clearfix"></div>
    <h1 class="page-title">Rotas</h1>
    <div class="clearfix"></div>
    <div class="row area">
                <div class="col-md-12">
                      <div class="rota form">
                            @include('partials.preenchimento_obrigatorio')
                            @include('rota.form')
                      </div>
            </div>
    </div>
</div>
@endsection