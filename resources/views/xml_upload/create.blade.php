@extends('layouts.template')

@section('conteudo')
<div class="this-place">
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li><a href="{{route('xml_upload.index')}}">Upload XML</a></li>
            <i class="fa fa-chevron-right"></i>
            <li>
                <span>Cadastrar</span>
            </li>
        </ul>
    </div>
    <div class="clearfix"></div>
    <h1 class="page-title">Upload XML</h1>
    <div class="clearfix"></div>
    <div class="row area">
                <div class="col-md-12">
                      <div class="xml_upload form">
                            @include('partials.preenchimento_obrigatorio')
                            @include('xml_upload.form')
                      </div>
            </div>
    </div>
</div>
@endsection