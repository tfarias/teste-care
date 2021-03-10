<?php

namespace LaravelMetronic\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use LaravelMetronic\Http\Requests\SalvarCadastroRequest;
use LaravelMetronic\Http\Requests\SalvarImagemRequest;
use LaravelMetronic\Http\Requests\SalvarSenhaRequest;
use LaravelMetronic\Models\SisUsuario;

class UsuarioController extends Controller
{

    private $listagem;

    public function alterarImagem($id)
    {
        if(auth()->user()->tipo_usuario_id==3){
            $id = auth()->user()->id;
        }
        $usuario = SisUsuario::find($id);
        return view('usuario.imagem', compact('usuario'));
    }

    public function salvarImagem($id, SalvarImagemRequest $request)
    {
        if(auth()->user()->tipo_usuario_id==3){
            $id = auth()->user()->id;
        }
        $file = Input::file('photo')->store('photo');

        $input = $request->all();
        $input['photo'] = $file;
        $usuario = SisUsuario::find($id);
        $user = Auth::user();
        $user->update($input);
        $usuario->photo = $file;
        $atualizado = $usuario->save();
        if ($atualizado) {
            $res = ['res' => 1, 'imagem' => $usuario->photo];
            return response()->json($res);
        } else {
            return response()->json(['res' => 'erro']);
        }

        return redirect()->route('usuario.index');
    }

    public function deleteImg($id)
    {
        $res = ['res' => 1];
        return response()->json($res);
    }

    public function alterarSenha($id)
    {
        if(auth()->user()->tipo_usuario_id==3){
            $id = auth()->user()->id;
        }
        $usuario = SisUsuario::find($id);
        return view('usuario.senha', compact('usuario'));
    }

    public function salvarSenha($id, SalvarSenhaRequest $request)
    {
        if(auth()->user()->tipo_usuario_id==3){
            $id = auth()->user()->id;
        }
        $usuario = SisUsuario::find($id);
        $atualizado = $usuario->update($request->all());
        if ($atualizado) {
            $res = ['res' => 1];
            return response()->json($res);
        } else {
            return response()->json(['res' => 'erro']);
        }

    }

    public function alterarCadastro($id, SalvarCadastroRequest $request)
    {
        $atualizado = SisUsuario::find($id)->update($request->all());
        if ($atualizado) {
            flash("Os dados do registro foram alterados com sucesso.", 'success');
        }
        return redirect()->route('usuario.cadastro');
    }


}
