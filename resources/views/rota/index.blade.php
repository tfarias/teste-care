@extends('layouts.template')
@section('conteudo')
<div class="this-place">
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>Rotas</li>
             <i class="fa fa-chevron-right"></i>
            <li>
                <span>Lista</span>
            </li>
        </ul>
    </div>
    <div class="clearfix"></div>
    <h1 class="page-title">Rotas</h1>
    <div class="clearfix"></div>
    <div class="row area">
            <div class="col-md-12">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                         <div class="caption">
                             <i class="icon-social-dribbble font-green"></i>
                            <span class="caption-subject font-green bold uppercase">Filtros</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                            <form action="{{ route('rota.index') }}" method="get" class="form-filter">
                                     <div class="form-group col-lg-3 col-sm-6">
                            <label for="id_tipo_rota">TipoRota</label>
                             <select name="id_tipo_rota" id="id_tipo_rota" class="form-control"  data="select" action="{{route('tipo_rota.fill')}}" ></select>
                        </div> <div class="form-group col-lg-3 col-sm-6">
                            <label for="descricao">Descricao</label>
                             <input type="text" name="descricao" id="descricao" class="form-control" value="{{ isset($rota) ? $rota->descricao : '' }}" placeholder="Descricao" >
                        </div> <div class="form-group col-lg-3 col-sm-6">
                            <label for="slug">Slug</label>
                             <input type="text" name="slug" id="slug" class="form-control" value="{{ isset($rota) ? $rota->slug : '' }}" placeholder="Slug" >
                        </div>

                                    <div class="col-md-4 pull-right">
                                        <div class="text-right">
                                            @include('partials.botao_limpar', ['url' => route('rota.index')])
                                            @include('partials.botao_imprimir_relatorio')
                                            @include('partials.botao_novo', ['route' => 'rota.adicionar'])
                                        </div>
                                   </div>
                                    <div class="clearfix"></div>

                            </form>
                    </div>
                </div>
                <div class="clearfix"></div>

               <div class="portlet light bordered">
                 <div class="portlet-title">
                       <div class="caption">
                           <span class="caption-subject font-green bold uppercase">Rotas</span>
                       </div>
               </div>
                    <div class="portlet-body ">
                        <div class="clearfix">
                               {!! Table::withContents($dados->items())->striped()
                                          ->callback('Ações',function ($field,$dado){
                                               return Button::success(Icon::create('pencil'))->asLinkTo(route('rota.edit',['dado'=>$dado->id]))->addAttributes(['class'=>'btn-xs']). ' '.
                                                      Button::danger(Icon::create('remove'))->asLinkTo(route('rota.delete',['dado'=>$dado->id]))->addAttributes(['class'=>'btn-xs confirma-acao','data-texto'=>'Deseja mesmo excluir este registro?']);
                                          })
                              !!}
                            </div>
                             {!! $dados->appends(request()->all())->links() !!}
                        </div>
                    </div>
                </div>
            </div>
    </div>
@endsection