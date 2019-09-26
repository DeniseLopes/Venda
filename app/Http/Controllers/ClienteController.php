<?php

namespace App\Http\Controllers;
use App\{Cliente, Compra};
use Illuminate\Http\Request;
use DB;

class ClienteController extends Controller
{
    public function index(){
        
        $data = [
            'clientesAtivos' => Cliente::all(),
            'clientesInativos' => Cliente::onlyTrashed()->get()
        ];
        return view('cliente.index', compact('data'));
    }

    public function create(){
        $data = [
            'cliente' => '',
            'url' => 'cliente',
            'method' => 'POST',
        ];
        return view('cliente.form', compact('data'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $cliente = Cliente::create([
                'nome' => $request['cliente']['nome']
            ]);
          
            DB::commit();
            return redirect('cliente')->with('success', 'Cliente cadastrado com sucesso!');
        } catch(\Exception $e) {
            DB::rollback();
            return redirect('cliente')->with('error', 'Erro no servidor! Cliente não cadastrado!');
        }
    }

    public function edit($id)
    {
        $cliente = Cliente::findOrFail($id);
        $data = [
            'cliente' => $cliente,
            'url' => 'cliente/'.$id,
            'method' => 'PUT',
        ];
        return view('cliente.form', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);
        DB::beginTransaction();
        try {
            $cliente->update([
                'nome' => $request['cliente']['nome']
            ]);
           
            DB::commit();
            return redirect('cliente')->with('success', 'Cliente atualizado com sucesso!');
        } catch(\Exception $e) {
            DB::rollback();
            return redirect('cliente')->with('error', 'Erro no servidor! Cliente não atualizado!');
        }
    }

    public function destroy($id)
    {
        $cliente = Cliente::withTrashed()->findOrFail($id);
        if($cliente->trashed()) {
            $cliente->restore();
            return back()->with('success', 'Cliente ativado com sucesso!');
        } else {
            $cliente->delete();
            return back()->with('success', 'Cliente desativado com sucesso!');
        }
    }
}
