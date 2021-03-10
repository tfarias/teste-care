<?php
// Rotas de login, não precisam de autorização
Route::get('login', ['as' => 'login', 'uses' => 'Auth\LoginController@showLoginForm']);
Route::post('login', ['as' => 'login.post', 'uses' => 'Auth\LoginController@login']);
Route::get('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);
Route::post('password/email', [
    'as' => 'password.email',
    'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail'
]);
Route::get('password/reset', [
    'as' => 'password.request',
    'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm'
]);

Route::post('password/reset', [
    'as' => '',
    'uses' => 'Auth\ResetPasswordController@reset'
]);

Route::get('password/reset/{token}', [
    'as' => 'password.reset',
    'uses' => 'Auth\ResetPasswordController@showResetForm'
]);
// rota para bloquear acessso nao autorizado
Route::get('nao-autorizado', function () {
    return view('erros.nao_autorizado');
})->name('nao_autorizado');

/**
 * Rotas que necessitam de autenticação
 */
Route::group(['middleware' => ['auth', 'necessita-permissao']], function () {
    Route::get('/', ['uses' => 'HomeController@index', 'as' => 'home']);

    Route::get('storage/{filename}', function ($filename) {
        /*
         * antes de utilizar esta rota deve rodar esse comando
         *  php artisan storage:link
         * */
        $path = storage_path('public/' . $filename);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    })->name('storage');

    Route::group(['prefix' => 'usuario', 'as' => 'usuario.'], function () {
        Route::get('cadastro', function () {
            return view('usuario.cadastro');
        })->name('cadastro');

        Route::get('alterar_imagem/{id}', ['uses' => 'UsuarioController@alterarImagem', 'as' => 'alterar_imagem']);
        Route::post('alterar_imagem/{id}', ['uses' => 'UsuarioController@salvarImagem', 'as' => 'imagem_post']);
        Route::get('alterar_senha/{id}', ['uses' => 'UsuarioController@alterarSenha', 'as' => 'alterar_senha']);
        Route::delete('delete_img/{id}', ['uses' => 'UsuarioController@deleteImg', 'as' => 'delete_img']);
        Route::post('alterar_senha/{id}', ['uses' => 'UsuarioController@salvarSenha', 'as' => 'salvar_senha']);
        Route::post('alterar_cadastro/{id}', ['uses' => 'UsuarioController@alterarCadastro', 'as' => 'alterar_cadastro']);

    });

    // Tipo de usuário
    Route::group(['prefix' => 'tipo_usuario', 'as' => 'tipo_usuario.'], function () {
        rotasCrud('TipoUsuarioController', 'tipo_usuario');
        Route::post('carregar-permissoes', ['uses' => 'TipoUsuarioController@carregarPermissoes', 'as' => 'carregar_permissoes']);
        Route::get('gerenciar-permissoes', ['uses' => 'TipoUsuarioController@gerenciarPermissoes', 'as' => 'gerenciar_permissoes']);
        Route::post('gerenciar-permissoes', ['uses' => 'TipoUsuarioController@salvarPermissoes', 'as' => 'gerenciar_permissoes.post']);
    });


    Route::group(['prefix' => 'sis_usuario', 'as' => 'sis_usuario.'], function () {
        rotasCrud('SisUsuarioController', 'sis_usuario');
    });
    Route::group(['prefix' => 'aux_tipo_usuario', 'as' => 'aux_tipo_usuario.'], function () {
        rotasCrud('AuxTipoUsuarioController', 'aux_tipo_usuario');
    });
    Route::group(['prefix' => 'rota', 'as' => 'rota.'], function () {
        rotasCrud('RotaController', 'rota');
    });
    Route::group(['prefix' => 'tipo_rota', 'as' => 'tipo_rota.'], function () {
        rotasCrud('TipoRotaController', 'tipo_rota');
    });

    Route::group(['prefix' => 'xml_upload', 'as' => 'xml_upload.'], function () {
        rotasCrud('XmlUploadController', 'xml_upload');
        Route::get('{xml_upload}/detalhes', ['uses' => 'XmlUploadController@detalhes', 'as' => 'detalhes']);
        Route::get('{xml_upload}/print_nota', ['uses' => 'XmlUploadController@print_nota', 'as' => 'print_nota']);

    });
    Route::group(['prefix' => 'pessoas', 'as' => 'pessoas.'], function () {
        rotasCrud('PessoasController', 'pessoas');
    });
    Route::group(['prefix' => 'nota_pessoas', 'as' => 'nota_pessoas.'], function () {
        rotasCrud('NotaPessoasController', 'nota_pessoas');
    });
    Route::group(['prefix' => 'produtos', 'as' => 'produtos.'], function () {
        rotasCrud('ProdutosController', 'produtos');
    });
    Route::group(['prefix' => 'nota_produtos', 'as' => 'nota_produtos.'], function () {
        rotasCrud('NotaProdutosController', 'nota_produtos');
    });
    //[rota]
});
