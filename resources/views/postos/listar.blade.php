@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Postos de Saúde</h4>
                        <button onclick="location.href='{{ url('postos/novo') }}'" class="btn btn-primary float-right" style="margin-top: -50px;">
                            <i class="now-ui-icons ui-1_simple-add"></i>
                            Adicionar Posto
                        </button>
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
                            <th>Endereço</th>
                            <th>Telefone</th>
                            <th>Bairro</th>
                            <th>Ações</th>
                            </thead>

                            <tbody>
                            @foreach($postos as $posto)
                                <tr>
                                    <td>{{ $posto->posto_nome }}</td>
                                    <td>{{ $posto->posto_endereco }}</td>
                                    <td>{{ $posto->posto_telefone }}</td>
                                    <td>{{ $posto->bairro->bairro_nome }}</td>
                                    <td>
                                        <a href="postos/{{ $posto->posto_id }}/editar" class="btn btn-primary btn-sm">Editar</a>
                                        {!! Form::open(['method' => 'DELETE', 'url' => 'postos/'.$posto->posto_id, 'style' => 'display: inline']) !!}
                                        <button type="submit" class="btn btn-default btn-sm">Remover</button>
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                {{--<div style="width: 200px; margin: 0 auto; margin-top: 20px;">--}}
                    {{--{{ $postos->links() }}--}}
                {{--</div>--}}
            </div>
        </div>
    </div>
@endsection