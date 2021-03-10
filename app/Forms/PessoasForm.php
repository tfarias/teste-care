<?php

namespace LaravelMetronic\Forms;

use Bootstrapper\Facades\Icon;
use Kris\LaravelFormBuilder\Form;

class PessoasForm extends Form
{
    public function buildForm()
    {
        
    $this->add("nome","text",[
    "label"=>"Nome",
    "rules" => "required",
    "wrapper" => ["class" => "form-group col-md-6"]
    ]);
    $this->add("nome_fantasia","text",[
    "label"=>"Nome_fantasia",
    "rules" => "nullable",
    "wrapper" => ["class" => "form-group col-md-6"]
    ]);
    $this->add("cpf_cnpj","text",[
    "label"=>"Cpf_cnpj",
    "rules" => "required|unique:pessoas,cpf_cnpj",
    "wrapper" => ["class" => "form-group col-md-6"]
    ]);
    $this->add("logradouro","text",[
    "label"=>"Logradouro",
    "rules" => "required",
    "wrapper" => ["class" => "form-group col-md-6"]
    ]);
    $this->add("numero","text",[
    "label"=>"Numero",
    "rules" => "required",
    "wrapper" => ["class" => "form-group col-md-6"]
    ]);
    $this->add("bairro","text",[
    "label"=>"Bairro",
    "rules" => "required",
    "wrapper" => ["class" => "form-group col-md-6"]
    ]);
    $this->add("cod_municipio","text",[
    "label"=>"Cod_municipio",
    "rules" => "required",
    "wrapper" => ["class" => "form-group col-md-6"]
    ]);
    $this->add("municipio","text",[
    "label"=>"Municipio",
    "rules" => "required",
    "wrapper" => ["class" => "form-group col-md-6"]
    ]);
    $this->add("uf","text",[
    "label"=>"Uf",
    "rules" => "required",
    "wrapper" => ["class" => "form-group col-md-6"]
    ]);
    $this->add("cep","text",[
    "label"=>"Cep",
    "rules" => "required",
    "wrapper" => ["class" => "form-group col-md-6"]
    ]);
    $this->add("codigo_pais","text",[
    "label"=>"Codigo_pais",
    "rules" => "required",
    "wrapper" => ["class" => "form-group col-md-6"]
    ]);
    $this->add("inscricao_estadual","text",[
    "label"=>"Inscricao_estadual",
    "rules" => "nullable",
    "wrapper" => ["class" => "form-group col-md-6"]
    ]);
    $this->add("inscricao_municipal","text",[
    "label"=>"Inscricao_municipal",
    "rules" => "nullable",
    "wrapper" => ["class" => "form-group col-md-6"]
    ]);
    $this->add("crt","text",[
    "label"=>"Crt",
    "rules" => "nullable",
    "wrapper" => ["class" => "form-group col-md-6"]
    ]);
    $this->add("email","text",[
    "label"=>"Email",
    "rules" => "nullable",
    "wrapper" => ["class" => "form-group col-md-6"]
    ]);
        $this
           ->add('submit', 'submit', ['label' =>  Icon::create('pencil').' Salvar','attr'=>['class'=>'btn btn-primary btn-send-form pull-left']])
           ->add('clear', 'reset', ['label' => Icon::create('refresh').' Limpar','attr'=>['class'=>'btn btn-danger pull-left']]);
    }
}
