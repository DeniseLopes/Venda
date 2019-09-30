@extends ("layouts.app")
@section ("content")

<div class="card">
    <div class="card-header">{{$data['produtos'] ? 'Editar produto' : 'Novo produto'}}</div>
    <div class="card-body">
        <h3 style="padding-left: 50px">Cadastro de Vendas</h3>

        <form method="POST" action="{{ $data['url'] }}">
        @if(isset($data['venda']))
            @method('PUT')
            @endif
            @csrf
            <div class="form-group col-md-12">
                <label>Escolha o cliente:</label>
                <select class="form-control" name="pessoa">
                    <option>Selecione uma opção</option>
                    @foreach($data['clientes'] as $cliente)
                    <option value="{{$cliente->id}}">{{$cliente->nome}}</option>
                    @endforeach
                </select>
            </div>


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

            <div class="text-center">
                <button type="button" class="btn btn-success add" style="float:right">Adicionar</button>
            </div>
            <div style="padding-left: 50px">
                <button type="submit" class="btn btn-success">Cadastrar</button>
                <a href="{{url('/')}}" class="btn btn-primary pull-right" data-toggle="modal">Voltar ao menu principal</a>
            </div>
        </form>

    </div>
</div>



@stop


<script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
<script type="text/javascript">

	$(document).ready(function(){
        $('.produto').change(function(){
           // buscaProduto($(this).val())
           var id = $(this).val()
          buscaPreco($(this), id)

            console.log($(this).val())

        })
    $('.add').click(function(){
      adicionarProduto()
     })
	var indice = 1
	function adicionarProduto(){
		var ultimo = document.querySelectorAll(".adicionarProduto")
		ultimo = ultimo[ultimo.length -1]
		$("#inserir").append("<div class='form-row adicionarProduto'><div class='col-md-6'><label>Escolha os produtos:</label><select class='custom-select produto' onChange='buscaPreco($(this), this.value)'   name='produtos[" + indice + "]'><option>Selecione uma opção</option>@foreach($data['produtos'] as $produto)<option value='{{$produto->id}}'>{{$produto->nome}}</option>        @endforeach</select></div><div class='col-md-3'><label>Quantidade:</label><input type='text' name='quantidades[" + indice + "]' class='form-control' placeholder='Quantidade'></div><div class='col-md-3'><label>Preço:</label><input type='text' name='valor[" + indice + "]' class='form-control preco'></div></div>")
		indice++
    }
     
})
function buscaPreco(select, id){
             
    console.log('select = '+ select + ' id ='+ id)
           $.ajax({
             url: '/buscaPreco',
             type: 'POST',
             data:{
                 id:id,
                 '_token': $('input[name=_token]').val(),
             }
         }).done(function(data){
             console.log(data)
             var preco = $.parseJSON(data)['valor']
             console.log(preco)

            select.parent().parent().find('input.preco').val(preco)
         }).fail(function(){

         })
}
</script>