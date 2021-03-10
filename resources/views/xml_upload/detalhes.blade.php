@extends('layouts.template')

@section('conteudo')


    <div class="this-place">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li><a href="{{route('xml_upload.index')}}">Upload XML</a></li>
                <i class="fa fa-chevron-right"></i>
                <li>
                    <span>Detalhes</span>
                </li>
            </ul>
        </div>
        <div class="clearfix"></div>
        <div class="row area">
            <div class="col-md-4 pull-right">
                <div class="text-right">
                    <a href="{{ route('xml_upload.print_nota',$xml_upload->id) }}" class="btn btn-primary" title="Gerar Nota" target="_blank"><i class="fa fa-print"></i> Gerar Nota</a>

                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-md-12">
                <div class="clearfix"></div>



                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <span class="caption-subject font-green bold uppercase">Detalhes Nota</span>
                        </div>
                    </div>
                    <div class="portlet-body ">
                        <div class="clearfix">
                            <div class="table-responsive">
                                <div class="table table-hover">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>CUF</th>
                                            <th>CNF</th>
                                            <th>NATOP</th>
                                            <th>MOD</th>
                                            <th>Série</th>
                                            <th>Número</th>
                                            <th>Data</th>
                                            <th>Valor</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>{{$xml_upload->cuf}}</td>
                                            <td>{{$xml_upload->cnf}}</td>
                                            <td>{{$xml_upload->natop}}</td>
                                            <td>{{$xml_upload->mod}}</td>
                                            <td>{{$xml_upload->serie}}</td>
                                            <td>{{$xml_upload->numero_nota}}</td>
                                            <td>{{$xml_upload->data_nota->format('d/m/Y H:i:s')}}</td>
                                            <td>{{$xml_upload->valor_total}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <span class="caption-subject font-green bold uppercase">Pessoas Nota</span>
                        </div>
                    </div>
                    <div class="portlet-body ">
                        <div class="clearfix">
                            <div class="table-responsive">
                                <div class="table table-hover">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>Tipo</th>
                                            <th>Nome</th>
                                            <th>Nome Fantasia</th>
                                            <th>CNPJ/CPF</th>
                                            <th>Logradouro</th>
                                            <th>Numero</th>
                                            <th>Bairro</th>
                                            <th>Município</th>
                                            <th>Uf</th>
                                            <th>Email</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($xml_upload->pessoas as $p)
                                            <tr>
                                                <td>{{$p->pivot->tipo == 'E' ? 'Emitente' : 'Destinatário'}}</td>
                                                <td>{{$p->nome}}</td>
                                                <td>{{$p->nome_fantasia}}</td>
                                                <td>{{$p->cpf_cnpj}}</td>
                                                <td>{{$p->logradouro}}</td>
                                                <td>{{$p->numero}}</td>
                                                <td>{{$p->bairro}}</td>
                                                <td>{{$p->municipio}}</td>
                                                <td>{{$p->uf}}</td>
                                                <td>{{$p->email}}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9">Nenhum registro encontrado!</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <span class="caption-subject font-green bold uppercase">Produtos Nota</span>
                        </div>
                    </div>
                    <div class="portlet-body ">
                        <div class="clearfix">
                            <div class="table-responsive">
                                <div class="table table-hover">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th>Código Produto</th>
                                            <th>Descrição</th>
                                            <th>Valor</th>
                                            <th>Quantidade</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($xml_upload->produtos as $pr)
                                            <tr>
                                                <td>{{$pr->codigo_produto}}</td>
                                                <td>{{$pr->descricao}}</td>
                                                <td>{{$pr->pivot->valor}}</td>
                                                <td>{{$pr->pivot->quantidade}}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9">Nenhum registro encontrado!</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection