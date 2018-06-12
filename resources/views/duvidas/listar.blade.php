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
                    <div class="row">

                        <div class="col">
                            <h4 class="card-title"> Dúvidas {{ isset($respondidas) ? "" : "não" }} respondidas</h4>
                        </div>

                        @if(!Request::is('*/respondidas'))
                        <div class="col text-right" style="margin-top: 15px">
                                <a href="{{ url('duvidas/respondidas') }}">
                                    Mostrar Dúvidas Respondidas
                                </a>
                        </div>
                        @endif

                    </div>
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
                                Usuário
                            </th>
                            <th>
                                Mensagem
                            </th>
                            <th>
                                Ações
                            </th>
                            </thead>
                            <tbody>

                            @foreach($duvidas as $duvida)
                                <tr>
                                    <td>{{ $duvida->user->name }}</td>
                                    <td>{{ substr($duvida->duvida_pergunta,0,50) }}
                                        {{ strlen($duvida->duvida_pergunta) > 50 ? " ..." : "" }}
                                    </td>
                                    <td>
                                        @if(isset($respondidas))
                                            <a href="{{ url ('duvidas/'. $duvida->duvida_id . '/editar') }}" class="btn btn-primary btn-sm">Editar Resposta</a>
                                        @else
                                            <a href="{{ url ('duvidas/'. $duvida->duvida_id) }}" class="btn btn-primary btn-sm">Ver</a>
                                        @endif

                                        {!! Form::open(['method' => 'DELETE', 'url' => 'duvidas/'.$duvida->duvida_id, 'style' => 'display: inline']) !!}
                                        <button type="submit" class="btn btn-default btn-sm">Apagar</button>
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