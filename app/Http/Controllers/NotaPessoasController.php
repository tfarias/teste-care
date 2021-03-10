<?php

namespace LaravelMetronic\Http\Controllers;

use LaravelMetronic\Models\NotaPessoas;
use LaravelMetronic\Repositories\NotaPessoasRepository;
use LaravelMetronic\Relatorios\NotaPessoasListagem;
use LaravelMetronic\Forms\NotaPessoasForm;
use Kris\LaravelFormBuilder\Form;
use Illuminate\Http\Request;

class NotaPessoasController extends Controller
{

    private $listagem;
    private $repository;

    public function __construct(NotaPessoasRepository $repository, NotaPessoasListagem $listagem)
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
        return view('nota_pessoas.index', compact('dados', 'filtros'));
    }

    /**
         * Show the form for creating a new resource.
        *
        * @return \Illuminate\Http\Response
    */
    public function create()
    {
        $form = \FormBuilder::create(NotaPessoasForm::class,[
            'url'=>route('nota_pessoas.create.post'),
            'method'=>'POST'
        ]);

        return view('nota_pessoas.create',compact('form'));

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
          $form = \FormBuilder::create(NotaPessoasForm::class);
          if(!$form->isValid()){
              return redirect()
                  ->back()
                  ->withErrors($form->getErrors())
                  ->withInput();
          }
          $data = $form->getFieldValues();
          $this->repository->create($data);

            flash('Nota Pessoas criado com sucesso!', 'success');

          return redirect()->route('nota_pessoas.index');
      }

        /**
        * Show the form for editing the specified resource.
        *
        * @param  \LaravelMetronic\Models\NotaPessoas $nota_pessoas
        * @return \Illuminate\Http\Response
        */
       public function edit(NotaPessoas $nota_pessoas)
       {
           $form = \FormBuilder::create(NotaPessoasForm::class,[
               'url'=>route('nota_pessoas.edit.post',['nota_pessoas' => $nota_pessoas->id]),
               'method'=>'PUT',
               'model' => $nota_pessoas
           ]);

           return view('nota_pessoas.edit',compact('form'));
       }


    /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \LaravelMetronic\Models\User  $nota_pessoas
         * @return \Illuminate\Http\Response
         */
        public function update(Request $request, NotaPessoas $nota_pessoas)
        {
            /** @var Form $form */
            $form = \FormBuilder::create(NotaPessoasForm::class,[
                'data' => ['id' => $nota_pessoas->id],
                'model' => $nota_pessoas
            ]);
            if(!$form->isValid()){
                return redirect()
                    ->back()
                    ->withErrors($form->getErrors())
                    ->withInput();
            }
            $data = $form->getFieldValues();
            $this->repository->update($data,$nota_pessoas->id);
            flash('Nota Pessoas alterado com sucesso!!', 'success');
            return redirect()->route('nota_pessoas.index');
        }


     /**
         * Remove the specified resource from storage.
         *
         * @param  \LaravelMetronic\Models\NotaPessoas $user
         * @return \Illuminate\Http\Response
         */
        public function destroy($id)
        {
            $this->repository->delete($id);
            flash('Nota Pessoas deletado com sucesso!!', 'success');

             return redirect()->route('nota_pessoas.index');
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

        $find = NotaPessoas::where('descricao','like','%' . $termo . '%');
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
        $nota_pessoas = NotaPessoas::find($id);
         $res = ['descicao'=>'selecione','id'=>null];
           if(!empty($nota_pessoas)){
             $res = ['descricao'=>$nota_pessoas->descricao,'id'=>$nota_pessoas->id];
           }
           return response()->json($res);
     }
}
