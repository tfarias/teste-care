@extends('layouts.template')
@section('conteudo')
<div class="this-place">
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>Nota Pessoas</li>
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
                            <form action="{{ route('nota_pessoas.index') }}" method="get" class="form-filter validate">
                                     <div class="form-group col-lg-3 col-sm-6">
                            <label for="id_nota">XmlUpload</label>
                             <select name="id_nota" id="id_nota" class="form-control"  data="select" action="{{route('xml_upload.fill')}}"  {{!empty(request('id_nota')) ? 'sel=update update='.route('xml_upload.getedit',request('id_nota')) : ''}} ></select>
                        </div> <div class="form-group col-lg-3 col-sm-6">
                            <label for="id_pessoa">Pessoas</label>
                             <select name="id_pessoa" id="id_pessoa" class="form-control"  data="select" action="{{route('pessoas.fill')}}"  {{!empty(request('id_pessoa')) ? 'sel=update update='.route('pessoas.getedit',request('id_pessoa')) : ''}} ></select>
                        </div> <div class="form-group col-lg-3 col-sm-6">
                            <label for="tipo">Tipo</label>
                             <input type="text" name="tipo" id="tipo" class="form-control" value="{{ request('tipo') }}" placeholder="Tipo" >
                        </div>

                                    <div class="col-md-4 pull-right">
                                        <div class="text-right">
                                            @include('partials.botao_limpar', ['url' => route('nota_pessoas.index')])
                                            @include('partials.botao_imprimir_relatorio')
                                            @include('partials.botao_novo', ['route' => 'nota_pessoas.create'])
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
                           <span class="caption-subject font-green bold uppercase">Nota Pessoas</span>
                       </div>
               </div>
                    <div class="portlet-body ">
                        <div class="clearfix">
                            <div class="table-responsive">
                               {!! Table::withContents($dados)->hover()
                                          ->callback('',function ($field,$dado){
                                            $btn ="";
                                                   if(temAlgumaPermissao(['nota_pessoas.destroy'])){
                                                       $btn.= Button::danger(Icon::create('remove'))->asLinkTo(route('nota_pessoas.destroy',['dado'=>$dado->id]))->addAttributes(['class'=>'btn-xs confirma-acao pull-right','data-texto'=>'Deseja mesmo excluir este registro?','id'=>'btn-excluir','toggle'=>'tooltip','title'=>'Deletar']);
                                                   }
                                                   if(temAlgumaPermissao(['nota_pessoas.edit'])){
                                                     $btn.= Button::success(Icon::create('pencil'))->asLinkTo(route('nota_pessoas.edit',['dado'=>$dado->id]))->addAttributes(['class'=>'btn-xs pull-right','toggle'=>'tooltip','title'=>'Editar']);
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