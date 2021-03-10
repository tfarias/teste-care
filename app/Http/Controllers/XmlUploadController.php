<?php

namespace LaravelMetronic\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use LaravelMetronic\Helpers\SearchArray;
use LaravelMetronic\Helpers\XmlParser;
use LaravelMetronic\Models\XmlUpload;
use LaravelMetronic\Repositories\PessoasRepository;
use LaravelMetronic\Repositories\ProdutosRepository;
use LaravelMetronic\Repositories\XmlUploadRepository;
use LaravelMetronic\Relatorios\XmlUploadListagem;
use LaravelMetronic\Forms\XmlUploadForm;
use Kris\LaravelFormBuilder\Form;
use Illuminate\Http\Request;

use NFePHP;
use NFePHP\DA\NFe\Danfce;
use NFePHP\DA\NFe\Danfe;
use NFePHP\DA\NFe\DanfeSimples;

class XmlUploadController extends Controller
{

    private $listagem;
    private $repository;
    private $search;
    private $parser;
    private $pessoasRepository;
    private $produtosRepository;

    public function __construct(
        XmlUploadRepository $repository,
        XmlUploadListagem $listagem,
        PessoasRepository $pessoasRepository,
        ProdutosRepository $produtosRepository
    )
    {
        $this->listagem = $listagem;
        $this->repository = $repository;
        $this->pessoasRepository = $pessoasRepository;
        $this->produtosRepository = $produtosRepository;

        $this->search = new SearchArray();
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
        return view('xml_upload.index', compact('dados', 'filtros'));
    }

    /**
         * Show the form for creating a new resource.
        *
        * @return \Illuminate\Http\Response
    */
    public function create()
    {
        $form = \FormBuilder::create(XmlUploadForm::class,[
            'url'=>route('xml_upload.create.post'),
            'method'=>'POST'
        ]);

        return view('xml_upload.create',compact('form'));

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
          $form = \FormBuilder::create(XmlUploadForm::class);

          if(!$form->isValid()){
              return redirect()
                  ->back()
                  ->withErrors($form->getErrors())
                  ->withInput();
          }

          try {
              $file = file_get_contents($request->file('path'));
              $data = XmlParser::xmlToObj($file);

              [$emitente, $destinatario] = $this->cadastro_pessoas($data);
              $pess = [];
              $pess[$emitente->id] = ['tipo' => 'E'];
              $pess[$destinatario->id] = ['tipo' => 'C'];

              $prods = $this->cadastro_produtos($data);
              $res_data = $data->nfeProc->NFe->infNFe->ide;
              $vl_nota = $data->nfeProc->NFe->infNFe->total->ICMSTot->vNF;
              $path = Input::file('path')->store('notas');
              $upload = $this->repository->create([
                  'cuf' => $res_data->cUF,
                  'cnf' => $res_data->cNF,
                  'natop' => $res_data->natOp,
                  'mod' => $res_data->mod,
                  'serie' => $res_data->serie,
                  'numero_nota' => $res_data->nNF,
                  'data_nota' => Carbon::parse($res_data->dhEmi)->format('Y-m-d H:i:s'),
                  'valor_total' => floatval($vl_nota),
                  'path' => $path
              ]);

              /* Cadastro de pessoas */
              $this->repository->sincronizar_pessoas(['pessoas' => $pess], $upload->id);
              $this->repository->sincronizar_produtos(['produtos' => $prods], $upload->id);
              flash('Upload XML realizado com sucesso!', 'success');
          }catch (\Exception $e){
              flash($e->getMessage(), 'danger');
              return redirect()->back();
          }

          return redirect()->route('xml_upload.index');
      }

