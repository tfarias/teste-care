<?php

namespace LaravelMetronic\Relatorios;

use LaravelMetronic\Models\NotaProdutos;

class NotaProdutosListagem extends RelatorioBase
{

    /**
     * Título do relatório.
     *
     * @var string
     */
    protected $titulo = 'Lista de Nota Produtos';

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
    protected $view = 'nota_produtos.imprimir';

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
        $dados = NotaProdutos::orderBy('id', 'ASC');

        if (!empty($filtros["id"])) { $dados->where("id", "=", $filtros["id"] ); }if (!empty($filtros["id_nota"])) { $dados->where("id_nota", "=", $filtros["id_nota"] ); }if (!empty($filtros["id_produto"])) { $dados->where("id_produto", "=", $filtros["id_produto"] ); }if (!empty($filtros["valor"])) { $dados->where("valor", "LIKE", "%" . $filtros["valor"] . "%"); }if (!empty($filtros["quantidade"])) { $dados->where("quantidade", "=", $filtros["quantidade"] ); }if (!empty($filtros["valor_icms"])) { $dados->where("valor_icms", "LIKE", "%" . $filtros["valor_icms"] . "%"); }if (!empty($filtros["valor_pis"])) { $dados->where("valor_pis", "LIKE", "%" . $filtros["valor_pis"] . "%"); }if (!empty($filtros["valor_cofins"])) { $dados->where("valor_cofins", "LIKE", "%" . $filtros["valor_cofins"] . "%"); }if (!empty($filtros["valor_imposto"])) { $dados->where("valor_imposto", "LIKE", "%" . $filtros["valor_imposto"] . "%"); }

        if ($paginar) {
            return $dados->paginate($this->porPagina);
        }

        return $dados->get();
    }
}