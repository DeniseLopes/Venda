@extends ("layouts.app")
@section ("content")

<div class="card">
    <div class="card-header"> Venda {{ $compra->id }}</div>
    <div class="card-body">

        <div class="form-group col-md-12">
            <label> cliente:</label>
            <input class="form-control" value="{{ $compra->cliente->nome }}" disabled>
        </div>
        <div class="card-header text-center">Produtos</div>

        <div class="form-row adicionarProduto">
            @foreach($compra->produtos as $key => $produto)
            <div class=" col-md-6">
                <label>produto:</label>
                <input class="form-control" value="{{$produto->nome }}" disabled>
            </div>
            <div class=" col-md-3">
                <label>Quantidade:</label>
                <input type="text" name="quantidades[0]" value="{{$produto->pivot->quantidade}}" class="form-control quantidade" placeholder="Quantidade" disabled>
            </div>
            <div class="col-md-3">
                <label>Preço:</label>
                <input type="text" name="valor[0]" value="{{ $produto->valor }}" class="form-control preco" disabled>
            </div>
            @endforeach
            <div class="col-md-9">
                <label>Total:</label>
                <input type="text" name="total" value="{{ $total }}" class="form-control total" disabled>
            </div>
            <div class="col-md-3">
                <label>Data:</label>
                <input type="text" name="data" value="{{ $compra->created_at }}" class="form-control data_compra" disabled>
            </div>
        </div>

        <div class="col-sm-12 " style="display:flex; justify-content-left">
            <a href="{{url('/compra')}}"  class="btn btn-info" style="margin-top:10px;">Voltar</a>
        </div>


    </div>
    
</div>

@stop
<script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){
        dataAtualFormatada()
    })
function dataAtualFormatada(){
    var data = $('.data_compra').val()
      var ano = data.split('-')[0];
      var mes = data.split('-')[1];
      var dia = data.split('-')[2];
      dia = dia.substr(0,2)
  dataF= dia + '/' + mes + '/' + ano 
  $('.data_compra').val(dataF)

}
</script>