<?php

namespace App\Http\Controllers;
use App\{Cliente, Produto};
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $data = [
              'cliente' => Cliente::all(),
              'produto' => Produto::all()
            ];
        
        return view('home', compact('data'));
    }
   
}
