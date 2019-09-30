@extends ("layouts.app")
@section ("content")

<div class="card">
    <div class="card-header">{{$data['venda'] ? 'Editar Venda' : 'Novo venda'}}</div>
    <div class="card-body">
        <h3 style="padding-left: 50px">Cadastro de Vendas</h3>

        <form method="POST" action="{{ $data['url'] }}">
            @if(isset($data['venda']))
            @method('PUT')
            @endif
            @csrf
            <div class="form-group col-md-12">
                <label>Escolha o cliente:</label>
                <select class="form-control" name="cliente">
                    <option>Selecione uma opção</option>
                    @foreach($data['clientes'] as $cliente)
                    <option value="{{$cliente->id}}">{{$cliente->nome}}</option>
                    @endforeach
                </select>
            </div>
            <div class='adicionarProduto'>
                <div class="card-header text-center">Adicionar Produtos</div>
                <div class="form-row adicionarProduto">
                    <div class=" col-md-6">
                        <label>Escolha os produtos:</label>
                        <select class="custom-select produto" name="produtos[0]">
                            <option>Selecione</option>
                            @foreach($data['produtos'] as $produto)
                            <option value="{{$produto->id}}">{{$produto->nome}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class=" col-md-3">
                        <label>Quantidade:</label>
                        <input type="text" name="quantidades[0]" class="form-control quantidade" placeholder="Quantidade">
                    </div>
                    <div class="col-md-3">
                        <label>Preço:</label>
                        <input type="text" name="valor[0]" class="form-control preco">
                    </div>
                </div>

                <div id="inserir"></div>

                <div class="col-sm-12">
                    <button class="btn btn-danger removerProduto" style="float:right;  margin-top:10px">Remover</button>
                    <button type="button" class="btn btn-success add" style="float:right ;margin:10px">Adicionar</button>
                </div>
                <div class="col-sm-12 " style="display:flex; justify-content-left">
                    <button type="submit" class="btn btn-success">Cadastrar</button>
                </div>
            </div>
        </form>

    </div>
</div>



@stop


<script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.removerProduto').click(function(e){
            e.preventDefault();
            var ultimo = document.querySelectorAll(".adicionarProduto")
            ultimo = ultimo[ultimo.length - 1]
            console.log(ultimo)
            $(ultimo).remove();
        })
        $('.produto').change(function() {
            var id = $(this).val()
            buscaPreco($(this), id)
        })
        $('.quantidade').change(function() {
            var quantidade = $(this).val();
            if (quantidade <= 0) {
                $(this).val("")
            }
        })
        $('.add').click(function() {
            adicionarProduto()
        })
        var indice = 1

        function adicionarProduto() {
            $("#inserir").append("<div class='form-row adicionarProduto'><div class='col-md-6'><label>Escolha os produtos:</label><select class='custom-select produto' onChange='buscaPreco($(this), this.value)'   name='produtos[" + indice + "]'><option>Selecione uma opção</option>@foreach($data['produtos'] as $produto)<option value='{{$produto->id}}'>{{$produto->nome}}</option>        @endforeach</select></div><div class='col-md-3'><label>Quantidade:</label><input type='text' name='quantidades[" + indice + "]' class='form-control quantidade' onChange=validaQuantidade($(this),this.value) placeholder='Quantidade'></div><div class='col-md-3'><label>Preço:</label><input type='text' name='valor[" + indice + "]' class='form-control preco'></div></div>")
            indice++
        }

    })

    function validaQuantidade(input, valor) {
        if (valor <= 0) {
            input.val("")
        }
    }

    function buscaPreco(select, id) {
        console.log('select = ' + select + ' id =' + id)
        $.ajax({
            url: '/buscaPreco',
            type: 'POST',
            data: {
                id: id,
                '_token': $('input[name=_token]').val(),
            }
        }).done(function(data) {
            console.log(data)
            var preco = $.parseJSON(data)['valor']
            console.log(preco)

            select.parent().parent().find('input.preco').val(preco)
        }).fail(function() {

        })
    }
</script>