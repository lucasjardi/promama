@extends('layouts.app')

@section('content')
        <div class="col-lg-12">
            <div class="card card-chart">
                <div class="card-header">
                    <h4 class="card-title">Total de <b> {{ $count }} </b> usuários cadastrados no aplicativo</h4>
                </div>
                <div class="card-body">
                	<div class="table-responsive">
                        <table class="table" id="myTable">
                            <thead class=" text-primary">
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Data de Criação</th>
                            </thead>
                            <tbody>

                            @foreach($usuarios as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at }}</td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
@endsection