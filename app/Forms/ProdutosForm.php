<?php

namespace LaravelMetronic\Forms;

use Bootstrapper\Facades\Icon;
use Kris\LaravelFormBuilder\Form;

class ProdutosForm extends Form
{
    public function buildForm()
    {
        
    $this->add("codigo_produto","text",[
    "label"=>"Codigo_produto",
    "rules" => "required",
    "wrapper" => ["class" => "form-group col-md-6"]
    ]);
    $this->add("descricao","text",[
    "label"=>"Descricao",
    "rules" => "required",
    "wrapper" => ["class" => "form-group col-md-6"]
    ]);
        $this
           ->add('submit', 'submit', ['label' =>  Icon::create('pencil').' Salvar','attr'=>['class'=>'btn btn-primary btn-send-form pull-left']])
           ->add('clear', 'reset', ['label' => Icon::create('refresh').' Limpar','attr'=>['class'=>'btn btn-danger pull-left']]);
    }
}
