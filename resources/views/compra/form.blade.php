@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header">{{$data['compra'] ? 'Editar compra' : 'Nova Compra'}}</div>
    <div class="card-body">
        <form method="POST" action="{{url($data['url'])}}">
            @if($data['method'] == 'PUT')
            @method('PUT')
            @endif
            @csrf
            <div class="form-group">
                <label><b>Nome</b></label>
                <select name="cliente" id="" class="custom-select">
                    @foreach($data['clientes'] as $cliente)
                    <option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
                    @endforeach
                </select>
                <span>{{$errors->first('cliente.nome')}}</span>
            </div>
            <div class="mae">
                <div class="form-row">
                    <div class="col-sm-6">
                        <label>Produto</label>
                        <select name="produtos[0]" id="" class="custom-select">
                            @foreach($data['produtos'] as $produto)
                            <option value="{{ $produto->id }}">{{ $produto->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class='col-sm-3'>
                        <label><b>Preço</b></label>
                        <input type='number' value='' name='preco[0]' class='form-control'>
                    </div>
                    <div class="col-sm-3">
                        <label><b>Quantidade</b></label>
                        <input type="number" value="" name="quantidades[0]" class="form-control">
                    </div>
                </div>
                <div id="inserir"></div>
                <button class="btn btn-success addProduto" style="float:right; margin:30px 0 0 10px; ">Adicionar</button>
            </div>
        </form>
    </div>
</div>
@stop

@yield('scripts')
<script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        $('.addProduto').click(function(e) {
            e.preventDefault();
            var indice = 1


            var ultimo = document.querySelectorAll(".form-row")
            ultimo = ultimo[ultimo.length - 1]
            $("#inserir").append("<div class='form-row'><div class='col-md-6'><div class='form-group'><label>Produtos</label><select class='form-control' name='produtos[" + indice + "]'><option>Selecione uma opção</option>@foreach($data['produtos'] as $produto)<option value='{{$produto->id}}'>{{$produto->nome}}</option>@endforeach</select></div></div>	                  	<div class='col-md-3'><div class='form-group'><label>Preço:</label><input type='text' name='preco[" + indice + "]' class='form-control' placeholder='preco'></div></div>        					<div class='col-md-3'><div class='form-group'><label>Quantidade:</label><input type='text' name='quantidades[" + indice + "]' class='form-control' placeholder='Quantidade'></div</div></div>")
            indice++
            recontar();

        })
    })

    function recontar() {

        $.each($('.form-row'), function(index, element) {
            $.each($(this).find('input,select'), function() {
                name = $(this).attr('name').replace(/\d+/, index);
                $(this).attr('name', name)
            })
            $(this).find('input,select').attr('name').replace(/\d+/, index)
        })
    }
</script>