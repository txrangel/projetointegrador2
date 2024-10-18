<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnidadeDeMedidaCreateUpdate;
use App\Models\UnidadeDeMedida;
use Illuminate\Http\Request;

class UnidadeDeMedidaController extends Controller
{
    public function index()
    {
        $unidades = UnidadeDeMedida::paginate(10);
        return view('unidades.index', compact('unidades'));
    }

    public function create()
    {
        return view('unidades.create');
    }

    public function edit($id)
    {
        $unidade = UnidadeDeMedida::findOrFail($id);
        return view('unidades.edit', compact('unidade'));
    }

    public function store(UnidadeDeMedidaCreateUpdate $request)
    {
        try {
            $unidade = UnidadeDeMedida::create($request->all());
            return redirect()->route('unidades_medida.index')->with('sucess', $unidade->nome . ' criado!!!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput(request()->all());
        }
    }

    public function update(UnidadeDeMedidaCreateUpdate $request, $id)
    {
        try {
            $unidade = UnidadeDeMedida::findOrFail($id);
            $unidade->update($request->all());
            return redirect()->route('unidades_medida.index')->with('sucess', $unidade->nome . ' alterado!!!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput(request()->all());
        }
    }

    public function delete($id)
    {
        try {
            $unidade = UnidadeDeMedida::findOrFail($id);
            $unidade->delete();
            return redirect()->route('unidades_medida.index')->with('sucess', 'Item deletado!!!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
