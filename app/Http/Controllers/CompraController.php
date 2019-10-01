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
        $comprasInativas = Compra::onlyTrashed()->get();
        return view('compra.index', compact('compras', 'comprasInativas'));
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
            'method' => 'PUT',

        ];
        return view('compra.form', compact('data'));
    }

    public function store(Request $request)
    {
        //dd($request->all());
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
            'clientes' => Cliente::all(),
            'venda' => Compra::findOrFail($id),
            'produtos' => Produto::all(),
            'method' => 'PUT',

        ];
        return view('compra.form', compact('data'));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            //   dd($request->all());
            $cliente = Cliente::findOrFail($request->cliente);
            $compra = Compra::findOrFail($id);
            $compra->cliente()->associate($cliente)->save();
            $ids = array();
            foreach ($compra->produtos as $produto) {
                $ids[] = $produto->id;
            }
            $compra->produtos()->detach($ids);
            foreach ($request['produtos'] as $key => $produto) {
                $compra->produtos()->attach($produto, array('quantidade' => $request['quantidades'][$key]));
            }
            DB::commit();
            return redirect('compra/' . $compra->id . '/show')->with("success", "venda alterada com sucesso");
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function destroy($id)
    {
        $compra = Compra::withTrashed()->findOrFail($id);
        if ($compra->trashed()) {
            $compra->restore();
            return back()->with('success', 'Produto ativado com sucesso!');
        } else {
            $compra->delete();
            return back()->with('success', 'Produto desativado com sucesso!');
        }
    }
}
