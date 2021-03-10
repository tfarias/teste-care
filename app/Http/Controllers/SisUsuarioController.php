<?php

namespace LaravelMetronic\Http\Controllers;

use LaravelMetronic\Forms\RelacaoUsuarioAreaForm;
use LaravelMetronic\Forms\RelacaoUsuarioCicloForm;
use LaravelMetronic\Forms\RelacaoUsuarioMunicipioForm;
use LaravelMetronic\Models\AuxCiclo;
use LaravelMetronic\Models\SisUsuario;
use LaravelMetronic\Repositories\SisUsuarioRepository;
use LaravelMetronic\Relatorios\SisUsuarioListagem;
use LaravelMetronic\Forms\SisUsuarioForm;
use Kris\LaravelFormBuilder\Form;
use Illuminate\Http\Request;

class SisUsuarioController extends Controller
{

    private $listagem;
    private $repository;

    public function __construct(SisUsuarioRepository $repository, SisUsuarioListagem $listagem)
    {
        $this->listagem = $listagem;
        $this->repository = $repository;

    }

    /**
     * Lista todos os registros do sistema.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $filtros = request()->all();
        if (isset($filtros['acao']) && $filtros['acao'] == 'imprimir') {
            return $this->listagem->exportar($filtros);
        }
        $dados = $this->listagem->gerar($filtros);
        return view('sis_usuario.index', compact('dados', 'filtros'));
    }

    /**
         * Show the form for creating a new resource.
        *
        * @return \Illuminate\Http\Response
    */
    public function create()
    {
        $form = \FormBuilder::create(SisUsuarioForm::class,[
            'url'=>route('sis_usuario.create.post'),
            'method'=>'POST'
        ]);

        return view('sis_usuario.create',compact('form'));

    }


   /**
       * Store a newly created resource in storage.
       *
       * @param  \Illuminate\Http\Request  $request
       * @return \Illuminate\Http\Response
       */
      public function store(Request $request)
      {
          /** @var Form $form */
          $form = \FormBuilder::create(SisUsuarioForm::class);
          if(!$form->isValid()){
              return redirect()
                  ->back()
                  ->withErrors($form->getErrors())
                  ->withInput();
          }
          $data = $form->getFieldValues();
          $this->repository->create($data);

          flash('Usuário cadastrado com sucesso!!', 'success');

          return redirect()->route('sis_usuario.index');
      }

        /**
        * Show the form for editing the specified resource.
        *
        * @param  \LaravelMetronic\Models\SisUsuario $sis_usuario
        * @return \Illuminate\Http\Response
        */
       public function edit(SisUsuario $sis_usuario)
       {
           $form = \FormBuilder::create(SisUsuarioForm::class,[
               'url'=>route('sis_usuario.edit.post',['sis_usuario' => $sis_usuario->id]),
               'method'=>'PUT',
               'model' => $sis_usuario
           ]);

           return view('sis_usuario.edit',compact('form'));
       }


    /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \LaravelMetronic\Models\User  $sis_usuario
         * @return \Illuminate\Http\Response
         */
        public function update(Request $request, SisUsuario $sis_usuario)
        {
            /** @var Form $form */
            $form = \FormBuilder::create(SisUsuarioForm::class,[
                'data' => ['id' => $sis_usuario->id],
                'model' => $sis_usuario
            ]);
            if(!$form->isValid()){
                return redirect()
                    ->back()
                    ->withErrors($form->getErrors())
                    ->withInput();
            }
            $data = array_except($form->getFieldValues(),['role','password']);
            $this->repository->update($data,$sis_usuario->id);
            flash('Usuário alterado com sucesso!!', 'success');

            return redirect()->route('sis_usuario.index');
        }


     /**
         * Remove the specified resource from storage.
         *
         * @param  \LaravelMetronic\Models\SisUsuario $user
         * @return \Illuminate\Http\Response
         */
        public function destroy($id)
        {
            $this->repository->delete($id);
            flash('Usuário deletado com sucesso!!', 'success');

             return redirect()->route('sis_usuario.index');
        }

