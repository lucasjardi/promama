@extends('layouts.app')

@section('content')
    <script>
    $(document).ready(function(){
     alert('oi');
    });
    </script>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"> Informações</h4>
                        <button onclick="location.href='{{ url('informacoes/novo') }}'" class="btn btn-primary float-right" style="margin-top: -50px;">
                            <i class="now-ui-icons ui-1_simple-add"></i>
                            Adicionar Informação
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
                            <th>Título</th>
                            <th>Idade</th>
                            {{--<th>Autor</th>--}}
                            <th>Ações</th>
                            </thead>

                            <tbody>
                            @foreach($infos as $info)
                                <tr>
                                    <td>{{ $info->informacao_titulo }}</td>
                                    <td>{{ App\Idade::where('semanas',$info->informacao_idadeSemanasInicio)->pluck('idade')->first() }}</td>
                                    {{--<td>{{ $info->informacao_autor }}</td>--}}
                                    <td>
                                        <!-- <a href="renderizar/{{ $info->informacao_id }}" class="btn btn-primary btn-sm">Ver</a> -->
                                        <a href="informacoes/{{ $info->informacao_id }}/editar" class="btn btn-primary btn-sm">Editar</a>
                                        {!! Form::open(['method' => 'DELETE', 'url' => 'informacoes/'.$info->informacao_id, 'style' => 'display: inline']) !!}
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
@endsection