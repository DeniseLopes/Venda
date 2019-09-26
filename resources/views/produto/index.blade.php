@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header">Produto</div>
    <div class="card-body">

        <div class="col-md-12">
            <div class="text-right">
                <a href="{{url('produto/create')}}" class="btn btn-success">Novo Produto</a>
                
            </div>
        </div>

        <div class="col-md-12 mt-4">
            <div class="card">
                <div class="card-header">Produtos</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Valor</th>
                                <th colspan='3'>Ações</th>
                            </tr>
                        </thead>
                       <tbody>
                       @foreach($produtos as $produto)
                       <tr>
                       <td>{{$produto->nome}}</td>
                       <td>{{$produto->valor}}</td>
                       <td>
                       <div class="btn-group mr-2" role="group" aria-label="First group" >
                       <a href="{{url('produto/'.$produto->id.'/edit')}}" class="btn btn-warning" style ="margin-right:5px">Editar</a>
                       <form action="{{url('produto', [$produto->id])}}" method="POST">
                            {{method_field('DELETE')}}
                            {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger" value="Desativar"/>
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