<?php

namespace App\Http\Controllers;

use App\Http\Requests\DadoConsumoCreateUpdate;
use App\Models\DadoConsumo;
use App\Models\Tanque;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class DadoConsumoController extends Controller
{
    public function index(): View
    {
        $dados = DadoConsumo::paginate(perPage: 10);
        return view(view: 'dados.index', data: compact(var_name: 'dados'));
    }

    public function create(): View
    {
        $tanques = Tanque::all();
        return view(view: 'dados.create', data: compact(var_name: 'tanques'));
    }

    public function edit(int $id): View
    {
        $dado = DadoConsumo::findOrFail(id: $id);
        $tanques = Tanque::all();
        return view(view: 'dados.edit', data: compact(var_name: ['dado','tanques']));
    }

    public function store(DadoConsumoCreateUpdate $request): RedirectResponse
    {
        try {
            $dado = DadoConsumo::create(attributes: $request->all());
            return redirect()->route(route: 'dados_consumo.index')->with(key: 'sucess', value: 'Dado para o tanque: ' . $dado->tanque->id_externo . ' criado!!!');
        } catch (\Exception $e) {
            return back()->with(key: 'error', value: $e->getMessage())->withInput(input: request()->all());
        }
    }

    public function storeAPI(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate(rules: [
                'data_hora' => 'required|date',
                'nivel' => 'required|numeric',
                'tanque_id' => 'required|exists:tanques,id',
            ]);
            $dado = DadoConsumo::create(attributes: $validated);
            return response()->json(data: $dado, status: 201);
        } catch (\Exception $e) {
            return response()->json(data: [
                'status' => 'error',
                'message' => $e->getMessage(),
            ], status: 500);
        }
    }

    public function update(DadoConsumoCreateUpdate $request, $id): RedirectResponse
    {
        try {
            $dado = DadoConsumo::findOrFail(id: $id);
            $dado->update($request->all());
            return redirect()->route(route: 'dados_consumo.index')->with(key: 'sucess', value: 'Dado para o tanque: ' . $dado->tanque->id_externo . ' alterado!!!');
        } catch (\Exception $e) {
            return back()->with(key: 'error', value: $e->getMessage())->withInput(input: request()->all());
        }
    }

    public function updateAPI(Request $request, DadoConsumo $dado): JsonResponse
    {
        try {
            $validated = $request->validate(rules: [
                'data_hora' => 'required|date',
                'nivel' => 'required|numeric',
                'tanque_id' => 'required|exists:tanques,id',
            ]);
            $dado->update(attributes: $validated);
            return response()->json(data: $dado, status: 200);
        } catch (\Exception $e) {
            return response()->json(data: [
                'status' => 'error',
                'message' => $e->getMessage(),
            ], status: 500);
        }
    }

    public function delete($id): RedirectResponse
    {
        try {
            $dado = DadoConsumo::findOrFail($id);
            $dado->delete();
            return redirect()->route(route: 'dados_consumo.index')->with(key: 'sucess', value: 'Item deletado!!!');
        } catch (\Exception $e) {
            return back()->with(key: 'error', value: $e->getMessage());
        }
    }

    public function deleteAPI($id): JsonResponse
    {
        try {
            $dado = DadoConsumo::findOrFail(id: $id);
            $dado->delete();
            return response()->json(data: null, status: 204);
        } catch (\Exception $e) {
            return response()->json(data: [
                'status' => 'error',
                'message' => $e->getMessage(),
            ], status: 500);
        }
    }
}