    /**
     * Filtra um registro para os campos select2.
     *
     * @param
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function fill()
    {
        $request = request()->all();

        $termo = $request['termo'];
        $size = $request['size'];
        $page = (!isset($request['page']) || $request['page'] < 1) ? 1 : $request['page'];

        if (!isset($termo))
            $termo = '';
        if (!isset($size) || $size < 1)
            $size = 10;

        $find = SisUsuario::where('nome','like','%' . $termo . '%');
        $count = $find->count();
        $ret["more"] = (($size * ($page - 1)) >= (int)$count) ? false : true;
        $ret["total"] = $count;
        $ret["dados"] = array();
        $find->limit($size);
        $find->offset($size * ($page - 1));
        $find->orderBy('nome','asc');
        $result = $find->get();
        foreach ($result as $d) {
            $ret["dados"][] = array('id' => $d->id, 'text' => $d->nome);
        }
        return response()->json($ret);
    }

     /**
         * Filtra um registro pelo id para atualizar os campos select2.
         *
         * @param int @id
         *
         * @return \Illuminate\Http\RedirectResponse
     */
     public function getedit($id)
     {
        $sis_usuario = SisUsuario::find($id);
         $res = ['nome'=>'selecione','id'=>null];
           if(!empty($sis_usuario)){
             $res = ['nome'=>$sis_usuario->nome,'id'=>$sis_usuario->id];
           }
           return response()->json($res);
     }


    public function detalhes(SisUsuario $usuario)
    {
        return view('sis_usuario.detalhe', compact('usuario'));
    }

    public function usuario_area(SisUsuario $usuario)
    {
        $form = \FormBuilder::create(RelacaoUsuarioAreaForm::class,[
            'url'=>route('sis_usuario.post.usuario_area_sincronizar',['usuario'=>$usuario->id]),
            'method'=>'POST',
            'model' => $usuario,
        ]);

        return view('sis_usuario.usuario_area',compact('form'));
    }

    public function usuario_area_sincronizar(Request $request, SisUsuario $usuario)
    {
        $form = \FormBuilder::create(RelacaoUsuarioAreaForm::class);
        if(!$form->isValid()){
            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }

        $data = $form->getFieldValues();
        $this->repository->usuario_area_sincronizar($data,$usuario->id);

        $res = ['res' => 1];
        return response()->json($res);
    }

    public function usuario_ciclo(SisUsuario $usuario)
    {
        $ciclos = AuxCiclo::orderBy('ano','DESC')->get();
        $options=[];
        foreach($ciclos as $c){
            $options[$c->id] = $c->numeros;
        }

        $form = \FormBuilder::create(RelacaoUsuarioCicloForm::class,[
            'url'=>route('sis_usuario.post.usuario_ciclo_sincronizar',['usuario'=>$usuario->id]),
            'method'=>'POST',
            'model' => $usuario,
            'data' => ['options'=>$options]
        ]);

        return view('sis_usuario.usuario_ciclo',compact('form'));
    }

    public function usuario_ciclo_sincronizar(Request $request, SisUsuario $usuario)
    {
        $form = \FormBuilder::create(RelacaoUsuarioCicloForm::class);
        if(!$form->isValid()){
            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }

        $data = $form->getFieldValues();
        $this->repository->usuario_ciclo_sincronizar($data,$usuario->id);

        $res = ['res' => 1];
        return response()->json($res);
    }

    public function usuario_municipio(SisUsuario $usuario)
    {
        $form = \FormBuilder::create(RelacaoUsuarioMunicipioForm::class,[
            'url'=>route('sis_usuario.post.usuario_municipio_sincronizar',['usuario'=>$usuario->id]),
            'method'=>'POST',
            'model' => $usuario,
        ]);

        return view('sis_usuario.usuario_municipio',compact('form'));
    }

    public function usuario_municipio_sincronizar(Request $request, SisUsuario $usuario)
    {
        $form = \FormBuilder::create(RelacaoUsuarioMunicipioForm::class);
        if(!$form->isValid()){
            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }

        $data = $form->getFieldValues();
        $this->repository->usuario_municipio_sincronizar($data,$usuario->id);

        $res = ['res' => 1];
        return response()->json($res);
    }
}