      public function cadastro_pessoas($dados){
          $dados_emitente = $dados->nfeProc->NFe->infNFe->emit;
            if(!empty($dados_emitente)){
               $emit_cadastrado = $this->pessoasRepository->findByField('cpf_cnpj',removerMascara($dados_emitente->CNPJ))->first();
               if(empty($emit_cadastrado)){
                   $emit_cadastrado = $this->pessoasRepository->create([
                       'nome' => $dados_emitente->xNome,
                       'nome_fantasia' => $dados_emitente->xFant,
                       'cpf_cnpj' => removerMascara($dados_emitente->CNPJ),
                       'logradouro' => $dados_emitente->enderEmit->xLgr,
                       'numero' => $dados_emitente->enderEmit->nro,
                       'bairro' => $dados_emitente->enderEmit->xBairro,
                       'cod_municipio' => $dados_emitente->enderEmit->cMun,
                       'municipio' => $dados_emitente->enderEmit->xMun,
                       'uf' => $dados_emitente->enderEmit->UF,
                       'cep' => $dados_emitente->enderEmit->CEP,
                       'codigo_pais' => $dados_emitente->enderEmit->cPais,
                       'inscricao_estadual' => @$dados_emitente->IE,
                       'inscricao_municipal' => @$dados_emitente->IM,
                       'crt' => @$dados_emitente->CRT
                   ]);
               }
            }

          $dados_destinatadio = $dados->nfeProc->NFe->infNFe->dest;

          if(!empty($dados_destinatadio->CPF)){
            $dest_cadastrado = $this->pessoasRepository->findByField('cpf_cnpj',removerMascara($dados_destinatadio->CPF))->first();
          }else{
              $dest_cadastrado = $this->pessoasRepository->findByField('cpf_cnpj',removerMascara($dados_destinatadio->CNPJ))->first();
          }

          if(empty($dest_cadastrado)){
              $dest_cadastrado = $this->pessoasRepository->create([
                  'nome' => $dados_destinatadio->xNome,
                  'nome_fantasia' => @$dados_destinatadio->xFant ,
                  'cpf_cnpj' => !empty($dados_destinatadio->CPF) ? removerMascara($dados_destinatadio->CPF) :  removerMascara($dados_destinatadio->CNPJ),
                  'logradouro' => $dados_destinatadio->enderDest->xLgr,
                  'numero' => @$dados_destinatadio->enderDest->nro,
                  'complemento' => @$dados_destinatadio->enderDest->xCpl,
                  'bairro' => $dados_destinatadio->enderDest->xBairro,
                  'cod_municipio' => $dados_destinatadio->enderDest->cMun,
                  'municipio' => $dados_destinatadio->enderDest->xMun,
                  'uf' => $dados_destinatadio->enderDest->UF,
                  'cep' => $dados_destinatadio->enderDest->CEP,
                  'codigo_pais' => $dados_destinatadio->enderDest->cPais,
                  'email' => @$dados_destinatadio->email
              ]);
          }

          return [$emit_cadastrado,$dest_cadastrado];

      }

      public function cadastro_produtos($data)
      {
          $det = $data->nfeProc->NFe->infNFe->det;

          $result_prod = [];
            if(empty($det->prod)) {
                foreach ($det as $item) {
                    $prod_cadastrado = $this->produtosRepository->findByField('codigo_produto', $item->prod->cProd)->first();
                    if (empty($prod_cadastrado)) {
                        $prod_cadastrado = $this->produtosRepository->create([
                            'codigo_produto' => $item->prod->cProd,
                            'descricao' => $item->prod->xProd,
                        ]);
                    }

                    $result_prod[$prod_cadastrado->id] = [
                        'valor' => floatval($item->prod->vProd),
                        'quantidade' => (int)$item->prod->qCom,
                    ];
                }
            }else{
                $prod_cadastrado = $this->produtosRepository->findByField('codigo_produto', $det->prod->cProd)->first();
                if (empty($prod_cadastrado)) {
                    $prod_cadastrado = $this->produtosRepository->create([
                        'codigo_produto' => $det->prod->cProd,
                        'descricao' => $det->prod->xProd,
                    ]);
                }

                $result_prod[$prod_cadastrado->id] = [
                    'valor' => floatval($det->prod->vProd),
                    'quantidade' => (int)$det->prod->qCom,
                ];
            }

            return $result_prod;

      }

        /**
        * Show the form for editing the specified resource.
        *
        * @param  \LaravelMetronic\Models\XmlUpload $xml_upload
        * @return \Illuminate\Http\Response
        */
       public function detalhes(XmlUpload $xml_upload)
       {
           return view('xml_upload.detalhes',compact('xml_upload'));
       }


    /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \LaravelMetronic\Models\User  $xml_upload
         * @return \Illuminate\Http\Response
         */
        public function update(Request $request, XmlUpload $xml_upload)
        {
            /** @var Form $form */
            $form = \FormBuilder::create(XmlUploadForm::class,[
                'data' => ['id' => $xml_upload->id],
                'model' => $xml_upload
            ]);
            if(!$form->isValid()){
                return redirect()
                    ->back()
                    ->withErrors($form->getErrors())
                    ->withInput();
            }
            $data = $form->getFieldValues();
            $this->repository->update($data,$xml_upload->id);
            flash('Upload XML alterado com sucesso!!', 'success');
            return redirect()->route('xml_upload.index');
        }


     /**
         * Remove the specified resource from storage.
         *
         * @param  \LaravelMetronic\Models\XmlUpload $user
         * @return \Illuminate\Http\Response
         */
        public function destroy($id)
        {
            $this->repository->delete($id);
            flash('Upload XML deletado com sucesso!!', 'success');

             return redirect()->route('xml_upload.index');
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

        $find = XmlUpload::where('descricao','like','%' . $termo . '%');
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
        $xml_upload = XmlUpload::find($id);
         $res = ['descicao'=>'selecione','id'=>null];
           if(!empty($xml_upload)){
             $res = ['descricao'=>$xml_upload->descricao,'id'=>$xml_upload->id];
           }
           return response()->json($res);
     }


    public function print_nota( XmlUpload $xml_upload)
    {
        $docxml = file_get_contents(storage_path('app/public/'.$xml_upload->path));
        try {
            $danfe = new Danfe($docxml);
            $danfe->debugMode(true);
            $danfe->creditsIntegratorFooter('WEBNFe Sistemas - http://www.webenf.com.br');
            $pdf = $danfe->render();
            header('Content-Type: application/pdf');
            echo $pdf;
        } catch (\Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }
}
