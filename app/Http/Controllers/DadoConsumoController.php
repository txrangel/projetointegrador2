<?php

namespace App\Http\Controllers;

use App\Models\DadoConsumo;
use App\Models\Tanque;
use Illuminate\Http\Request;

class DadoConsumoController extends Controller
{
    public function index()
    {
        $dados = DadoConsumo::paginate(10);
        return view('dados.index', compact('dados'));
    }

    public function create()
    {
        $tanques = Tanque::all();
        return view('dados.create', compact('tanques'));
    }

    public function edit($id)
    {
        $dado = DadoConsumo::findOrFail($id);
        $tanques = Tanque::all();
        return view('dados.edit', compact(['dado','tanques']));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'data_hora' => 'required|date',
                'nivel' => 'required|numeric',
                'tanque_id' => 'required|exists:tanques,id',
            ]);
            $dado = DadoConsumo::create($validated);
            return response()->json($dado, 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, DadoConsumo $dado)
    {
        try {
            $validated = $request->validate([
                'data_hora' => 'required|date',
                'nivel' => 'required|numeric',
                'tanque_id' => 'required|exists:tanques,id',
            ]);
            $dado->update($validated);
            return response()->json($dado, 200);
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
            $dado = DadoConsumo::findOrFail($id);
            $dado->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
