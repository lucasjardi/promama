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
                    <h4 class="card-title"> Bairros</h4>
                    <button onclick="location.href='{{ url('bairros/novo') }}'" class="btn btn-primary float-right" style="margin-top: -50px;">
                        <i class="now-ui-icons ui-1_simple-add"></i>
                        Adicionar Bairro
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
                                Nome
                            </th>
                            <th>
                                Ações
                            </th>
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
            </div>
        </div>

    </div>

@endsection