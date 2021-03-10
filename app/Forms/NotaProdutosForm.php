<?php

namespace LaravelMetronic\Forms;

use Bootstrapper\Facades\Icon;
use Kris\LaravelFormBuilder\Form;

class NotaProdutosForm extends Form
{
    public function buildForm()
    {
        
    
    $this->add("id_nota","entity",[
    "class"=>\LaravelMetronic\Models\XmlUpload::class,
    "property"=>"id",
    "label"=>"Id_nota",
    "empty_value"=>"Selecione",
    "rules" => "required|integer|exists:xml_upload,id",
    "wrapper" => ["class" => "form-group col-md-6"]
    ]);
    
    $this->add("id_produto","entity",[
    "class"=>\LaravelMetronic\Models\Produtos::class,
    "property"=>"id",
    "label"=>"Id_produto",
    "empty_value"=>"Selecione",
    "rules" => "required|integer|exists:produtos,id",
    "wrapper" => ["class" => "form-group col-md-6"]
    ]);
    $this->add("valor","text",[
    "label"=>"Valor",
    "rules" => "required",
    "wrapper" => ["class" => "form-group col-md-6"]
    ]);
    $this->add("quantidade","text",[
    "label"=>"Quantidade",
    "rules" => "required",
    "wrapper" => ["class" => "form-group col-md-6"]
    ]);
    $this->add("valor_icms","text",[
    "label"=>"Valor_icms",
    "rules" => "required",
    "wrapper" => ["class" => "form-group col-md-6"]
    ]);
    $this->add("valor_pis","text",[
    "label"=>"Valor_pis",
    "rules" => "required",
    "wrapper" => ["class" => "form-group col-md-6"]
    ]);
    $this->add("valor_cofins","text",[
    "label"=>"Valor_cofins",
    "rules" => "required",
    "wrapper" => ["class" => "form-group col-md-6"]
    ]);
    $this->add("valor_imposto","text",[
    "label"=>"Valor_imposto",
    "rules" => "required",
    "wrapper" => ["class" => "form-group col-md-6"]
    ]);
        $this
           ->add('submit', 'submit', ['label' =>  Icon::create('pencil').' Salvar','attr'=>['class'=>'btn btn-primary btn-send-form pull-left']])
           ->add('clear', 'reset', ['label' => Icon::create('refresh').' Limpar','attr'=>['class'=>'btn btn-danger pull-left']]);
    }
}
