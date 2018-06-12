@extends('layouts.app')

@section('content')
    <div class="row">

        @if($duvidas != 0)
        <div class="col-lg-4">
            <div class="card card-chart">
                <div class="card-header">
                    <h5 class="card-category">Dúvidas e Respostas</h5>
                    <h4 class="card-title"><b>{{ $duvidas }}</b> novas dúvidas</h4>
                </div>
                <div class="card-body">
                    <a href="{{ url('/duvidas') }}">Ir até as dúvidas</a>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="now-ui-icons arrows-1_refresh-69"></i> Poucos segundos atrás
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if($infos != "[]")
        <div class="col-lg-8">
            <div class="card card-chart">
                <div class="card-header">
                    <h5 class="card-category">Informações</h5>
                    <a href="{{ url('/informacoes') }}" class="card-category float-right" style="margin-top: -30px"><i class="fas fa-external-link-alt" title="Ir até Informações"></i></a>
                    <h4 class="card-title">Últimas informações postadas</h4>
                </div>
                <div class="card-body">
                    

                <table class="table table-hover">
                  <tbody>
                    @foreach($infos as $info)
                                <tr>
                                    <td>{{ (new DateTime($info->created_at))->format('d/m/Y') }}</td>
                                    <td>{{ $info->informacao_titulo }}</td>
                                </tr>
                    @endforeach
                  </tbody>
                </table>


                </div>
            </div>
        </div>
        @endif

    </div>
@endsection
