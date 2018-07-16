@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Preencha os campos
                        <a href="{{ url('duvidas-frequentes') }}" class="float-right">Listar Dúvidas Frequentes</a>
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

                        @if( Request::is('*/editar'))
                            {{ Form::model($df, ['method' => 'PATCH', 'url' => 'duvidas-frequentes/' . $df->id]) }}
                        @else
                                {!! Form::open(['url' => 'duvidas-frequentes/salvar']) !!}
                        @endif

                        {!! Form::label('titulo','Título') !!}
                        <span style="color: red"> * </span>
                        {!! Form::input('text','titulo',null, ['class' => 'form-control', 'placeholder' => 'Título do Texto', 'required']) !!}
                        {!! Form::label('texto','Texto') !!}
                        <span style="color: red"> * </span>
                        {!! Form::textarea('texto',null, ['class' => 'form-control', 'placeholder' => 'Corpo do Texto', 'required']) !!}
                        <br>

                        <label>
                          <b>Adicionar Links Externos </b> 
                          <a href="" onclick="return false;" id="adicionarLink">
                            <i class="fas fa-plus-circle"></i>
                          </a>
                        </label>
                        
                        <div id="linhaLink">
                            @if(isset($df))
                                @forelse( $df->links as $link )
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


                        {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
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
@endsection