@extends('layouts.app')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"> Notificações </h4>
                    <button onclick="location.href='{{ url('notificacoes/novo') }}'" class="btn btn-primary float-right" style="margin-top: -50px;">
                        <i class="now-ui-icons ui-1_simple-add"></i>
                        Adicionar Notificação
                    </button>
                </div>

                @if( Session::has('mensagem_sucesso') )
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ Session::get('mensagem_sucesso') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="myTable">
                            <thead class=" text-primary">
                            <th>
                                Título
                            </th>
                            <th>
                                Texto
                            </th>
                            <th>
                                Idade
                            </th>
                            <th>
                                Ações
                            </th>
                            </thead>
                            <tbody>

                            @foreach($notificacoes as $notificacao)
                                <tr>
                                    <td>{{ substr($notificacao->titulo,0,20) }}
                                        {{ strlen($notificacao->titulo) > 20 ? " ..." : "" }}</td>
                                    <td>{{ substr($notificacao->texto,0,20) }}
                                        {{ strlen($notificacao->texto) > 20 ? " ..." : "" }}</td>
                                    <td>{{ App\Idade::where('semanas',$notificacao->semana)->pluck('idade')->first() }}</td>
                                    <td>
                                        <a href="notificacoes/{{ $notificacao->id }}/editar" class="btn btn-primary btn-sm">Editar</a>
                                        {!! Form::open(['method' => 'DELETE', 'url' => 'notificacoes/'.$notificacao->id, 'style' => 'display: inline']) !!}
                                        <button type="submit" class="btn btn-default btn-sm">Remover</button>
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection