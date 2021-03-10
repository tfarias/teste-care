<?php

namespace LaravelMetronic\Relatorios;

use Carbon\Carbon;
use LaravelMetronic\Models\XmlUpload;

class XmlUploadListagem extends RelatorioBase
{

    /**
     * Título do relatório.
     *
     * @var string
     */
    protected $titulo = 'Lista de Upload XML';

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
    protected $view = 'xml_upload.imprimir';

    public function exportar($filtros)
    {
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
        $dados = XmlUpload::orderBy('id', 'ASC');

        if (!empty($filtros["id"])) {
            $dados->where("id", "=", $filtros["id"]);
        }
        if (!empty($filtros["path"])) {
            $dados->where("path", "LIKE", "%" . $filtros["path"] . "%");
        }
        if (!empty($filtros["cuf"])) {
            $dados->where("cuf", "LIKE", "%" . $filtros["cuf"] . "%");
        }
        if (!empty($filtros["cnf"])) {
            $dados->where("cnf", "LIKE", "%" . $filtros["cnf"] . "%");
        }
        if (!empty($filtros["natop"])) {
            $dados->where("natop", "LIKE", "%" . $filtros["natop"] . "%");
        }
        if (!empty($filtros["mod"])) {
            $dados->where("mod", "=", $filtros["mod"]);
        }
        if (!empty($filtros["serie"])) {
            $dados->where("serie", "=", $filtros["serie"]);
        }
        if (!empty($filtros["numero_nota"])) {
            $dados->where("numero_nota", "=", $filtros["numero_nota"]);
        }
        if (!empty($filtros["data_nota"])) {
            $dados->where("data_nota", "LIKE", "%" . $filtros["data_nota"] . "%");
        }

        if (!empty($filtros["data_nota_inicio"])) {
            $dados->where("data_nota", ">=", Carbon::createFromFormat('d/m/Y H:i', $filtros["data_nota_inicio"])->format('Y-m-d H:i:s'));
        }
        if (!empty($filtros["data_nota_fim"])) {
            $dados->where("data_nota", "<=", Carbon::createFromFormat('d/m/Y H:i', $filtros["data_nota_fim"])->format('Y-m-d H:i:s'));
        }

        if (!empty($filtros["aut_xml_cnpj"])) {
            $dados->where("aut_xml_cnpj", "LIKE", "%" . $filtros["aut_xml_cnpj"] . "%");
        }
        if (!empty($filtros["valor_total"])) {
            $dados->where("valor_total", "LIKE", "%" . $filtros["valor_total"] . "%");
        }

        if ($paginar) {
            return $dados->paginate($this->porPagina);
        }

        return $dados->get();
    }
}