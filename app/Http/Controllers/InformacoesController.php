<?php

namespace App\Http\Controllers;

use App\Informacao;
use App\Link;
use App\Idade;
use App\DuvidaFrequente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InformacoesController extends Controller
{
    //
	
    protected $promamaStorageUrl = 'http://localhost/promama/public/storage/';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $infos = Informacao::orderBy('informacao_idadeSemanasInicio')->orderBy('informacao_titulo')->get();
        return view('informacoes.listar',['infos' => $infos]);
    }

    public function novo()
    {
        return view('informacoes.formulario', ['idades' => Idade::orderBy('semanas')->get(), 'duvidasFrequentes' => DuvidaFrequente::get()]);
    }

    public function renderizarInformacaoSmartphone($id)
    {
        $info = Informacao::findOrFail($id);
        return view('smartphone.renderInformacao', ['info' => $info]);
    }

    public function salvar(Request $request)
    {   
        $this->validate($request,[
            'informacao_titulo' => 'required',
            'informacao_corpo' => 'required',
            'informacao_foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'informacao_idadeSemanasInicio' => 'required'
        ]);


        $informacao = null;

        if($request->hasFile('informacao_foto')){
            $path = $request->file('informacao_foto')->store('informacoes_fotos','public');
            $informacao = new Informacao([
                'informacao_titulo' => $request->informacao_titulo,
                'informacao_corpo' => $request->informacao_corpo,
                'informacao_autor' => $request->informacao_autor,
                'informacao_idadeSemanasInicio' => $request->informacao_idadeSemanasInicio,
                // 'informacao_idadeSemanasFim' => $request->informacao_idadeSemanasFim,
                'informacao_foto' => $this->promamaStorageUrl . $path
            ]);

        } else {
            $informacao = new Informacao($request->all());
        }

        $errors = array();

        if ( $informacao->save() ) {

                if($request->has("chavesToSave")) {
                    $toSave = array_combine($request->chavesToSave, $request->valoresToSave);

                    $cont = 0;
                    foreach ( $toSave as $titulo => $url ) {
                        
                        if ($titulo != null && $titulo != "" && $url != null && $url != "") {

                            Link::create([
                                'informacao' => $informacao->informacao_id,
                                'titulo' => $titulo,
                                'url' => $url
                            ]);

                        } else {
                            if(!$cont == 0)
                                array_push($errors, 'Alguns Links ficaram em branco os campos e não foram salvos.');
                        }

                        $cont++;
                    }            
                }

                if ( $request->has('duvidas_frequentes') ) {
                    
                    foreach ($request->duvidas_frequentes as $key => $value) {
                        $df = DuvidaFrequente::find($value);

                        Link::create([
                                    'informacao' => $informacao->informacao_id,
                                    'titulo' => $df->titulo,
                                    'url' => "DUVIDAFREQUENTE:{$df->id}"
                                ]);
                    }
                }

        } else {
            array_push($errors, 'Erro ao salvar Informação, Tente Novamente');
        }


        \Session::flash('mensagem_sucesso', 'Informação cadastrada com sucesso!');
        if ( empty($errors) ){
            return \Redirect::to('informacoes/novo');
        } else {
            return \Redirect::to('informacoes/novo')->withErrors($errors);
        }


    }

    public function editar($id)
    {
        $info = Informacao::findOrFail($id);
        return view('informacoes.formulario', ['info' => $info, 'idades' => Idade::orderBy('semanas')->get(), 'duvidasFrequentes' => DuvidaFrequente::get()]);

    }

    public function atualizar($id, Request $request)
    {
        $emBranco = false;
        $success = false;


        $this->validate($request,[
            'informacao_titulo' => 'required',
            'informacao_corpo' => 'required',
            'informacao_foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);    

        $info = Informacao::findOrFail($id);

        if($request->hasFile('informacao_foto')){

            //apagar foto se existe
            if ( $info->informacao_foto !== null ) {

                if (strpos($info->informacao_foto, 'informacoes_fotos') !== false) {
                    
                    $posicaoSubstring = strpos($info->informacao_foto, 'informacoes_fotos');
                    $file = substr( $info->informacao_foto, $posicaoSubstring, strlen($info->informacao_foto) - 1 );
                    
                    Storage::disk('public')->delete($file);

                }
            }

            $path = $request->file('informacao_foto')->store('informacoes_fotos','public');
            if ($info->update([
                'informacao_titulo' => $request->informacao_titulo,
                'informacao_corpo' => $request->informacao_corpo,
                'informacao_autor' => $request->informacao_autor,
                'informacao_idadeSemanasInicio' => $request->informacao_idadeSemanasInicio,
                // 'informacao_idadeSemanasFim' => $request->informacao_idadeSemanasFim,
                'informacao_foto' => $this->promamaStorageUrl . $path
            ])) {
                $success = true;
            }
        } else{ 
            if( $info->update($request->except('informacao_foto')) ) $success = true;
        }


        if ( $request->has('duvidas_frequentes') ) {
                    
            foreach ($request->duvidas_frequentes as $key => $value) {
                $df = DuvidaFrequente::find($value);

                Link::create([
                            'informacao' => $id,
                            'titulo' => $df->titulo,
                            'url' => "DUVIDAFREQUENTE:{$df->id}"
                        ]);
            }
        }

        if($request->has("changed")) {

            $originalinks = array_combine($request->chavesFromBanco, $request->valoresFromBanco);
            $IDS = $request->linkId;

            $links = Link::where('informacao', $id)->get();
        
            $linksDaInformacao = array();
            foreach ($links as $link) {
                $linksDaInformacao[$link->titulo] = $link->url;
            }

            if (! ($originalinks === $linksDaInformacao) ) {

                // percorre as linhas de links e vai atualizando Um pOr Um
                $i = 0;
                foreach ($originalinks as $titulo => $url) {
                    $link = Link::findOrFail($IDS[$i++]);

                    if ($titulo != null && $titulo != "" && $url != null && $url != "") {
                        $link->update([
                            'titulo' => $titulo,
                            'url' => $url
                        ]);
                    } else {
                        $emBranco = true;
                    }
                }

            }

        }

        if($request->has("chavesToSave")) {
            $toSave = array_combine($request->chavesToSave, $request->valoresToSave);

            foreach ( $toSave as $titulo => $url ) {
                
                if ($titulo != null && $titulo != "" && $url != null && $url != "") {

                    Link::create([
                        'informacao' => $id,
                        'titulo' => $titulo,
                        'url' => $url
                    ]);

                } else {
                    $emBranco = true;
                }
            }            
        }

        if($request->has("toDelete")) {
            $toDelete = $request->toDelete;

            foreach ( $toDelete as $idLink ) {
                
                $link = Link::findOrFail($idLink);
                $link->delete();
                
            }
        }


        \Session::flash('mensagem_sucesso', 'Informação atualizada com sucesso!');
        if (! $emBranco ){
            return \Redirect::to('informacoes/'.$id.'/editar');
        } else {
            return \Redirect::to('informacoes/'.$id.'/editar')->withErrors(["Alguns Links não foram salvos com sucesso por causa de campos em branco."]);
        }

    }

    public function deletar($id)
    {
        $info = Informacao::findOrFail($id);

        if ( $info->informacao_foto !== null ) {
            
            if (strpos($info->informacao_foto, 'informacoes_fotos') !== false) {
                    
                    $posicaoSubstring = strpos($info->informacao_foto, 'informacoes_fotos');
                    $file = substr( $info->informacao_foto, $posicaoSubstring, strlen($info->informacao_foto) - 1 );
                    
                    Storage::disk('public')->delete($file);

            }

        }

        $info->delete();

        \Session::flash('mensagem_sucesso', 'Informação excluída com sucesso!');

        return \Redirect::to('informacoes');
    }

}
