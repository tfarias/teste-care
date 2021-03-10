@extends('layouts.template')
@section('conteudo')
    <div class="this-place">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>Upload XML</li>
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
                        <form action="{{ route('xml_upload.index') }}" method="get" class="form-filter validate">

                            <div class="form-group col-lg-3 col-sm-6">
                                <label for="numero_nota">Numero Nota</label>
                                <input type="text" name="numero_nota" id="numero_nota" class="form-control"
                                       value="{{ request('numero_nota') }}" placeholder="NumeroNota">
                            </div>

                            <div class="form-group col-lg-3 col-sm-6">
                                <label for="dt_notifica_inicio">Data Nota</label>
                                <div class="input-group">
                                    <span class="input-group-addon">Início</span>
                                    <input type="text" class="form-control" name="data_nota_inicio" id="data_nota_inicio"  value="{{ request('data_nota_inicio') }}" mask="date" />
                                    <span class="input-group-addon">Fim</span>
                                    <input type="text" class="form-control" name="data_nota_fim" id="data_nota_fim"  value="{{ request('data_nota_fim') }}" mask="date"/>
                                </div>

                            </div>


                            <div class="col-md-4 pull-right">
                                <div class="text-right">
                                    @include('partials.botao_limpar', ['url' => route('xml_upload.index')])
                                    @include('partials.botao_imprimir_relatorio')
                                    @include('partials.botao_novo', ['route' => 'xml_upload.create'])
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
                            <span class="caption-subject font-green bold uppercase">Upload XML</span>
                        </div>
                    </div>
                    <div class="portlet-body ">
                        <div class="clearfix">
                            <div class="table-responsive">
                                {!! Table::withContents($dados)->hover()
                                           ->callback('',function ($field,$dado){
                                             $btn ="";
                                                    if(temAlgumaPermissao(['xml_upload.destroy'])){
                                                        $btn.= Button::danger(Icon::create('remove'))->asLinkTo(route('xml_upload.destroy',['dado'=>$dado->id]))->addAttributes(['class'=>'btn-xs confirma-acao pull-right','data-texto'=>'Deseja mesmo excluir este registro?','id'=>'btn-excluir','toggle'=>'tooltip','title'=>'Deletar']);
                                                    }
                                                    if(temAlgumaPermissao(['xml_upload.detalhes'])){
                                                      $btn.= Button::success(Icon::create('list'))->asLinkTo(route('xml_upload.detalhes',['dado'=>$dado->id]))->addAttributes(['class'=>'btn-xs pull-right','toggle'=>'tooltip','title'=>'Detalhes']);
                                                    }

                                                    if(temAlgumaPermissao(['xml_upload.print_nota'])){
                                                      $btn.= Button::info(Icon::create('print'))->asLinkTo(route('xml_upload.print_nota',['dado'=>$dado->id]))->addAttributes(['class'=>'btn-xs pull-right','toggle'=>'tooltip','title'=>'Gerar Nota','target'=>'_blank']);
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