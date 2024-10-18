<?php

namespace App\Http\Controllers;

use App\Models\Planta;
use App\Models\Tanque;
use App\Models\UnidadeDeMedida;
use Illuminate\Http\Request;

class TanqueController extends Controller
{
    public function index()
    {
        
        $tanques = Tanque::paginate(10);
        return view('tanques.index', compact('tanques'));
    }
    public function create()
    {
        $plantas = Planta::all();
        $unidadesDeMedidas= UnidadeDeMedida::all();
        return view('tanques.create',compact(['plantas','unidadesDeMedidas']));
    }
    public function edit($id)
    {
        $plantas = Planta::all();
        $unidadesDeMedidas= UnidadeDeMedida::all();
        $tanque = Tanque::findOrFail($id);
        return view('tanques.edit', compact(['tanque','plantas','unidadesDeMedidas']));
    }
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'planta_id' => 'required|exists:plantas,id',
                'maximo' => 'required|numeric',
                'minimo' => 'required|numeric',
                'unidade_de_medida_id' => 'required|exists:unidades_de_medidas,id',
                'id_externo' => 'required|string',
            ]);
            $tanque = Tanque::create($validated);
            return response()->json($tanque, 201);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput(request()->all());
        }
    }
    public function update(Request $request, Tanque $tanque)
    {
        try {
            $validated = $request->validate([
                'planta_id' => 'exists:plantas,id',
                'maximo' => 'required|numeric',
                'minimo' => 'required|numeric',
                'unidade_de_medida_id' => 'required|exists:unidades_de_medidas,id',
                'id_externo' => 'required|string',
            ]);
            $tanque->update($validated);
            return response()->json($tanque, 200);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput(request()->all());
        }
    }
    public function delete($id)
    {
        try {
            $tanque = Tanque::findOrFail($id);
            $tanque->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput(request()->all());
        }
    }
}
