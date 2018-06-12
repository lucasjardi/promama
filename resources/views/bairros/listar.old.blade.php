@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                {{--Search--}}
                {!! Form::open(['method'=>'POST','url'=>'bairros/pesquisa'])  !!}
                {!! Form::input('text','search',null,['class' => 'form-control', 'placeholder' => 'Pesquisar...']) !!}
                {!! Form::close() !!}

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <br>
                <div class="card">
                    <div class="card-header">
                        Bairros
                        <a href="{{ url('bairros/novo') }}" class="float-right">Adicionar Bairro</a>
                    </div>

                    <div class="card-body">
                        @if( Session::has('mensagem_sucesso') )
                            <div class="alert alert-success alert-dismissible fade show">
                                {{ Session::get('mensagem_sucesso') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <table class="table" id="myTable">
                            <thead>
                                <th>Nome</th>
                                <th>Ações</th>
                            </thead>

                            <tbody>
                            @foreach($bairros as $bairro)
                                <tr>
                                    <td>{{ $bairro->bairro_nome }}</td>
                                    <td>
                                        <a href="bairros/{{ $bairro->bairro_id }}/editar" class="btn btn-primary btn-sm">Editar</a>
                                        {!! Form::open(['method' => 'DELETE', 'url' => 'bairros/'.$bairro->bairro_id, 'style' => 'display: inline']) !!}
                                        <button type="submit" class="btn btn-default btn-sm">Remover</button>
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div style="width: 200px; margin: 0 auto; margin-top: 20px;">
                    {{ Request::is('bairros/pesquisa') ? '' : $bairros->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection