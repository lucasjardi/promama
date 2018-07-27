@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Preencha os campos
                        <a href="{{ url('informacoes') }}" class="float-right">Listar Informações</a>
                    </div>

                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        
                        @if( Session::has('mensagem_sucesso') )
                            <div class="alert alert-success alert-dismissible fade show">
                                {{ Session::get('mensagem_sucesso') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        @if( Request::is('*/editar'))
                            {{ Form::model($info, ['method' => 'PATCH', 'url' => 'informacoes/' . $info->informacao_id, 'files' => 'true']) }}
                        @else
                            {!! Form::open(['url' => 'informacoes/salvar', 'files' => 'true']) !!}
                        @endif

                        {!! Form::label('informacao_titulo','Título') !!}
                        <span style="color: red"> * </span>
                        {!! Form::input('text','informacao_titulo',null, ['class' => 'form-control', 'placeholder' => 'Título da Informação (Máximo 60 caracteres)','maxlength' => 100,'required']) !!}
                        {!! Form::label('informacao_corpo', 'Corpo da Informação') !!}
                        <span style="color: red"> * </span>
                        {!! Form::textarea('informacao_corpo', null,['class' => 'form-control', 'rows' => '5','required']) !!}

                        @if(!Request::is('*/editar'))
                        <script type="text/javascript">
                            document.getElementById('informacao_titulo').addEventListener('keyup', verifica);
                            document.getElementById('informacao_corpo').addEventListener('keyup', verifica);

                            function verifica() {
                                var titulo = document.getElementById('informacao_titulo').value;
                                var corpo = document.getElementById('informacao_corpo').value;

                                if (titulo != "" && corpo != "") {
                                    document.getElementById('previewInfo').disabled = false;
                                } else {
                                    document.getElementById('previewInfo').disabled = true;
                                }
                            }
                        </script>
                        @else
                          <script type="text/javascript">
                              document.body.onload = function () {
                                document.getElementById('previewInfo').disabled = false;
                                document.getElementById('info_foto').src = "{{ $info->informacao_foto }}";
                              }
                          </script>
                        @endif

                        {!! Form::label('informacao_idadeSemanasInicio','Idade') !!}
                        <span style="color: red"> * </span>

                        <select name="informacao_idadeSemanasInicio" class="form-control">
                            <?php foreach ($idades as $idade): ?>
                            	<?php
                            		$selected = null; 
                            		if (Request::is('*/editar')) {
                            		 	$selected = ($idade->semanas == $info->informacao_idadeSemanasInicio) ? "selected=\"selected\"" : null;
                            		 } 
                            	?>
                                <option value="<?php echo $idade->semanas ?>" <?php echo $selected ?> ><?php echo $idade->idade ?></option>
                            <?php endforeach ?>
                        </select>

                        <br>
                        <a data-toggle="collapse" href="#maisOpcoes" aria-expanded="false" aria-controls="maisOpcoes">
                            <i class="fas fa-angle-double-down"></i> Mais opções
                        </a>
                        <br>

                        <div class="collapse" id="maisOpcoes">
                            
                            @if(Request::is('*/editar'))
                              <label><b>Lista de Links </b> <a href="" onclick="return false;" id="adicionarLink"><i class="fas fa-plus-circle"></i></a></label>
                            @else
                              <label><b>Adicionar Links Externos </b> <a href="" onclick="return false;" id="adicionarLink"><i class="fas fa-plus-circle"></i></a></label>
                            @endif
                            
                            <div id="linhaLink">
                                @if(isset($info))
                                    @forelse( $info->links as $link )
                                    <div class="row" id="row{{ $link->id }}">
                                        <input type="hidden" name="linkId[]" value="{{ $link->id }}">
                                        <div class="col-md-5" id="containerChave">
                                            <label for="chave">Título: </label>
                                            <input type="text" name="chavesFromBanco[]" class="form-control links_titulo" placeholder="Post do Facebook" value="{{ $link->titulo }}" onkeyup="valuesChanged()">
                                        </div>
                                        <div class="col-md-5" id="containerValor">
                                            <label for="chave">Link: </label>
                                              <input type="text" name="valoresFromBanco[]" class="form-control links_url" placeholder="http://facebook.com" value="{{ $link->url }}" onkeyup="valuesChanged()">
                                        </div>
                                        <div class="col-md-2">
                                            <a href="" id="{{ $link->id }}" onclick="removeLink(this);return false;"><i class="fas fa-minus-circle" style="margin-top: 35px;"></i></a>
                                        </div>
                                    </div>
                                    @empty
                                    @endforelse
                                @endif
                            </div>

                            <label><b>Adicionar Link Para Dúvida Frequente </b> <a href="" onclick="return false;" id="exibeDuvidasFrequentes"><i class="fas fa-plus-circle"></i></a></label>

                            <div id="comboboxesDuvidasFrequentes"></div>

                             


                            <script type="text/javascript">
                                
                                document.getElementById('exibeDuvidasFrequentes').addEventListener("click", function () {
                                    var cbDF = document.createElement("select");
                                    cbDF.className = "form-control";
                                    cbDF.name = "duvidas_frequentes[]";
                                    var option = document.createElement("option");
                                    option.value = "";

                                    <?php foreach ($duvidasFrequentes as $df): ?>
                                      option = document.createElement("option");
                                      option.value = "<?php echo $df->id ?>";
                                      option.appendChild(document.createTextNode("<?php echo $df->titulo ?>"));
                                      cbDF.appendChild(option);
                                    <?php endforeach ?>

                                    cbDF.appendChild(option);

                                    document.getElementById('comboboxesDuvidasFrequentes').appendChild(cbDF);
                                });


                                document.getElementById("adicionarLink").addEventListener("click", function() {

                                      var row = document.createElement("div");
                                      var colmd51 = document.createElement("div");
                                      var colmd52 = document.createElement("div");
                                      var colmd2 = document.createElement("div");
                                      var labelTitulo = document.createElement("label");
                                      var labelURL = document.createElement("label");
                                      var inputChave = document.createElement("input");
                                      var inputValor = document.createElement("input");
                                      var btnDelete = document.createElement("a");
                                      var iconeDelete = document.createElement("i");

                                      var identificadorUnico = Date.now();
                                      row.className = "row";
                                      row.id = identificadorUnico;
                                      colmd51.className = "col-md-5";
                                      colmd52.className = "col-md-5";
                                      colmd2.className = "col-md-2";
                                      labelTitulo.appendChild(document.createTextNode("Título:"));
                                      labelURL.appendChild(document.createTextNode("Link:"));

                                      iconeDelete.className = "fas fa-minus-circle";
                                      iconeDelete.style.marginTop = "35px";
                                      btnDelete.onclick = function () {
                                            document.getElementById("linhaLink").removeChild(document.getElementById(identificadorUnico));
                                            return false;
                                        };
                                      btnDelete.href = "";
                                      btnDelete.appendChild(iconeDelete);

                                      inputChave.type = "text";
                                      inputChave.name = "chavesToSave[]";
                                      inputChave.placeholder = "Post do Facebook";
                                      inputChave.className = "form-control links_titulo";

                                      inputValor.type = "text";
                                      inputValor.name = "valoresToSave[]";
                                      inputValor.placeholder = "http://facebook.com";
                                      inputValor.className = "form-control links_url";

                                      row.appendChild(colmd51);
                                      row.appendChild(colmd52);
                                      row.appendChild(colmd2);
                                      colmd51.appendChild(labelTitulo);
                                      colmd51.appendChild(inputChave);
                                      colmd52.appendChild(labelURL);
                                      colmd52.appendChild(inputValor);
                                      colmd2.appendChild(btnDelete);

                                      document.getElementById("linhaLink").appendChild(row);

                                });

                                document.getElementById("removerLink").addEventListener("click", function() {
                                    var containerChave = document.getElementById("containerChave");
                                    var containerValor = document.getElementById("containerValor");

                                    if(containerChave.children.length != 1) containerChave.removeChild(containerChave.lastChild);
                                    if(containerValor.children.length != 1) containerValor.removeChild(containerValor.lastChild);
                                });

                                function removeLink(elemento) {
                                    document.getElementById("linhaLink").removeChild(document.getElementById("row" + elemento.id));

                                    var toDelete = document.createElement("input");

                                    toDelete.type = "hidden";
                                    toDelete.name = "toDelete[]";
                                    toDelete.value = elemento.id;

                                    document.getElementById("linhaLink").appendChild(toDelete);

                                    // document.getElementById("maisOpcoes").removeChild(elemento.path[2]);
                                }

                                function removeCb(elemento) {
                                    document.getElementById("comboboxesDuvidasFrequentes").removeChild(elemento.parentNode);
                                }

                                function valuesChanged() {
                                    if (! document.getElementById("linhaLink").contains(document.getElementById("changed")) ) {
                                        var changed = document.createElement("input");

                                        changed.type = "hidden";
                                        changed.id = "changed";
                                        changed.name = "changed";

                                        document.getElementById("linhaLink").appendChild(changed);
                                    }
                                }
                            </script>

                            <br>
                            {!! Form::label('informacao_autor','Autor') !!}
                            {!! Form::input('text','informacao_autor',null, ['class' => 'form-control', 'placeholder' => 'Nome do Autor']) !!}

                            {!! Form::label('informacao_foto','Foto da Informação') !!}
                            {!! Form::file('informacao_foto', ['class' => 'form-control', 'accept' => 'image/*']) !!}

                            <script type="text/javascript">
                                document.getElementById('informacao_foto').addEventListener('change', function (event) {
                                  var selectedFile = event.target.files[0];
                                  var reader = new FileReader();

                                  var imgtag = document.getElementById("info_foto");
                                  imgtag.title = selectedFile.name;

                                  reader.onload = function(event) {
                                    imgtag.src = event.target.result;
                                  };

                                  reader.readAsDataURL(selectedFile);
                                });
                            </script>
                        </div>

                        @if( Request::is('*/editar'))
                            <label>Foto Atual</label><br>
                            <img src="{!! $info->informacao_foto !!}" style="width: 200px" />
                        @endif
                        {!! "<br>" !!}
                        {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
                        <!-- Button trigger modal -->
                        <button type="button" class="btn" id="previewInfo" data-toggle="modal" data-target="#exampleModalLong" onclick="cliqueDoBotaoLoro()" style="float: right" disabled>
                          Pré-visualizar <i class="fas fa-mobile-alt"></i>
                        </button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

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
            /*margin-top: 100px;*/
        }
        .fundoSmartphone .cabecalho_info img{
            width: 200px;
            height: 200px;
        }
        .fundoSmartphone .cabecalho_info h4{
            padding-left: 100px;
            padding-right: 100px;
            word-break: break-all;
            font-weight: 700;
        }



        .fundoSmartphone .texto_info{
            padding-top: 30px;
            width: 410px;
            margin: 0 auto;
        }
        .fundoSmartphone .texto_info p{
            text-align: justify;
            word-break: break-all;
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


    <!-- Modal -->
    <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true" style="width: 600px;margin: 0 auto;">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">
              Pré-visualização
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

                <!-- TELEFONE RENDER -->
                <div class="scale-min">
                    <div class="fundoSmartphone">

                        <div class="cabecalho_info">
                            <h4 id="titulo_info"></h4>
                            <img id="info_foto" >
                        </div>

                        <div class="texto_info">
                            <p id="corpo_info"></p>

                            <div class="links_info" id="links_info"></div>
                        </div>

                    </div>
                </div>
                <!-- FIM TELEFONE RENDER -->
          </div>
          <div class="modal-footer">
            <p class="modal-title">
                  *Isto é apenas uma prévia. Não reflete de fato como ficará a informação no celular.
            </p>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
          </div>
        </div>
      </div>
    </div>
    <script type="text/javascript">
        function cliqueDoBotaoLoro() {

            var links = document.getElementById("links_info");
            if ( links.hasChildNodes() ) {
                while (links.firstChild) {
                    links.removeChild(links.firstChild);
                }
            }


            if (document.getElementById('titulo_info').hasChildNodes()) {

                document.getElementById('titulo_info').
                    removeChild(
                        document.getElementById('titulo_info').lastChild
                    );
            }

            if (document.getElementById('info_foto').src == '') {
                document.getElementById('info_foto').style.display = 'none';
            } else {
                document.getElementById('info_foto').style.display = '';
            }

            if (document.getElementById('corpo_info').hasChildNodes()) {
                
                document.getElementById('corpo_info').
                    removeChild(
                        document.getElementById('corpo_info').lastChild
                    );
            }


            var titulo = document.getElementById('informacao_titulo').value;
            var corpo = (document.getElementById('informacao_corpo').value).substring(0,1000);

            document.getElementById('titulo_info').appendChild(
                document.createTextNode(titulo)
            );

            document.getElementById('corpo_info').appendChild(
                document.createTextNode(corpo)
            );


            // verificar se linhaLinks so tem um ChildNodes 
                // se a Child ta vazia nao coloca os links
                // se nao ta itera normal

            var linksTitulos = document.getElementsByClassName("links_titulo");

            if ( !links.children.length == 1 && linksTitulos[0].value != "" ) {

                var h6 = document.createElement('h6');
                h6.appendChild(document.createTextNode("Links"));
                document.getElementById('links_info').appendChild(h6);

                var limiteDeLinks = 2;
                var contador = 1;

                for(var i = 0; i <= linksTitulos.length; i++){
                    var btn = document.createElement('button');

                    btn.appendChild(
                            document.createTextNode(
                                linksTitulos[i].value
                            )
                        );

                    document.getElementById('links_info').appendChild(btn);

                    if ( (contador++) == limiteDeLinks ) break;
                }

            }


        }
    </script>
@endsection