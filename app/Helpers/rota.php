<?php

/**
 * Rotas padrões para CRUD simples.
 *
 * @param $controller
 */
function rotasCrud($controller,$tabela)
{
    Route::get('/', ['uses' => "$controller@index", 'as' => 'index']);
    Route::get('create', ['uses' => "$controller@create", 'as' => 'create']);
    Route::post('create', ['uses' => "$controller@store", 'as' => 'create.post']);
    Route::get('{'.$tabela.'}/edit', ['uses' => "$controller@edit", 'as' => 'edit']);
    Route::put('{'.$tabela.'}/edit', ['uses' => "$controller@update", 'as' => 'edit.post']);
    Route::delete('destroy/{'.$tabela.'}', ['uses' => "$controller@destroy", 'as' => 'destroy']);
    Route::get('getedit/{id}', ['uses' => "$controller@getedit", 'as' => 'getedit']);
    Route::post('fill', ['uses' => "$controller@fill", 'as' => 'fill']);
}