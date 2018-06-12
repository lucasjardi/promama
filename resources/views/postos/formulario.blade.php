@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Preencha os campos
                        <a href="{{ url('postos') }}" class="float-right">Listar Postos</a>
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

                        @if( Request::is('*/editar'))
                            {{ Form::model($posto, ['method' => 'PATCH', 'url' => 'postos/' . $posto->posto_id]) }}
                        @else
                            {!! Form::open(['url' => 'postos/salvar']) !!}
                        @endif

                            {!! Form::label('posto_nome','Posto') !!}
                            {!! Form::input('text','posto_nome',null, ['class' => 'form-control', 'placeholder' => 'Nome do Posto']) !!}
                            {!! Form::label('posto_endereco','Endereço') !!}
                            {!! Form::input('text','posto_endereco',null, ['class' => 'form-control', 'placeholder' => 'Endereço']) !!}
                            {!! Form::label('posto_telefone','Telefone') !!}
                            {!! Form::input('text','posto_telefone',null, ['class' => 'form-control', 'placeholder' => '(xx) xxxxx-xxxx']) !!}
                            {!! Form::label('posto_bairro','Bairro') !!}
                            {!! Form::select('posto_bairro', $bairros,null, ['class' => 'form-control']) !!}

                            {!! "<br>" !!}
                            {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}

                            {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection