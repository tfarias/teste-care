<?php

namespace LaravelMetronic\Http\Controllers;

use LaravelMetronic\Models\Pessoas;
use LaravelMetronic\Repositories\PessoasRepository;
use LaravelMetronic\Relatorios\PessoasListagem;
use LaravelMetronic\Forms\PessoasForm;
use Kris\LaravelFormBuilder\Form;
use Illuminate\Http\Request;

class PessoasController extends Controller
{

    private $listagem;
    private $repository;

    public function __construct(PessoasRepository $repository, PessoasListagem $listagem)
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
        return view('pessoas.index', compact('dados', 'filtros'));
    }

    /**
         * Show the form for creating a new resource.
        *
        * @return \Illuminate\Http\Response
    */
    public function create()
    {
        $form = \FormBuilder::create(PessoasForm::class,[
            'url'=>route('pessoas.create.post'),
            'method'=>'POST'
        ]);

        return view('pessoas.create',compact('form'));

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
          $form = \FormBuilder::create(PessoasForm::class);
          if(!$form->isValid()){
              return redirect()
                  ->back()
                  ->withErrors($form->getErrors())
                  ->withInput();
          }
          $data = $form->getFieldValues();
          $this->repository->create($data);

            flash('Pessoas criado com sucesso!', 'success');

          return redirect()->route('pessoas.index');
      }

        /**
        * Show the form for editing the specified resource.
        *
        * @param  \LaravelMetronic\Models\Pessoas $pessoas
        * @return \Illuminate\Http\Response
        */
       public function edit(Pessoas $pessoas)
       {
           $form = \FormBuilder::create(PessoasForm::class,[
               'url'=>route('pessoas.edit.post',['pessoas' => $pessoas->id]),
               'method'=>'PUT',
               'model' => $pessoas
           ]);

           return view('pessoas.edit',compact('form'));
       }


    /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \LaravelMetronic\Models\User  $pessoas
         * @return \Illuminate\Http\Response
         */
        public function update(Request $request, Pessoas $pessoas)
        {
            /** @var Form $form */
            $form = \FormBuilder::create(PessoasForm::class,[
                'data' => ['id' => $pessoas->id],
                'model' => $pessoas
            ]);
            if(!$form->isValid()){
                return redirect()
                    ->back()
                    ->withErrors($form->getErrors())
                    ->withInput();
            }
            $data = $form->getFieldValues();
            $this->repository->update($data,$pessoas->id);
            flash('Pessoas alterado com sucesso!!', 'success');
            return redirect()->route('pessoas.index');
        }


     /**
         * Remove the specified resource from storage.
         *
         * @param  \LaravelMetronic\Models\Pessoas $user
         * @return \Illuminate\Http\Response
         */
        public function destroy($id)
        {
            $this->repository->delete($id);
            flash('Pessoas deletado com sucesso!!', 'success');

             return redirect()->route('pessoas.index');
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

        $find = Pessoas::where('descricao','like','%' . $termo . '%');
	    if(!empty($request['campo'])){
            $find->where($request['campo'],'=',$request['auxiliar']);
        }
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
        $pessoas = Pessoas::find($id);
         $res = ['descicao'=>'selecione','id'=>null];
           if(!empty($pessoas)){
             $res = ['descricao'=>$pessoas->descricao,'id'=>$pessoas->id];
           }
           return response()->json($res);
     }
}
