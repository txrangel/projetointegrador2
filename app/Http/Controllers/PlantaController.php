<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlantaCreateUpdate;
use App\Models\DiaDaSemana;
use App\Models\Planta;
use App\Models\PlantaPorDiaDaSemana;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
class PlantaController extends Controller
{
    // Exibir todas as plantas
    public function index(): View
    {
        $plantas = Planta::with(relations: 'diasDaSemana')->paginate(perPage: 10); // Carregar também os dias da semana
        return view(view: 'plantas.index', data: compact(var_name: 'plantas'));
    }

    // Formulário para criar uma nova planta
    public function create(): View
    {
        $diasDaSemana = DiaDaSemana::all();  // Carregar todos os dias da semana
        return view(view: 'plantas.create', data: compact(var_name: 'diasDaSemana'));
    }

    // Armazenar uma nova planta e seus vínculos com dias da semana
    public function store(PlantaCreateUpdate $request): RedirectResponse
    {
        try {
            // Criar a planta
            $planta = Planta::create(attributes: $request->all());
            // Salvar os dias da semana associados à planta
            foreach ($request->dias_da_semana as $diaId) {
                PlantaPorDiaDaSemana::create(attributes: [
                    'planta_id' => $planta->id,
                    'dia_da_semana_id' => $diaId,
                ]);
            }
            return redirect()->route(route: 'plantas.index')->with(key: 'sucess', value: $planta->nome . ' criado!!!');
        } catch (\Exception $e) {
            return back()->with(key: 'error', value: $e->getMessage())->withInput(input: request()->all());
        }
    }

    // Formulário para editar uma planta
    public function edit($id): View
    {
        $planta = Planta::with(relations: 'diasDaSemana')->findOrFail(id: $id);
        $diasDaSemana = DiaDaSemana::all();  // Carregar todos os dias da semana

        // Retorna a planta e os dias da semana, com os dias vinculados já selecionados
        return view(view: 'plantas.edit', data: compact(var_name: 'planta', var_names: 'diasDaSemana'));
    }

    // Atualizar uma planta e seus vínculos com dias da semana
    public function update(PlantaCreateUpdate $request, $id): RedirectResponse
    {
        try {
            $planta = Planta::findOrFail(id: $id);
            $planta->update($request->all());       // Buscar a planta e atualizar
            // Remover os vínculos antigos
            PlantaPorDiaDaSemana::where(column: 'planta_id', operator: $planta->id)->delete();

            // Adicionar os novos vínculos
            foreach ($request->dias_da_semana as $diaId) {
                PlantaPorDiaDaSemana::create(attributes: [
                    'planta_id' => $planta->id,
                    'dia_da_semana_id' => $diaId,
                ]);
            }
            return redirect()->route(route: 'plantas.index')->with(key: 'sucess', value: $planta->nome . ' alterado!!!');
        } catch (\Exception $e) {
            return back()->with(key: 'error', value: $e->getMessage())->withInput(input: request()->all());
        }
    }

    // Excluir uma planta e seus vínculos
    public function delete($id): RedirectResponse
    {
        try {
            $planta = Planta::findOrFail(id: $id);
            // Remover todos os vínculos com dias da semana
            PlantaPorDiaDaSemana::where(column: 'planta_id', operator: $planta->id)->delete();
            // Excluir a planta
            $planta->delete();
            return redirect()->route(route: 'plantas.index')->with(key: 'sucess', value: 'Item deletado!!!');
        } catch (\Exception $e) {
            return back()->with(key: 'error', value: $e->getMessage());
        }
    }
}
