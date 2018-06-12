<?php

namespace App\Http\Controllers;

use App\Informacao;
use App\Link;
use App\Idade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InformacoesController extends Controller
{
    //
	
    protected $promamaStorageUrl = 'http://promama.cf/storage/';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $infos = Informacao::all();
        return view('informacoes.listar',['infos' => $infos]);
    }

    public function novo()
    {
        return view('informacoes.formulario', ['idades' => Idade::get()]);
    }

    public function salvar(Request $request)
    {   
        $this->validate($request,[
            'informacao_titulo' => 'required',
            'informacao_corpo' => 'required',
            'informacao_foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'informacao_idadeSemanasFim' => 'required'
        ]);


        $informacao = null;

        if($request->hasFile('informacao_foto')){
            $path = $request->file('informacao_foto')->store('informacoes_fotos','public');
            $informacao = new Informacao([
                'informacao_titulo' => $request->informacao_titulo,
                'informacao_corpo' => $request->informacao_corpo,
                'informacao_autor' => $request->informacao_autor,
                'informacao_idadeSemanasInicio' => $request->informacao_idadeSemanasInicio,
                'informacao_idadeSemanasFim' => $request->informacao_idadeSemanasFim,
                'informacao_foto' => $this->promamaStorageUrl . $path
            ]);

        } else {
            $informacao = new Informacao($request->all());
        }

        $errors = array();

        if ( $informacao->save() ) {

                if ( count($request->chave) >= 1 && !(empty($request->chave[0]) && empty($request->valor[0])) ) {
                    for ($i = 0; $i < count($request->chave); $i++) {
        
                        if ( !empty($request->chave[$i]) && !empty($request->valor[$i]) ) {
                            $link = new Link([
                                "informacao" => $informacao->informacao_id, 
                                "titulo" => $request->chave[$i], 
                                "url" => $request->valor[$i]
                            ]);

                            $link->save();
                        } else {
                            array_push($errors, "Erro ao salvar Links");
                        }
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
        return view('informacoes.formulario', ['info' => $info, 'idades' => Idade::get()]);

    }

    public function atualizar($id, Request $request)
    {
        $this->validate($request,[
            'informacao_titulo' => 'required',
            'informacao_corpo' => 'required',
            'informacao_foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $info = Informacao::findOrFail($id);

        $linksAtuais = array();
        foreach ($info->links as $link) {
            $linksAtuais[$link->titulo] = $link->url;
        }
    

        $success = false;

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
                'informacao_idadeSemanasFim' => $request->informacao_idadeSemanasFim,
                'informacao_foto' => $this->promamaStorageUrl . $path
            ])) {
                $success = true;
            }
        } else{ 
            if( $info->update($request->except('informacao_foto')) ) $success = true;
        }



        $errors = array();

        if ($success) {

            
            if ( count($request->chave) >= 1 && !(empty($request->chave[0]) && empty($request->valor[0]))) {
                    for ($i = 0; $i < count($request->chave); $i++) {
        
                        if ( !empty($request->chave[$i]) && !empty($request->valor[$i]) ) {
                            $link = Link::where('titulo',$request->chave[$i])
                                        ->first();

                            if ($link !== null) {
                                $link->update([
                                    'titulo' => $request->chave[$i],
                                    'url' => $request->valor[$i]
                                ]);
                            }
                        } else {
                            array_push($errors, "Erro ao editar Links");
                        }
                    }
            }
        } else {
            array_push($errors, 'Erro ao atualizar Informação, Tente Novamente');
        }

        $linksForm = array_combine($request->chave, $request->valor);
        $toSave = array_diff($linksForm, $linksAtuais);
        if ( !(empty($request->chave[0] && $request->valor[0])) ) {
            if (!empty($toSave) && count($request->chave) > count($linksAtuais)) {
                foreach($toSave as $key => $value) {
        
                        if ( !empty($key) && !empty($value) ) {
                            $link = new Link([
                                "informacao" => $info->informacao_id, 
                                "titulo" => $key, 
                                "url" => $value
                            ]);

                            $link->save();
                        } else {
                            array_push($errors, "Erro ao salvar Links");
                        }
                }
        }
        }


        \Session::flash('mensagem_sucesso', 'Informação atualizada com sucesso!');
        if ( empty($errors) ){
            return \Redirect::to('informacoes/'.$info->informacao_id.'/editar');
        } else {
            return \Redirect::to('informacoes/'.$info->informacao_id.'/editar')->withErrors($errors);
        } 
    }

    public function deletar($id)
    {
        $info = Informacao::findOrFail($id);

        $info->delete();

        \Session::flash('mensagem_sucesso', 'Informação excluída com sucesso!');

        return \Redirect::to('informacoes');
    }

}
