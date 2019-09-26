@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header">Painel</div>
    <div class="card-body">

        <h6>Bem vindo!</h6>
        <hr>

        <div class="row">

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Menu</div>
                    <div class="card-body">
                    <a href="{{url('cliente')}}" class="btn btn-outline-secondary">Clientes</a>
                    <a href="{{url('produto')}}" class="btn btn-outline-secondary">Produtos</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop