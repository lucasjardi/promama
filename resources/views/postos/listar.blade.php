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
                                         <div class="row justify-content-center">
                                            <a href="postos/{{ $posto->posto_id }}/editar" title="Editar" style="text-decoration: none">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            &nbsp;
                                            {!! Form::open(['method' => 'DELETE', 'url' => 'postos/'.$posto->posto_id,'id' => 'form-delete']) !!}
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
                              var x = confirm("Tem certeza que quer excluir a informação?");
                              if (x)
                                return true;
                              else
                                return false;
                          }

                        </script>
                    </div>
                </div>
                {{--<div style="width: 200px; margin: 0 auto; margin-top: 20px;">--}}
                    {{--{{ $postos->links() }}--}}
                {{--</div>--}}
            </div>
        </div>
    </div>
@endsection