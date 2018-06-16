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
                    <h4 class="card-title"> Dúvidas Frequentes </h4>
                    <button onclick="location.href='{{ url('duvidas-frequentes/novo') }}'" class="btn btn-primary float-right" style="margin-top: -50px;">
                        <i class="now-ui-icons ui-1_simple-add"></i>
                        Adicionar Dúvida Frequente
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
                                Ações
                            </th>
                            </thead>
                            <tbody>

                            @foreach($duvidasfrequentes as $df)
                                <tr>
                                    <td>{{ substr($df->titulo,0,50) }}
                                        {{ strlen($df->titulo) > 50 ? " ..." : "" }}</td>
                                    <td>{{ substr($df->texto,0,50) }}
                                        {{ strlen($df->texto) > 50 ? " ..." : "" }}</td>
                                    <td>
                                        <a href="duvidas-frequentes/{{ $df->id }}/editar" class="btn btn-primary btn-sm">Editar</a>
                                        {!! Form::open(['method' => 'DELETE', 'url' => 'duvidas-frequentes/'.$df->id, 'style' => 'display: inline']) !!}
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