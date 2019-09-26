@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header">Clientes</div>
    <div class="card-body">

        <div class="col-md-12">
            <div class="text-right">
                <a href="{{url('cliente/create')}}" class="btn btn-success">Novo Cliente</a>
                
            </div>
        </div>

        <div class="col-md-12 mt-4">
            <div class="card">
                <div class="card-header">Clientes Ativos</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th colspan='3'>Ações</th>
                            </tr>
                        </thead>
                       <tbody>
                       @foreach($data['clientesAtivos'] as $cliente)
                       <tr>
                       <td>{{$cliente->nome}}</td>
                       <td>
                       <div class="btn-group mr-2" role="group" aria-label="First group" >
                       <a href="{{url('cliente/'.$cliente->id.'/edit')}}" class="btn btn-warning" style ="margin-right:5px">Editar</a>
                       <form action="{{url('cliente', [$cliente->id])}}" method="POST">
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
                    <td>
               
                    </td>
                </div>
            </div>
        </div>
   
        <div class="col-md-12 mt-4">
            <div class="card">
                <div class="card-header">Clientes Inativos</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['clientesInativos'] as $cliente)
                                <tr>
                                    <td>{{$cliente->nome}}</td>
                                    <td>
                                        <form action="{{url('cliente', [$cliente->id])}}" method="POST">
                                            {{method_field('DELETE')}}
                                            {{ csrf_field() }}
                                                <input type="submit" class="btn btn-success" value="Ativar"/>
                                        </form>
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
@stop