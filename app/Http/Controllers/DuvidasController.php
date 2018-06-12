<?php

namespace App\Http\Controllers;

use App\Duvida;
use Illuminate\Http\Request;

class DuvidasController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $duvidas = Duvida::with('user')->whereNull('duvida_resposta')->get();

        return view('duvidas.listar',['duvidas' => $duvidas]);
    }

    public function read($duvidaId)
    {
        $duvida = Duvida::with('user')->findOrFail($duvidaId);
        // $respostaDaDuvida = Resposta::where('resposta_duvida', "=", "$duvidaId")->first();

        // return view('duvidas.duvida',['duvida' => $duvida, 'resposta' => $respostaDaDuvida]);
        return view('duvidas.duvida',['duvida' => $duvida]);
    }

    public function atualizar(Request $request,$duvidaId)
    {
        if($request->duvida_paraTodos === "on" ) $request->duvida_paraTodos = 1;
        else $request->duvida_paraTodos = 0;

        $duvida = Duvida::findOrFail($duvidaId);
        $duvida->duvida_resposta = $request->duvida_resposta;
        $duvida->duvida_paraTodos = $request->duvida_paraTodos;
        $duvida->update();

        \Session::flash('mensagem_sucesso', 'Dúvida atualizada com sucesso!');

        return \Redirect::to('/duvidas/respondidas');

    }

    public function responderDuvida(Request $request)
    {
        if($request->duvida_paraTodos === "on" ) $request->duvida_paraTodos = 1;
        else $request->duvida_paraTodos = 0;

        $duvida = Duvida::find($request->duvida_id);
        $duvida->duvida_resposta = $request->duvida_resposta;
        $duvida->duvida_paraTodos = $request->duvida_paraTodos;
        $duvida->update();

        \Session::flash('mensagem_sucesso', 'Dúvida respondida com sucesso!');

        return \Redirect::to('/duvidas'); // fazer retornar para lista de duvidas
    }

    public function renderizaRespondidas()
    {
        $duvidas = Duvida::with('user')->whereNotNull('duvida_resposta')->get();

        return view('duvidas.listar', ['duvidas' => $duvidas, 'respondidas' => true]);
    }
}
