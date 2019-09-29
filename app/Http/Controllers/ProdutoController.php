<?php

namespace App\Http\Controllers;

use App\{Produto, Compra};
use Illuminate\Http\Request;
use DB;

class ProdutoController extends Controller
{
    public function index()
    {
        $produtos = Produto::all();
        $produtosInativos = Produto::onlyTrashed()->get();
       // dd($produtosInativos);
        return view('produto.index', compact('produtos', 'produtosInativos'));
    }

    public function create()
    {
        $data = [
            'produto' => '',
            'url' => 'produto',
            'method' => 'POST',
           
        ];
        return view('produto.form', compact('data'));
    }

    public function store(Request $request)
    {

        $valor = str_replace('R', '',  $request['produto']['valor']);
        $valor = str_replace('$', '', $valor);
        //   return $valor;

        DB::beginTransaction();
        try {
            $produto = Produto::create([
                'nome' => $request['produto']['nome'],
                'valor' => floatval($valor)
            ]);

            DB::commit();
            return redirect('produto')->with('success', 'produto cadastrado com sucesso!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect('produto')->with('error', 'Erro no servidor! produto não cadastrado!' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $produto = Produto::findOrFail($id);
        $data = [
            'produto' => $produto,
            'url' => 'produto/' . $id,
            'method' => 'PUT',
        ];
        return view('produto.form', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $produto = Produto::findOrFail($id);

        DB::beginTransaction();
        try {
            $produto->update([
                'nome' => $request['produto']['nome'],
                'valor' => $request['produto']['valor'],
            ]);

            DB::commit();
            return redirect('produto')->with('success', 'produto atualizado com sucesso!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect('produto')->with('error', 'Erro no servidor! produto não atualizado!');
        }
    }

    public function destroy($id)
    {
        $produto = Produto::withTrashed()->findOrFail($id);
        if ($produto->trashed()) {
            $produto->restore();
            return back()->with('success', 'Produto ativado com sucesso!');
        } else {
            $produto->delete();
            return back()->with('success', 'Produto desativado com sucesso!');
        }
    }
}
