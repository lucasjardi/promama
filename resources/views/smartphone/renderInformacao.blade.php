@extends('layouts.app')

@section('content')
<style type="text/css">
	.fundoSmartphone{
		font-family: 'Roboto', sans-serif;
		background-image: url("{{ asset('img/fundo.png') }}");
		width: 570px;
		height: 1120px;
		margin: 0 auto;
	}

	.fundoSmartphone .cabecalho_info{
		text-align: center;
		padding-top: 180px;
		margin-top: 100px;
	}
	.fundoSmartphone .cabecalho_info img{
		width: 200px;
		height: 200px;
	}
	.fundoSmartphone .cabecalho_info h4{
		padding-left: 100px;
		padding-right: 100px;
		font-weight: 700;
	}



	.fundoSmartphone .texto_info{
		padding-top: 30px;
		width: 410px;
		margin: 0 auto;
	}
	.fundoSmartphone .texto_info p{
		text-align: justify;
	}

	.fundoSmartphone .links_info{
		text-align: center;
	}
	.fundoSmartphone .links_info h4{
		
	}
	.fundoSmartphone .links_info button{
		border: none;
		padding: 10px;
		width: 410px;
		background-color: #ff3f34;
		color: white;
		font-weight: 700;
		line-height: 20px;
		margin-top: 10px;
	}

</style>


<div class="fundoSmartphone">

	<div class="cabecalho_info">
		<h4>{{ $info->informacao_titulo }}</h4>
		<img src="{{ $info->informacao_foto }}" id="info_foto">
	</div>

	<div class="texto_info">
		<p>
			{{ substr($info->informacao_corpo,0,900) }}
			<?php if(strlen($info->informacao_corpo) > 900) echo "<b>...</b>" ?>
		</p>

		@if(! empty($info->links[0]) )
			<div class="links_info">
				<h6>Links:</h6>

				<?php $i = 1; ?>
				<?php foreach($info->links as $link):  ?>
					<button>{{ $link->titulo }}</button>
					<?php if(($i++) == 2) break; ?>
				<?php endforeach; ?>

			</div>
		@endif
	</div>
</div>
@endsection