<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

<p>
<center>
	<img src="{{ asset('img/promama.png') }}" style="width: 100px">
</center>
<br>
Olá, sua dúvida foi respondida: <br>
<a href="http://saude.osorio.rs.gov.br:7083/duvidas/">ACESSE</a>

Sua Dúvida: 
<p style="font-weight: bold;">
	{{ $pergunta }}
</p>

Resposta:
<p style="font-weight: bold;">
	{{ $resposta }}
</p>
<br>

</p>

</body>
</html>