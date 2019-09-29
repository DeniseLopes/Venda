<?php

namespace App\Http\Controllers;
use App\{Cliente, Produto, Compra};
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $data = [
              'cliente' => Cliente::all(),
              'produto' => Produto::all(),
              'compra'  => Compra::all()
            ];
        
        return view('home', compact('data'));
    }
   
}
