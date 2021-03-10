<?php

namespace LaravelMetronic\Forms;

use Bootstrapper\Facades\Icon;
use Kris\LaravelFormBuilder\Form;

class XmlUploadForm extends Form
{
    public function buildForm()
    {

        $this->add("path", "file", [
            "label" => "Arquivo",
            "rules" => "required|mimes:xml,application/xml|cnpf_import|pront_nfe", //aqui faço as validações propostas pelo teste
            "attr" => [
              "class" => "input-file-xml"
            ],
            'error_messages' => [
                'path.mimes' => 'Só é permitido fazer uploads de arquivos XML',
                'path.cnpf_import' => "Será permitido apenas XML do CNPJ: ".env('CNPJ_VERIFICAR'),
                'path.pront_nfe' => "Será permitido apenas XML com protocolo de autorização preenchido ",
            ],
            "wrapper" => ["class" => "form-group col-md-12"]
        ]);

        $this
            ->add('submit', 'submit', ['label' => Icon::create('pencil') . ' Salvar', 'attr' => ['class' => 'btn btn-primary btn-send-form pull-left']])
            ->add('clear', 'reset', ['label' => Icon::create('refresh') . ' Limpar', 'attr' => ['class' => 'btn btn-danger pull-left']]);
    }
}
