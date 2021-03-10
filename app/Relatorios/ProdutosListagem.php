<?php

namespace LaravelMetronic\Relatorios;

use LaravelMetronic\Models\Produtos;

class ProdutosListagem extends RelatorioBase
{

    /**
     * Título do relatório.
     *
     * @var string
     */
    protected $titulo = 'Lista de Produtos';

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
    protected $view = 'produtos.imprimir';

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
        $dados = Produtos::orderBy('id', 'ASC');

        if (!empty($filtros["id"])) { $dados->where("id", "=", $filtros["id"] ); }if (!empty($filtros["codigo_produto"])) { $dados->where("codigo_produto", "LIKE", "%" . $filtros["codigo_produto"] . "%"); }if (!empty($filtros["descricao"])) { $dados->where("descricao", "LIKE", "%" . $filtros["descricao"] . "%"); }

        if ($paginar) {
            return $dados->paginate($this->porPagina);
        }

        return $dados->get();
    }
}