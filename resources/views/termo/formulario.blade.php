@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Editar Termos de Uso
                    </div>

                    <div class="card-body" style="font-size: 18px">
                        @if( Session::has('mensagem_sucesso') )
                            <div class="alert alert-success alert-dismissible fade show">
                                {{ Session::get('mensagem_sucesso') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        {{ Form::model($termos, ['method' => 'PATCH', 'url' => 'termos/atualizar']) }}
                        
                        
                        {!! Form::label('titulo','Título') !!}
                        {!! Form::input('text','titulo',null, ['class' => 'form-control', 'placeholder' => 'Título dos Termos']) !!}
                        {!! Form::label('texto','Texto') !!}
                        {!! Form::textarea('texto',null, ['class' => 'form-control', 'placeholder' => 'Texto da notificação']) !!}

                        
                        {!! Form::submit('Enviar', ['class' => 'btn btn-primary']) !!}

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection