@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header">Venda</div>
    <div class="card-body">

        <div class="col-md-12">
            <div class="text-right">
                <a href="{{url('compra/create')}}" class="btn btn-success">Nova Venda</a>
            </div>
        </div>

        <div class="col-md-12 mt-4">
            <div class="card">
                <div class="card-header">Vendas Ativas</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nome do Cliente</th>
                                <th>Data</th>
                                <th colspan='3'>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($compras as $compra)
                            <tr>
                                <td>{{$compra->cliente->nome}}</td>
                                <td>{{$compra->created_at}}</td>
                                <td>
                                    <div class="btn-group mr-2" role="group" aria-label="First group">
                                        <a href="{{url('compra/'.$compra->id.'/show')}}" class="btn btn-info" style="margin-right:5px">Visualizar</a>
                                        <a href="{{url('compra/'.$compra->id.'/edit')}}" class="btn btn-warning" style="margin-right:5px">Editar</a>
                                        <form action="{{url('compra', [$compra->id])}}" method="POST">
                                            {{method_field('DELETE')}}
                                            {{ csrf_field() }}
                                            <input type="submit" class="btn btn-danger" value="Desativar" />
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection