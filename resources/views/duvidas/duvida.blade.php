@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Dúvida de {{ $duvida->user->name }} em {{ $duvida->created_at }}</h4>
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
                        <p>
                            {{ $duvida->duvida_pergunta }}
                        </p>

                        @if( Request::is('*/editar'))
                            {{ Form::model($duvida, ['method' => 'PATCH', 'url' => 'duvidas/' . $duvida->duvida_id]) }}
                        @else
                            {!! Form::open(['url' => 'duvidas/responderDuvida']) !!}
                        @endif
                        {!! Form::input('hidden','duvida_id', $duvida->duvida_id) !!}


                        {!! Form::label('duvida_resposta','Responder dúvida') !!}
                        {!! Form::textarea('duvida_resposta',null,['class' => 'form-control']) !!}

                        {!! "<div class= 'checkbox'>" !!}
                        {!! "<label>" !!}

                        <?php 
                        $checked = null; 
                        if(isset($duvida)) 
                            if($duvida->duvida_paraTodos == 1) 
                                $checked = 'checked';
                        ?>
                        
                        {!! Form::input('checkbox','duvida_paraTodos',null,[$checked]) !!}
                        {!! "Responder Dúvida Para Todos" !!}
                        {!! "</label>" !!}
                        {!! "</div>" !!}


                        {!! Form::submit(Request::is('*/editar') ? 'Editar' : 'Responder', ['class' => 'btn btn-primary']) !!}

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
