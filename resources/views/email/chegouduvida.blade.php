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
Olá, chegou uma nova dúvida de um usuário do aplicativo Pró-Mamá. <br>

Dúvida de : <b>{{ $email }}</b> <br>
Mensagem: 
<p style="font-weight: bold;">
	{{ $duvida }}
</p>
<br>

Para responder você pode clicar <a href="{{ route('duvidas') . '/'. $duvida_id }}">AQUI</a>.
<br>

</p>

</body>
</html>