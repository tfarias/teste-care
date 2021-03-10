<?php

function data_sql($data){
    $date = Carbon\Carbon::createFromFormat('d/m/Y', $data);
    return $date->format('Y-m-d');
}

function data_br($data){
    $date = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data);
    return $date->format('d/m/Y');
}
function datetime_sql($data){
    $date = Carbon\Carbon::createFromFormat('d/m/Y H:i:s', $data);
    return $date->format('Y-m-d H:i:s');
}
function removerMascara($valor, $outros = null)
{
    $remover = [
        '.', ',', '/', '-', '(', ')', '[', ']', ' ', '+', '_',
    ];

    if (!is_null($outros))
    {
        if (!is_array($outros))
        {
            $outros = [$outros];
        }

        $remover = array_merge($remover, $outros);
    }

    return str_replace($remover, '', $valor);
}

/**
 * Verifica se o usuário tem pelo menos uma das permissões especificadas.
 *
 * @param array $rotas
 *
 * @return bool
 */
function temAlgumaPermissao($rotas)
{
    foreach ($rotas as $rota)
    {
        if (\Illuminate\Support\Facades\Gate::check($rota))
        {
            return true;
        }
    }

    return false;
}

function XML2Array(SimpleXMLElement $parent)
{
    $array = array();

    foreach ($parent as $name => $element) {
        ($node = & $array[$name])
        && (1 === count($node) ? $node = array($node) : 1)
        && $node = & $node[];

        $node = $element->count() ? XML2Array($element) : trim($element);
    }

    return $array;


}

