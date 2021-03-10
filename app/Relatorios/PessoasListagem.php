<?php

namespace LaravelMetronic\Relatorios;

use LaravelMetronic\Models\Pessoas;

class PessoasListagem extends RelatorioBase
{

    /**
     * Título do relatório.
     *
     * @var string
     */
    protected $titulo = 'Lista de Pessoas';

    /**
     * Quantidade de itens por página.
     *
     * @var int
     */
    protected $porPagina = 10;

    /**
     * A view utilizada para impressão deste relatório.
     *
     * @var string
     */
    protected $view = 'pessoas.imprimir';

    public function exportar($filtros){
        $this->setTitulo($this->titulo);
        $dados = $this->gerar($filtros, false);
        $this->setDados($dados);
        $this->setView($this->view);
        $this->setPorPagina($this->porPagina);
        $this->setRelformato($filtros['relformato']);
        $this->setFiltros($filtros);
        return $this->gerar_relatorio();
    }
    /**
     * Gera os dados.
     *
     * @param array $filtros
     * @param bool $paginar
     *
     * @return mixed
     */
    public function gerar($filtros, $paginar = true)
    {
        $dados = Pessoas::orderBy('id', 'ASC');

        if (!empty($filtros["id"])) { $dados->where("id", "=", $filtros["id"] ); }if (!empty($filtros["nome"])) { $dados->where("nome", "LIKE", "%" . $filtros["nome"] . "%"); }if (!empty($filtros["nome_fantasia"])) { $dados->where("nome_fantasia", "LIKE", "%" . $filtros["nome_fantasia"] . "%"); }if (!empty($filtros["cpf_cnpj"])) { $dados->where("cpf_cnpj", "LIKE", "%" . $filtros["cpf_cnpj"] . "%"); }if (!empty($filtros["logradouro"])) { $dados->where("logradouro", "LIKE", "%" . $filtros["logradouro"] . "%"); }if (!empty($filtros["numero"])) { $dados->where("numero", "LIKE", "%" . $filtros["numero"] . "%"); }if (!empty($filtros["bairro"])) { $dados->where("bairro", "LIKE", "%" . $filtros["bairro"] . "%"); }if (!empty($filtros["cod_municipio"])) { $dados->where("cod_municipio", "=", $filtros["cod_municipio"] ); }if (!empty($filtros["municipio"])) { $dados->where("municipio", "LIKE", "%" . $filtros["municipio"] . "%"); }if (!empty($filtros["uf"])) { $dados->where("uf", "LIKE", "%" . $filtros["uf"] . "%"); }if (!empty($filtros["cep"])) { $dados->where("cep", "LIKE", "%" . $filtros["cep"] . "%"); }if (!empty($filtros["codigo_pais"])) { $dados->where("codigo_pais", "=", $filtros["codigo_pais"] ); }if (!empty($filtros["inscricao_estadual"])) { $dados->where("inscricao_estadual", "LIKE", "%" . $filtros["inscricao_estadual"] . "%"); }if (!empty($filtros["inscricao_municipal"])) { $dados->where("inscricao_municipal", "LIKE", "%" . $filtros["inscricao_municipal"] . "%"); }if (!empty($filtros["crt"])) { $dados->where("crt", "LIKE", "%" . $filtros["crt"] . "%"); }if (!empty($filtros["email"])) { $dados->where("email", "LIKE", "%" . $filtros["email"] . "%"); }

        if ($paginar) {
            return $dados->paginate($this->porPagina);
        }

        return $dados->get();
    }
}