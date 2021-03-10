<?php

namespace LaravelMetronic\Relatorios;

use LaravelMetronic\Models\NotaPessoas;

class NotaPessoasListagem extends RelatorioBase
{

    /**
     * Título do relatório.
     *
     * @var string
     */
    protected $titulo = 'Lista de Nota Pessoas';

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
    protected $view = 'nota_pessoas.imprimir';

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
        $dados = NotaPessoas::orderBy('id', 'ASC');

        if (!empty($filtros["id"])) { $dados->where("id", "=", $filtros["id"] ); }if (!empty($filtros["id_nota"])) { $dados->where("id_nota", "=", $filtros["id_nota"] ); }if (!empty($filtros["id_pessoa"])) { $dados->where("id_pessoa", "=", $filtros["id_pessoa"] ); }if (!empty($filtros["tipo"])) { $dados->where("tipo", "LIKE", "%" . $filtros["tipo"] . "%"); }

        if ($paginar) {
            return $dados->paginate($this->porPagina);
        }

        return $dados->get();
    }
}