<?php

namespace App\Http\Controllers;

use App\Bairro;
use App\Duvida;
use App\Informacao;
use App\Posto;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        \Carbon\Carbon::setLocale('pt_BR');

        $duvidas = Duvida::with('usuario')->whereNull('resposta')->get();

        $qtd= count($duvidas);

        $dataDaUltimaDuvida = Duvida::orderBy('created_at',false)->pluck('created_at')->first();

        $ultimasInfos = Informacao::orderBy('created_at','desc')->take(5)->get();

        return view('home', ['duvidas' => $qtd, 'infos' => $ultimasInfos, 'ultimaDuvidaData' => $dataDaUltimaDuvida]);
    }

}
