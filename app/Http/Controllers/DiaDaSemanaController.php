<?php

namespace App\Http\Controllers;

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

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'numero' => 'required|integer|unique:dias_da_semana',
                'nome' => 'required|string',
                'horario_inicio' => 'required',
                'horario_fim' => 'required',
            ]);
            $dia = DiaDaSemana::create($validated);
            return redirect()->route('dashboard')->with('sucess', $dia->nome . ' criado!!!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput(request()->all());
        }
    }

    public function update(Request $request, DiaDaSemana $dia)
    {
        try {
            $validated = $request->validate([
                'numero' => 'required|integer|unique:dias_da_semana',
                'nome' => 'required|string',
                'horario_inicio' => 'required',
                'horario_fim' => 'required',
            ]);
            $dia->update($validated);
            return redirect()->route('dashboard')->with('sucess', $dia->nome . ' alterado!!!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput(request()->all());
        }
    }

    public function delete($id)
    {
        try {
            $dia = DiaDaSemana::findOrFail($id);
            $dia->delete();
            return redirect()->route('dashboard')->with('sucess', 'Item deletado!!!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
