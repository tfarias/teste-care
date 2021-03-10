<?php

namespace LaravelMetronic\Http\Controllers;

use LaravelMetronic\Models\AuxTipoUsuario;
use LaravelMetronic\Repositories\AuxTipoUsuarioRepository;
use LaravelMetronic\Relatorios\AuxTipoUsuarioListagem;
use LaravelMetronic\Forms\AuxTipoUsuarioForm;
use Kris\LaravelFormBuilder\Form;
use Illuminate\Http\Request;

class AuxTipoUsuarioController extends Controller
{

    private $listagem;
    private $repository;

    public function __construct(AuxTipoUsuarioRepository $repository, AuxTipoUsuarioListagem $listagem)
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
        return view('aux_tipo_usuario.index', compact('dados', 'filtros'));
    }

    /**
         * Show the form for creating a new resource.
        *
        * @return \Illuminate\Http\Response
    */
    public function create()
    {
        $form = \FormBuilder::create(AuxTipoUsuarioForm::class,[
            'url'=>route('aux_tipo_usuario.create.post'),
            'method'=>'POST'
        ]);

        return view('aux_tipo_usuario.create',compact('form'));

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
          $form = \FormBuilder::create(AuxTipoUsuarioForm::class);
          if(!$form->isValid()){
              return redirect()
                  ->back()
                  ->withErrors($form->getErrors())
                  ->withInput();
          }
          $data = $form->getFieldValues();
          $this->repository->create($data);
          flash('Tipo de usuario criado com sucesso!!', 'success');

          return redirect()->route('aux_tipo_usuario.index');
      }

        /**
        * Show the form for editing the specified resource.
        *
        * @param  \LaravelMetronic\Models\AuxTipoUsuario $aux_tipo_usuario
        * @return \Illuminate\Http\Response
        */
       public function edit(AuxTipoUsuario $aux_tipo_usuario)
       {
           $form = \FormBuilder::create(AuxTipoUsuarioForm::class,[
               'url'=>route('aux_tipo_usuario.edit.post',['aux_tipo_usuario' => $aux_tipo_usuario->id]),
               'method'=>'PUT',
               'model' => $aux_tipo_usuario
           ]);

           return view('aux_tipo_usuario.edit',compact('form'));
       }


    /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \LaravelMetronic\Models\User  $aux_tipo_usuario
         * @return \Illuminate\Http\Response
         */
        public function update(Request $request, $id)
        {
            /** @var Form $form */
            $form = \FormBuilder::create(AuxTipoUsuarioForm::class,[
                'data' => ['id' => $id]
            ]);
            if(!$form->isValid()){
                return redirect()
                    ->back()
                    ->withErrors($form->getErrors())
                    ->withInput();
            }
            $data = array_except($form->getFieldValues(),['role','password']);
            $this->repository->update($data,$id);
            flash('Tipo de usuario alterado com sucesso!!', 'success');

            return redirect()->route('aux_tipo_usuario.index');
        }


     /**
         * Remove the specified resource from storage.
         *
         * @param  \LaravelMetronic\Models\AuxTipoUsuario $user
         * @return \Illuminate\Http\Response
         */
        public function destroy($id)
        {
            $this->repository->delete($id);
            flash('Tipo de usuario deletado com sucesso!!', 'success');

             return redirect()->route('aux_tipo_usuario.index');
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

        $find = AuxTipoUsuario::where('descricao', 'like', '%' . $termo . '%');
        $count = $find->count();
        $ret["more"] = (($size * ($page - 1)) >= (int)$count) ? false : true;
        $ret["total"] = $count;
        $ret["dados"] = array();
        $find->limit($size);
        $find->offset($size * ($page - 1));
        $find->orderBy('descricao','asc');
        $result = $find->get();
        foreach ($result as $d) {
            $ret["dados"][] = array('id' => $d->id, 'text' => $d->descricao);
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
        $aux_tipo_usuario = AuxTipoUsuario::find($id);
         $res = ['descricao'=>'selecione','id'=>null];
           if(!empty($aux_tipo_usuario)){
             $res = ['descricao'=>$aux_tipo_usuario->descricao,'id'=>$aux_tipo_usuario->id];
           }
           return response()->json($res);
     }
}
