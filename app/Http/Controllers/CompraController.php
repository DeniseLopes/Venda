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
            'venda'    => null,
            'title'    => 'Criar Venda',
            'button'   => 'Cadastrar',
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
            return redirect('compra/' . $compra->id . '/show')->with("success", "compra realizada com sucesso");
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function show($id)
    {
        $compra = Compra::findOrFail($id);
        $total = 0;
        foreach ($compra->produtos as $produto) {
            $total += $produto->valor * $produto->pivot->quantidade;
        }
        return view('compra.show', compact('compra', 'total'));
    }

    public function edit(Request $request, $id)
    {

        $data = [
            'url'   => url('/compra/' . $id),
            'title' => 'Editar Vendas',
            'button' => 'Atualizar',
            'clientes'=>Cliente::all(),
            'venda' => Compra::findOrFail($id),
            'produtos'=>Produto::all(),

        ];
        return view('compra.form', compact('data'));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $venda = Compra::find($id);
            $vendaNova = new Compra;
            $vendaNova->cliente()->associate($venda->cliente)->save();
            foreach ($request['produtos'] as $key => $produto) {
                $vendaNova->produtos()->attach($produto, array('quantidade' => $request['quantidades'][$key]));
            }
            $venda = $vendaNova;
            dd($venda);
            $venda->save();
            DB::commit();
            return redirect('/compra')->with('success', 'Venda atualizada com sucesso!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect('/compra')->with('error', 'codigo:'.$e->getMessage());
        }
    }
}
