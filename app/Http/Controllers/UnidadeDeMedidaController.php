<?php

namespace App\Http\Controllers;

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

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nome' => 'required|string',
                'sigla' => 'required|string|unique:unidades_de_medidas',
            ]);
            $unidade = UnidadeDeMedida::create($validated);
            return response()->json($unidade, 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, UnidadeDeMedida $unidade)
    {
        try {
            $validated = $request->validate([
                'nome' => 'string',
                'sigla' => 'string|unique:unidades_de_medidas,sigla,' . $unidade->id,
            ]);
            $unidade->update($validated);
            return response()->json($unidade, 200);
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
            $unidade = UnidadeDeMedida::findOrFail($id);
            $unidade->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
