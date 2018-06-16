@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Preencha os campos
                        <a href="{{ url('duvidas-frequentes') }}" class="float-right">Listar Dúvidas Frequentes</a>
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
                            {{ Form::model($df, ['method' => 'PATCH', 'url' => 'duvidas-frequentes/' . $df->id]) }}
                        @else
                                {!! Form::open(['url' => 'duvidas-frequentes/salvar']) !!}
                        @endif

                        {!! Form::label('titulo','Título') !!}
                        {!! Form::input('text','titulo',null, ['class' => 'form-control', 'placeholder' => 'Título do Texto']) !!}
                        {!! Form::label('texto','Texto') !!}
                        {!! Form::textarea('texto',null, ['class' => 'form-control', 'placeholder' => 'Corpo do Texto']) !!}
                        {!! "<br>" !!}
                        {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection