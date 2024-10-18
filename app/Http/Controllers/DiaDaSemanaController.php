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
            return response()->json($dia, 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
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
            return response()->json($dia, 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function delete($id)
    {
        try {
            $dia = DiaDaSemana::findOrFail($id);
            $dia->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
