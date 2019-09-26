<?php

namespace App\Http\Controllers;
use App\{Produto, Compra};
use Illuminate\Http\Request;
use DB;

class ProdutoController extends Controller
{
    public function index(){
        $produtos = Produto::all();
        return view('produto.index', compact('produtos'));
    }

    public function create(){
        $data = [
            'produto' => '',
            'url' => 'produto',
            'method' => 'POST',
        ];
        return view('produto.form', compact('data'));
    }
}
