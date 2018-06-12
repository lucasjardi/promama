@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Preencha os campos
                        <a href="{{ url('bairros') }}" class="float-right">Listar Bairros</a>
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
                            {{ Form::model($bairro, ['method' => 'PATCH', 'url' => 'bairros/' . $bairro->bairro_id]) }}
                        @else
                                {!! Form::open(['url' => 'bairros/salvar']) !!}
                        @endif

                        {!! Form::label('bairro_nome','Bairro') !!}
                        {!! Form::input('text','bairro_nome',null, ['class' => 'form-control', 'placeholder' => 'Nome do Bairro']) !!}
                        {!! "<br>" !!}
                        {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection