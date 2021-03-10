@extends('layouts.template')

@section('conteudo')
<div class="this-place">
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li><a href="{{route('pessoas.index')}}">Pessoas</a></li>
            <i class="fa fa-chevron-right"></i>
            <li>
                <span>Editar</span>
            </li>
        </ul>
    </div>
    <div class="clearfix"></div>
    <h1 class="page-title">Pessoas</h1>
    <div class="clearfix"></div>
    <div class="row area">
                <div class="col-md-12">
                            <div class="pessoas form">
                                    @include('partials.preenchimento_obrigatorio')
                                     @include('pessoas.form')
                            </div>
            </div>
    </div>
</div>
@endsection