<?php

namespace App\Http\Controllers;
use App\{Cliente, Compra,Produto};
use DB;

use Illuminate\Http\Request;

class CompraController extends Controller
{
    public function index(){
        $compras = Compra::all();
        return view('compra.index', compact('compras'));
    }

    public function create()
    {
        $data = [
            'compra' => '',
            'url' => 'compra',
            'method' => 'POST',
            'clientes'=>Cliente::all(),
            'produtos'=>Produto::all()
        ];
        return view('compra.form', compact('data'));
    }
}
