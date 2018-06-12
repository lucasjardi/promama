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
      return view('notificacoes.criar', ['idades' => Idade::get()]);
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

      if($request->notificarAgora !== NULL) $request->merge(['semana' => 0]);
    	Notificacao::create($request->all());
      \Session::flash('mensagem_sucesso', 'Notificacao registrada com sucesso!');
        return \Redirect::to('notificar');
    }

}
