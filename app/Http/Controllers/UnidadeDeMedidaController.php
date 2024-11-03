<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnidadeDeMedidaCreateUpdate;
use App\Models\UnidadeDeMedida;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UnidadeDeMedidaController extends Controller
{
    public function index(): View
    {
        $unidades = UnidadeDeMedida::paginate(perPage: 10);
        return view(view: 'unidades.index', data: compact(var_name: 'unidades'));
    }

    public function create(): View
    {
        return view(view: 'unidades.create');
    }

    public function edit($id): View
    {
        $unidade = UnidadeDeMedida::findOrFail(id: $id);
        return view(view: 'unidades.edit', data: compact(var_name: 'unidade'));
    }

    public function store(UnidadeDeMedidaCreateUpdate $request): RedirectResponse
    {
        try {
            $unidade = UnidadeDeMedida::create(attributes: $request->all());
            return redirect()->route(route: 'unidades_medida.index')->with(key: 'sucess', value: $unidade->nome . ' criado!!!');
        } catch (\Exception $e) {
            return back()->with(key: 'error', value: $e->getMessage())->withInput(input: request()->all());
        }
    }

    public function update(UnidadeDeMedidaCreateUpdate $request, $id): RedirectResponse
    {
        try {
            $unidade = UnidadeDeMedida::findOrFail(id: $id);
            $unidade->update($request->all());
            return redirect()->route(route: 'unidades_medida.index')->with(key: 'sucess', value: $unidade->nome . ' alterado!!!');
        } catch (\Exception $e) {
            return back()->with(key: 'error', value: $e->getMessage())->withInput(input: request()->all());
        }
    }

    public function delete($id): RedirectResponse
    {
        try {
            $unidade = UnidadeDeMedida::findOrFail(id: $id);
            $unidade->delete();
            return redirect()->route(route: 'unidades_medida.index')->with(key: 'sucess', value: 'Item deletado!!!');
        } catch (\Exception $e) {
            return back()->with(key: 'error', value: $e->getMessage());
        }
    }
}
