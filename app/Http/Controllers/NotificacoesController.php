<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notificacao;
use App\Idade;

use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use LaravelFCM\Message\Topics;
use FCM;

class NotificacoesController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $notificacoes = Notificacao::orderBy('semana')->orderBy('titulo')->get();
        return view('notificacoes.listar',['notificacoes' => $notificacoes]);
    }

    public function novo()
    {
      return view('notificacoes.criar', ['idades' => Idade::orderBy('semanas')->get()]);
    }

    public function store(Request $request)
    {
      // $notificationBuilder = new PayloadNotificationBuilder($request->titulo);
      // $notificationBuilder->setBody($request->texto)
      //             ->setSound('default');

      // $notification = $notificationBuilder->build();

      // $topic = new Topics();
      // $topic->topic('infos');

      // $topicResponse = FCM::sendToTopic($topic, null, $notification, null);

      // echo $topicResponse->isSuccess() . "<br>";
      // echo $topicResponse->shouldRetry() . "<br>";
      // echo $topicResponse->error() . "<br>";

      if($request->notificacoesAgora !== NULL) $request->merge(['semana' => -1]);
    	Notificacao::create($request->all());
      \Session::flash('mensagem_sucesso', 'Notificacao registrada com sucesso!');
        return \Redirect::to('notificacoes');
    }

    public function editar($id)
    {
        $notificacao = Notificacao::findOrFail($id);

        return view('notificacoes.criar', ['notificacao' => $notificacao, 'idades' => Idade::orderBy('semanas')->get()]);

    }

    public function atualizar($id, Request $request)
    {
        $notificacao = Notificacao::findOrFail($id);

        if($request->notificacoesAgora !== NULL) $request->merge(['semana' => -1]);

        $notificacao->update($request->all());

        \Session::flash('mensagem_sucesso', 'Notificacao atualizada com sucesso!');

        return \Redirect::to('notificacoes/'.$notificacao->id.'/editar');
    }

    public function deletar($id)
    {
        $notificacao = Notificacao::findOrFail($id);

        $notificacao->delete();

        \Session::flash('mensagem_sucesso', 'Notificacao excluída com sucesso!');

        return \Redirect::to('notificacoes');
    }
}
