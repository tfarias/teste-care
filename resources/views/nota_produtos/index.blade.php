@extends('layouts.template')
@section('conteudo')
<div class="this-place">
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>Nota Produtos</li>
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
                            <form action="{{ route('nota_produtos.index') }}" method="get" class="form-filter validate">
                                     <div class="form-group col-lg-3 col-sm-6">
                            <label for="id_nota">XmlUpload</label>
                             <select name="id_nota" id="id_nota" class="form-control"  data="select" action="{{route('xml_upload.fill')}}"  {{!empty(request('id_nota')) ? 'sel=update update='.route('xml_upload.getedit',request('id_nota')) : ''}} ></select>
                        </div> <div class="form-group col-lg-3 col-sm-6">
                            <label for="id_produto">Produtos</label>
                             <select name="id_produto" id="id_produto" class="form-control"  data="select" action="{{route('produtos.fill')}}"  {{!empty(request('id_produto')) ? 'sel=update update='.route('produtos.getedit',request('id_produto')) : ''}} ></select>
                        </div> <div class="form-group col-lg-3 col-sm-6">
                            <label for="valor">Valor</label>
                             <input type="text" name="valor" id="valor" class="form-control" value="{{ request('valor') }}" placeholder="Valor" >
                        </div> <div class="form-group col-lg-3 col-sm-6">
                            <label for="quantidade">Quantidade</label>
                             <input type="text" name="quantidade" id="quantidade" class="form-control" value="{{ request('quantidade') }}" placeholder="Quantidade" >
                        </div> <div class="form-group col-lg-3 col-sm-6">
                            <label for="valor_icms">ValorIcms</label>
                             <input type="text" name="valor_icms" id="valor_icms" class="form-control" value="{{ request('valor_icms') }}" placeholder="ValorIcms" >
                        </div> <div class="form-group col-lg-3 col-sm-6">
                            <label for="valor_pis">ValorPis</label>
                             <input type="text" name="valor_pis" id="valor_pis" class="form-control" value="{{ request('valor_pis') }}" placeholder="ValorPis" >
                        </div> <div class="form-group col-lg-3 col-sm-6">
                            <label for="valor_cofins">ValorCofins</label>
                             <input type="text" name="valor_cofins" id="valor_cofins" class="form-control" value="{{ request('valor_cofins') }}" placeholder="ValorCofins" >
                        </div> <div class="form-group col-lg-3 col-sm-6">
                            <label for="valor_imposto">ValorImposto</label>
                             <input type="text" name="valor_imposto" id="valor_imposto" class="form-control" value="{{ request('valor_imposto') }}" placeholder="ValorImposto" >
                        </div>

                                    <div class="col-md-4 pull-right">
                                        <div class="text-right">
                                            @include('partials.botao_limpar', ['url' => route('nota_produtos.index')])
                                            @include('partials.botao_imprimir_relatorio')
                                            @include('partials.botao_novo', ['route' => 'nota_produtos.create'])
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
                           <span class="caption-subject font-green bold uppercase">Nota Produtos</span>
                       </div>
               </div>
                    <div class="portlet-body ">
                        <div class="clearfix">
                            <div class="table-responsive">
                               {!! Table::withContents($dados)->hover()
                                          ->callback('',function ($field,$dado){
                                            $btn ="";
                                                   if(temAlgumaPermissao(['nota_produtos.destroy'])){
                                                       $btn.= Button::danger(Icon::create('remove'))->asLinkTo(route('nota_produtos.destroy',['dado'=>$dado->id]))->addAttributes(['class'=>'btn-xs confirma-acao pull-right','data-texto'=>'Deseja mesmo excluir este registro?','id'=>'btn-excluir','toggle'=>'tooltip','title'=>'Deletar']);
                                                   }
                                                   if(temAlgumaPermissao(['nota_produtos.edit'])){
                                                     $btn.= Button::success(Icon::create('pencil'))->asLinkTo(route('nota_produtos.edit',['dado'=>$dado->id]))->addAttributes(['class'=>'btn-xs pull-right','toggle'=>'tooltip','title'=>'Editar']);
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