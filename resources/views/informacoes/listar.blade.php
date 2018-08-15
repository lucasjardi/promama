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

                        <table class="table table-hover" id="myTable">
                            <thead>
                            <th>Título</th>
                            <th>Idade</th>
                            {{--<th>Autor</th>--}}
                            <th>Ações</th>
                            </thead>

                            <tbody>
                            @foreach($infos as $info)
                                <tr>
                                    <td onclick="event.preventDefault();
                                                     location.href='informacoes/{{ $info->informacao_id }}/editar';"
                                        style="cursor: pointer;">
                                        {{ substr($info->informacao_titulo,0,55) }}
                                        {{ strlen($info->informacao_titulo) > 55 ? " ..." : "" }}
                                    </td>
                                    <td>{{ App\Idade::where('semanas',$info->informacao_idadeSemanasInicio)->pluck('idade')->first() }}</td>
                                    {{--<td>{{ $info->informacao_autor }}</td>--}}
                                    <td>
                                        <div class="row justify-content-center">
                                            <a href="renderizar/{{ $info->informacao_id }}" title="Visualizar" style="text-decoration: none">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        &nbsp;
                                        <a href="informacoes/{{ $info->informacao_id }}/editar" title="Editar" style="text-decoration: none">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        &nbsp;
                                        {!! Form::open(['method' => 'DELETE', 'url' => 'informacoes/'.$info->informacao_id,'id' => 'form-delete']) !!}
                                            <button onclick="return ConfirmDelete()" style="border: none; background: none; margin: 0; padding: 0;cursor: pointer;"><i class="fa fa-trash" style="color: #a1a1a1;"></i></button>
                                        {!! Form::close() !!}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <script>

                          function ConfirmDelete()
                          {
                              var x = confirm("Tem certeza?");
                              if (x)
                                return true;
                              else
                                return false;
                              }

                        </script>
                    </div>
                </div>
            </div>
        </div>
@endsection