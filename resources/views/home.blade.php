@extends('layouts.template')

@section('conteudo')

    <h4>Olá <strong>{{ auth()->user()->primeiroNome }}</strong></h4>
    <hr/>

    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-green bold uppercase">Gerenciar as notas fiscais do cliente.</span>
            </div>
        </div>
        <div class="portlet-body ">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <span class="caption-subject font-green bold uppercase">Requisitos Funcionais.</span>
                    </div>
                </div>
                <div class="portlet-body ">
                    <div class="clearfix">
                        <div class="table-responsive">
                            <div class="table table-hover">
                                <table class="table table-hover">
                                    <tr>
                                        <th>O sistema deve ter uma tela para realizar upload de um arquivo na extensão
                                            ".xml"
                                        </th>
                                    </tr>
                                    <tr>
                                        <td>Encontra-se no menu esquerdo Notas -> Upload Notas</td>
                                    </tr>

                                    <tr>
                                        <th>O sistema deve validar se o arquivo é uma extensão .xml</th>
                                    </tr>
                                    <tr>
                                        <td>
                                            Encontra-se no menu esquerdo Notas -> Upload Notas -> Novo Registro <br/>
                                            (A validação se o mesmo é da extensão .xml esta no arquivo
                                            app/Forms/XmlUploadForm.php)
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>O sistema deve permitir somente o upload do arquivo xml se o campo CNPJ do
                                            emitente(emit) for
                                            "09066241000884"
                                        </th>
                                    </tr>
                                    <tr>
                                        <td>
                                            A chamada da validação está no arquivo app/Forms/XmlUploadForm.php e a
                                            validação em si encontra-se no arquivo app/Providers/AppServiceProvider.php
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>O sistema deve validar se a nota possui protocolo de autorização preenchido
                                            (campo nProt);
                                        </th>
                                    </tr>
                                    <tr>
                                        <td>
                                            A chamada da validação está no arquivo app/Forms/XmlUploadForm.php e a
                                            validação em si encontra-se no arquivo app/Providers/AppServiceProvider.php
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>O sistema deve exibir em uma tela os seguintes dados: Número da nota Fiscal,
                                            Data da nota Fiscal,
                                            dados completos do destinatário e valor total da nota fiscal;
                                        </th>
                                    </tr>
                                    <tr>
                                        <td>
                                            Encontra-se no menu esquerdo Notas -> Upload Notas
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Extras!</th>
                                    </tr>
                                    <tr>
                                        <td>
                                            Na tela de Notas adicionei um botão para gerar o DANFE do XML e também fiz
                                            os detalhes da nota.
                                        </td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <span class="caption-subject font-green bold uppercase">Requisitos Não Funcionais.</span>
                    </div>
                </div>
                <div class="portlet-body ">
                    <div class="clearfix">
                        <div class="table-responsive">
                            <div class="table table-hover">
                                <table class="table table-hover">
                                    <tr>
                                        <th>Os dados que serão exibidos na tela deverão ser armazenados em um banco de dados MySQL;</th>
                                    </tr>
                                    <tr>
                                        <td>O dump da base vai estar na pasta database/teste-care.sql</td>
                                    </tr>

                                    <tr>
                                        <th>Deverá ser desenvolvido em linguagem PHP 7;</th>
                                    </tr>
                                    <tr>
                                        <td>Foi feito em Laravel com PHP 7.2.34</td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection