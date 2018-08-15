@extends('layouts.app')

@section('content')
        <div class="col-lg-12">
            <div class="card card-chart">
                <div class="card-header">
                    <h5 class="card-category">Pró-Mamá</h5>
                    <h4 class="card-title">{{ $termos->titulo }}</h4>
                </div>
                <div class="card-body">
                	<p>
                		{!! nl2br(e($termos->texto)) !!}
                	</p>
                </div>
            </div>
        </div>
@endsection