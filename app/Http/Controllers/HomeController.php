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
       $duvidas = Duvida::with('user')->whereNull('resposta')->get();

        $qtd= count($duvidas);

        $ultimasInfos = Informacao::orderBy('created_at','desc')->take(5)->get();

        return view('home', ['duvidas' => $qtd, 'infos' => $ultimasInfos]);
    }
    
}
