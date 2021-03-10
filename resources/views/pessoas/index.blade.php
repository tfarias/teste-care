@extends('layouts.template')
@section('conteudo')
<div class="this-place">
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>Pessoas</li>
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
                            <form action="{{ route('pessoas.index') }}" method="get" class="form-filter validate">
                                     <div class="form-group col-lg-3 col-sm-6">
                            <label for="nome">Nome</label>
                             <input type="text" name="nome" id="nome" class="form-control" value="{{ request('nome') }}" placeholder="Nome"  maxlength="255" >
                        </div> <div class="form-group col-lg-3 col-sm-6">
                            <label for="nome_fantasia">NomeFantasia</label>
                             <input type="text" name="nome_fantasia" id="nome_fantasia" class="form-control" value="{{ request('nome_fantasia') }}" placeholder="NomeFantasia"  maxlength="255" >
                        </div> <div class="form-group col-lg-3 col-sm-6">
                            <label for="cpf_cnpj">CpfCnpj</label>
                             <input type="text" name="cpf_cnpj" id="cpf_cnpj" class="form-control" value="{{ request('cpf_cnpj') }}" placeholder="CpfCnpj"  maxlength="50" >
                        </div> <div class="form-group col-lg-3 col-sm-6">
                            <label for="logradouro">Logradouro</label>
                             <input type="text" name="logradouro" id="logradouro" class="form-control" value="{{ request('logradouro') }}" placeholder="Logradouro"  maxlength="255" >
                        </div> <div class="form-group col-lg-3 col-sm-6">
                            <label for="numero">Numero</label>
                             <input type="text" name="numero" id="numero" class="form-control" value="{{ request('numero') }}" placeholder="Numero"  maxlength="10" >
                        </div> <div class="form-group col-lg-3 col-sm-6">
                            <label for="bairro">Bairro</label>
                             <input type="text" name="bairro" id="bairro" class="form-control" value="{{ request('bairro') }}" placeholder="Bairro"  maxlength="255" >
                        </div> <div class="form-group col-lg-3 col-sm-6">
                            <label for="cod_municipio">CodMunicipio</label>
                             <input type="text" name="cod_municipio" id="cod_municipio" class="form-control" value="{{ request('cod_municipio') }}" placeholder="CodMunicipio" >
                        </div> <div class="form-group col-lg-3 col-sm-6">
                            <label for="municipio">Municipio</label>
                             <input type="text" name="municipio" id="municipio" class="form-control" value="{{ request('municipio') }}" placeholder="Municipio"  maxlength="255" >
                        </div> <div class="form-group col-lg-3 col-sm-6">
                            <label for="uf">Uf</label>
                             <input type="text" name="uf" id="uf" class="form-control" value="{{ request('uf') }}" placeholder="Uf"  maxlength="10" >
                        </div> <div class="form-group col-lg-3 col-sm-6">
                            <label for="cep">Cep</label>
                             <input type="text" name="cep" id="cep" class="form-control" value="{{ request('cep') }}" placeholder="Cep"  maxlength="20" >
                        </div> <div class="form-group col-lg-3 col-sm-6">
                            <label for="codigo_pais">CodigoPais</label>
                             <input type="text" name="codigo_pais" id="codigo_pais" class="form-control" value="{{ request('codigo_pais') }}" placeholder="CodigoPais" >
                        </div> <div class="form-group col-lg-3 col-sm-6">
                            <label for="inscricao_estadual">InscricaoEstadual</label>
                             <input type="text" name="inscricao_estadual" id="inscricao_estadual" class="form-control" value="{{ request('inscricao_estadual') }}" placeholder="InscricaoEstadual"  maxlength="255" >
                        </div> <div class="form-group col-lg-3 col-sm-6">
                            <label for="inscricao_municipal">InscricaoMunicipal</label>
                             <input type="text" name="inscricao_municipal" id="inscricao_municipal" class="form-control" value="{{ request('inscricao_municipal') }}" placeholder="InscricaoMunicipal"  maxlength="255" >
                        </div> <div class="form-group col-lg-3 col-sm-6">
                            <label for="crt">Crt</label>
                             <input type="text" name="crt" id="crt" class="form-control" value="{{ request('crt') }}" placeholder="Crt"  maxlength="255" >
                        </div> <div class="form-group col-lg-3 col-sm-6">
                            <label for="email">Email</label>
                             <input type="text" name="email" id="email" class="form-control" value="{{ request('email') }}" placeholder="Email"  maxlength="255" >
                        </div>

                                    <div class="col-md-4 pull-right">
                                        <div class="text-right">
                                            @include('partials.botao_limpar', ['url' => route('pessoas.index')])
                                            @include('partials.botao_imprimir_relatorio')
                                            @include('partials.botao_novo', ['route' => 'pessoas.create'])
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
                           <span class="caption-subject font-green bold uppercase">Pessoas</span>
                       </div>
               </div>
                    <div class="portlet-body ">
                        <div class="clearfix">
                            <div class="table-responsive">
                               {!! Table::withContents($dados)->hover()
                                          ->callback('',function ($field,$dado){
                                            $btn ="";
                                                   if(temAlgumaPermissao(['pessoas.destroy'])){
                                                       $btn.= Button::danger(Icon::create('remove'))->asLinkTo(route('pessoas.destroy',['dado'=>$dado->id]))->addAttributes(['class'=>'btn-xs confirma-acao pull-right','data-texto'=>'Deseja mesmo excluir este registro?','id'=>'btn-excluir','toggle'=>'tooltip','title'=>'Deletar']);
                                                   }
                                                   if(temAlgumaPermissao(['pessoas.edit'])){
                                                     $btn.= Button::success(Icon::create('pencil'))->asLinkTo(route('pessoas.edit',['dado'=>$dado->id]))->addAttributes(['class'=>'btn-xs pull-right','toggle'=>'tooltip','title'=>'Editar']);
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