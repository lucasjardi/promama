<?php

namespace App\Http\Controllers;

use App\Link;
use Illuminate\Http\Request;
use App\DuvidaFrequente;

class DuvidaFrequenteController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
//        $duvidasfrequentes = DuvidaFrequente::paginate(5);
        $duvidasfrequentes = DuvidaFrequente::orderBy('updated_at',false)->orderBy('created_at',false)->get();
        return view('duvidasfrequentes.listar',['duvidasfrequentes' => $duvidasfrequentes]);
    }

    public function novo()
    {
        return view('duvidasfrequentes.formulario');
    }

    public function salvar(Request $request)
    {

        $this->validate($request,[
            'titulo' => 'required',
            'texto' => 'required'
        ]);

        $duvidafrequente = new DuvidaFrequente($request->all());

        $errors = array();

        if( $duvidafrequente->save() ){

            if($request->has("chavesToSave")) {
                    $toSave = array_combine($request->chavesToSave, $request->valoresToSave);

                    $cont = 0;
                    foreach ( $toSave as $titulo => $url ) {
                        
                        if ($titulo != null && $titulo != "" && $url != null && $url != "") {

                            Link::create([
                                'duvidafrequente' => $duvidafrequente->id,
                                'titulo' => $titulo,
                                'url' => $url
                            ]);

                        } else {
                            if(!$cont == 0)
                                array_push($errors, 'Alguns Links ficaram em branco e não foram salvos.');
                        }

                        $cont++;
                    }            
            }

            \Session::flash('mensagem_sucesso', 'Dúvida Frequente cadastrada com sucesso!');
            if ( empty($errors) ){
                return \Redirect::to('duvidas-frequentes/novo');
            } else {
                return \Redirect::to('duvidas-frequentes/novo')->withErrors($errors);
            }


        }

    }

    public function editar($id)
    {
        $duvidafrequente = DuvidaFrequente::findOrFail($id);

        return view('duvidasfrequentes.formulario', ['df' => $duvidafrequente]);

    }

    public function atualizar($id, Request $request)
    {
        $this->validate($request,[
            'titulo' => 'required',
            'texto' => 'required'
        ]);

        $duvidafrequente = DuvidaFrequente::findOrFail($id);

        $duvidafrequente->update($request->all());

        $emBranco = false;

        if($request->has("changed")) {

            $originalinks = array_combine($request->chavesFromBanco, $request->valoresFromBanco);
            $IDS = $request->linkId;

            $links = Link::where('duvidafrequente', $id)->get();
        
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
                        'duvidafrequente' => $id,
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


        \Session::flash('mensagem_sucesso', 'Dúvida Frequente atualizada com sucesso!');
        if (! $emBranco ){
            return \Redirect::to('duvidas-frequentes/'.$id.'/editar');
        } else {
            return \Redirect::to('duvidas-frequentes/'.$id.'/editar')->withErrors(["Alguns Links não foram salvos com sucesso por causa de campos em branco."]);
        }


    }

    public function deletar($id)
    {
        $duvidafrequente = DuvidaFrequente::findOrFail($id);

        $duvidafrequente->delete();

        \Session::flash('mensagem_sucesso', 'Duvida excluído com sucesso!');

        return \Redirect::to('duvidas-frequentes');
    }

}
