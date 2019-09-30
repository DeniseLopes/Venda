<?php

namespace App\Http\Controllers;

use App\{Cliente, Compra, Produto};
use DB;

use Illuminate\Http\Request;

class CompraController extends Controller
{
    public function index()
    {
        $compras = Compra::all();
        return view('compra.index', compact('compras'));
    }

    public function create()
    {
        $data = [
            'compra' => '',
            'url' => url('/compra'),

            'clientes' => Cliente::all(),
            'produtos' => Produto::all(),
            'venda'   => null
        ];
        return view('compra.form', compact('data'));
    }

    public function store(Request $request)
    {

        DB::beginTransaction();

        try {
            //  dd($request->all());
            $cliente = Cliente::findOrFail($request->cliente);
            $compra = new Compra;

            $compra->cliente()->associate($cliente)->save();
            foreach ($request['produtos'] as $key => $produto) {
                $compra->produtos()->attach($produto, array('quantidade' => $request['quantidades'][$key]));
            }
         
            DB::commit();
            return redirect('compra/'.$compra->id .'/show')->with("success", "compra realizada com sucesso");
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function show($id){
        $compra = Compra::findOrFail($id);
        $total = 0;
        foreach($compra->produtos as $produto){
            $total += $produto->valor * $produto->pivot->quantidade;
        }
        return view('compra.show', compact('compra', 'total'));

    }
}
