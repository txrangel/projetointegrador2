<?php

namespace App\Http\Controllers;

use App\Http\Requests\DiaDaSemanaCreateUpdate;
use App\Models\DiaDaSemana;
use Illuminate\Http\Request;

class DiaDaSemanaController extends Controller
{
    public function index()
    {
        $dias = DiaDaSemana::paginate(10);
        return view('dias.index', compact('dias'));
    }

    public function create()
    {
        return view('dias.create');
    }

    public function edit($id)
    {
        $dia = DiaDaSemana::findOrFail($id);
        return view('dias.edit', compact('dia'));
    }

    public function store(DiaDaSemanaCreateUpdate $request)
    {
        try {
            $dia = DiaDaSemana::create($request->all());
            return redirect()->route('dias_da_semana.index')->with('sucess', $dia->nome . ' criado!!!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput(request()->all());
        }
    }

    public function update(DiaDaSemanaCreateUpdate $request, $id)
    {
        try {
            $dia = DiaDaSemana::findOrFail($id);
            $dia->update($request->all());
            return redirect()->route('dias_da_semana.index')->with('sucess', $dia->nome . ' alterado!!!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput(request()->all());
        }
    }

    public function delete($id)
    {
        try {
            $dia = DiaDaSemana::findOrFail($id);
            $dia->delete();
            return redirect()->route('dias_da_semana.index')->with('sucess', 'Item deletado!!!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
