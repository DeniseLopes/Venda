<?php

namespace App\Http\Controllers;
use App\{Cliente, Compra};
use DB;

use Illuminate\Http\Request;

class CompraController extends Controller
{
    public function index(){
        return 'compra';
    }
}
