<?php

namespace App\Http\Controllers;

use App\Http\Requests\DiaDaSemanaCreateUpdate;
use App\Models\DiaDaSemana;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
class DiaDaSemanaController extends Controller
{
    public function index(): View
    {
        $dias = DiaDaSemana::paginate(perPage: 10);
        return view(view: 'dias.index', data: compact(var_name: 'dias'));
    }

    public function create(): View
    {
        return view(view: 'dias.create');
    }

    public function edit($id): View
    {
        $dia = DiaDaSemana::findOrFail(id: $id);
        return view(view: 'dias.edit', data: compact(var_name: 'dia'));
    }

    public function store(DiaDaSemanaCreateUpdate $request): RedirectResponse
    {
        try {
            $dia = DiaDaSemana::create(attributes: $request->all());
            return redirect()->route(route: 'dias_da_semana.index')->with(key: 'sucess', value: $dia->nome . ' criado!!!');
        } catch (\Exception $e) {
            return back()->with(key: 'error', value: $e->getMessage())->withInput(input: request()->all());
        }
    }

    public function update(DiaDaSemanaCreateUpdate $request, $id): RedirectResponse
    {
        try {
            $dia = DiaDaSemana::findOrFail(id: $id);
            $dia->update($request->all());
            return redirect()->route(route: 'dias_da_semana.index')->with(key: 'sucess', value: $dia->nome . ' alterado!!!');
        } catch (\Exception $e) {
            return back()->with(key: 'error', value: $e->getMessage())->withInput(input: request()->all());
        }
    }

    public function delete($id): RedirectResponse
    {
        try {
            $dia = DiaDaSemana::findOrFail(id: $id);
            $dia->delete();
            return redirect()->route(route: 'dias_da_semana.index')->with(key: 'sucess', value: 'Item deletado!!!');
        } catch (\Exception $e) {
            return back()->with(key: 'error', value: $e->getMessage());
        }
    }
}
