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

                        
                        {!! Form::label('informacao_idadeSemanasInicio','Idade de Início') !!}
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


                        {!! Form::label('informacao_idadeSemanaFim','Idade de Fim') !!}
                        <span style="color: red"> * </span>

                        <select name="informacao_idadeSemanasFim" class="form-control">
                            <?php foreach ($idades as $idade): ?>
                            	<?php
                            		$selectedFim = null; 
                            		if (Request::is('*/editar')) {
                            		 	$selectedFim = ($idade->semanas == $info->informacao_idadeSemanasFim) ? "selected=\"selected\"" : null;
                            		 } 
                            	?>
                                <option value="<?php echo $idade->semanas ?>" <?php echo $selectedFim ?> ><?php echo $idade->idade ?></option>
                            <?php endforeach ?>
                        </select>

                        <br>
                        <a data-toggle="collapse" href="#maisOpcoes" aria-expanded="false" aria-controls="maisOpcoes">
                            <i class="fas fa-angle-double-down"></i> Mais opções
                        </a>
                        <br>

                        <div class="collapse" id="maisOpcoes">
                            <label><b>Adicionar Links</b> <a href="" onclick="return false;" id="adicionarLink"><i class="fas fa-plus-circle"></i></a></label>

                            <!-- <div class="row">
                                <div class="col-md-5" id="containerChave">
                                    <label>Título: </label>
                                    @if(isset($info))
                                        @forelse( $info->links as $link )
                                            <input type="text" name="chaveFromBanco[]" class="form-control" placeholder="Post do Facebook" value="{!! $link->titulo !!}">
                                        @empty
                                            <input type="text" name="chave[]" class="form-control" placeholder="Post do Facebook">
                                        @endforelse
                                    @else
                                        <input type="text" name="chave[]" class="form-control" placeholder="Post do Facebook">
                                    @endif
                                </div>

                                <div class="col-md-5" id="containerValor">
                                    <label>Link: </label>
                                    @if(isset($info))
                                        @forelse( $info->links as $link )
                                            <input type="text" name="valorFromBanco[]" class="form-control" placeholder="Post do Facebook" value="{!! $link->url !!}">
                                            <a id="removerLink" class="btn btn-primary" style="color: white;padding: 2px;">-</a>
                                        @empty
                                            <input type="text" name="valor[]" class="form-control" placeholder="Post do Facebook">
                                        @endforelse
                                    @else
                                        <input type="text" name="valor[]" class="form-control" placeholder="Post do Facebook">
                                    @endif
                                </div>
                                
                                <div class="col-md-2">
                                    <a id="adicionarLink" class="btn btn-primary" style="color: white;padding: 8px;">+</a>
                                    <a id="removerLink" class="btn btn-primary" style="color: white;padding: 8px;">-</a>
                                </div>
                            </div> -->
                            
                            <div id="linhaLink">
                                @if(isset($info))
                                    @forelse( $info->links as $link )
                                    <div class="row" id="row{{ $link->id }}">
                                        <input type="hidden" name="linkId[]" value="{{ $link->id }}">
                                        <div class="col-md-5" id="containerChave">
                                            <label for="chave">Título: </label>
                                            <input type="text" name="chavesFromBanco[]" class="form-control" placeholder="Post do Facebook" value="{{ $link->titulo }}" onkeyup="valuesChanged()">
                                        </div>
                                        <div class="col-md-5" id="containerValor">
                                            <label for="chave">Link: </label>
                                            <input type="text" name="valoresFromBanco[]" class="form-control" placeholder="http://facebook.com" value="{{ $link->url }}" onkeyup="valuesChanged()">
                                        </div>
                                        <div class="col-md-2">
                                            <a href="" id="{{ $link->id }}" onclick="removeLink(this);return false;"><i class="fas fa-minus-circle" style="margin-top: 35px;"></i></a>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="row" id="firstElement">
                                        <div class="col-md-5" id="containerChave">
                                            <label for="chave">Título: </label>
                                            <input type="text" name="chavesToSave[]" class="form-control" placeholder="Post do Facebook">
                                        </div>
                                        <div class="col-md-5" id="containerValor">
                                            <label for="chave">Link: </label>
                                            <input type="text" name="valoresToSave[]" class="form-control" placeholder="http://facebook.com">
                                        </div>
                                        <div class="col-md-2">
                                            <a href="" onclick="document.getElementById('linhaLink').removeChild(document.getElementById('firstElement')); return false;"><i class="fas fa-minus-circle" style="margin-top: 35px;"></i></a>
                                        </div>
                                    </div>
                                    @endforelse

                                @else
                                    <div class="row" id="firstElement">
                                        <div class="col-md-5" id="containerChave">
                                            <label for="chave">Título: </label>
                                            <input type="text" name="chavesToSave[]" class="form-control" placeholder="Post do Facebook">
                                        </div>
                                        <div class="col-md-5" id="containerValor">
                                            <label for="chave">Link: </label>
                                            <input type="text" name="valoresToSave[]" class="form-control" placeholder="http://facebook.com">
                                        </div>
                                        <div class="col-md-2">
                                            <a href="" onclick="document.getElementById('linhaLink').removeChild(document.getElementById('firstElement')); return false;"><i class="fas fa-minus-circle" style="margin-top: 35px;"></i></a>
                                        </div>
                                    </div>
                                @endif
                            </div>


                            <script type="text/javascript">
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
                                      inputChave.className = "form-control";

                                      inputValor.type = "text";
                                      inputValor.name = "valoresToSave[]";
                                      inputValor.placeholder = "http://facebook.com";
                                      inputValor.className = "form-control";

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
                        </div>

                        @if( Request::is('*/editar'))
                            <label>Foto Atual</label><br>
                            <img src="{!! $info->informacao_foto !!}" style="width: 200px" />
                        @endif
                        {!! "<br>" !!}
                        {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection