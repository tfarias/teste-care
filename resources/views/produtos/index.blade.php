@extends('layouts.template')
@section('conteudo')
<div class="this-place">
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>Produtos</li>
             <i class="fa fa-chevron-right"></i>
            <li>
                <span>Lista</span>
            </li>
        </ul>
    </div>
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
                            <form action="{{ route('produtos.index') }}" method="get" class="form-filter validate">
                                     <div class="form-group col-lg-3 col-sm-6">
                            <label for="codigo_produto">CodigoProduto</label>
                             <input type="text" name="codigo_produto" id="codigo_produto" class="form-control" value="{{ request('codigo_produto') }}" placeholder="CodigoProduto"  maxlength="255" >
                        </div> <div class="form-group col-lg-3 col-sm-6">
                            <label for="descricao">Descricao</label>
                             <input type="text" name="descricao" id="descricao" class="form-control" value="{{ request('descricao') }}" placeholder="Descricao"  maxlength="255" >
                        </div>

                                    <div class="col-md-4 pull-right">
                                        <div class="text-right">
                                            @include('partials.botao_limpar', ['url' => route('produtos.index')])
                                            @include('partials.botao_imprimir_relatorio')
                                            @include('partials.botao_novo', ['route' => 'produtos.create'])
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
                           <span class="caption-subject font-green bold uppercase">Produtos</span>
                       </div>
               </div>
                    <div class="portlet-body ">
                        <div class="clearfix">
                            <div class="table-responsive">
                               {!! Table::withContents($dados)->hover()
                                          ->callback('',function ($field,$dado){
                                            $btn ="";
                                                   if(temAlgumaPermissao(['produtos.destroy'])){
                                                       $btn.= Button::danger(Icon::create('remove'))->asLinkTo(route('produtos.destroy',['dado'=>$dado->id]))->addAttributes(['class'=>'btn-xs confirma-acao pull-right','data-texto'=>'Deseja mesmo excluir este registro?','id'=>'btn-excluir','toggle'=>'tooltip','title'=>'Deletar']);
                                                   }
                                                   if(temAlgumaPermissao(['produtos.edit'])){
                                                     $btn.= Button::success(Icon::create('pencil'))->asLinkTo(route('produtos.edit',['dado'=>$dado->id]))->addAttributes(['class'=>'btn-xs pull-right','toggle'=>'tooltip','title'=>'Editar']);
                                                   }
                                             return $btn;
                                          })
                               !!}
                            </div>
                        </div>
                             {!! $dados->appends(request()->all())->links() !!}
                        </div>
                    </div>
                </div>
            </div>
    </div>
@endsection