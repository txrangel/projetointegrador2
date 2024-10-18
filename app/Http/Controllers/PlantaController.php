<?php

namespace App\Http\Controllers;

use App\Models\DiaDaSemana;
use App\Models\Planta;
use App\Models\PlantaPorDiaDaSemana;
use Illuminate\Http\Request;

class PlantaController extends Controller
{
    // Exibir todas as plantas
    public function index()
    {
        $plantas = Planta::with('diasDaSemana')->paginate(10); // Carregar também os dias da semana
        return view('plantas.index', compact('plantas'));
    }

    // Formulário para criar uma nova planta
    public function create()
    {
        $diasDaSemana = DiaDaSemana::all();  // Carregar todos os dias da semana
        return view('plantas.create', compact('diasDaSemana'));
    }

    // Armazenar uma nova planta e seus vínculos com dias da semana
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nome' => 'required|string|max:255',
                'endereco' => 'required|string|max:255',
                'cep' => 'required|string|max:8',
                'maximo_carretas' => 'required|numeric',
                'maximo_entregas' => 'required|numeric',
                'qtd_entrega_padrao' => 'required|numeric',
                'dias_da_semana' => 'array',  // Garantir que os dias da semana estão selecionados
                'dias_da_semana.*' => 'exists:dias_da_semana,id',  // Validar os IDs dos dias
            ]);
            // Criar a planta
            $planta = Planta::create($validated);
            // Salvar os dias da semana associados à planta
            foreach ($request->dias_da_semana as $diaId) {
                PlantaPorDiaDaSemana::create([
                    'planta_id' => $planta->id,
                    'dia_da_semana_id' => $diaId,
                ]);
            }
            return redirect()->route('plantas.index')->with('sucess', $planta->nome . ' criado!!!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput(request()->all());
        }
    }

    // Formulário para editar uma planta
    public function edit($id)
    {
        $planta = Planta::with('diasDaSemana')->findOrFail($id);
        $diasDaSemana = DiaDaSemana::all();  // Carregar todos os dias da semana

        // Retorna a planta e os dias da semana, com os dias vinculados já selecionados
        return view('plantas.edit', compact('planta', 'diasDaSemana'));
    }

    // Atualizar uma planta e seus vínculos com dias da semana
    public function update(Request $request, $id)
    {
        try {
            $planta = Planta::findOrFail($id);
            $validated = $request->validate([
                'nome' => 'required|string|max:255',
                'endereco' => 'required|string|max:255',
                'cep' => 'required|string|max:8',
                'maximo_carretas' => 'required|numeric',
                'maximo_entregas' => 'required|numeric',
                'qtd_entrega_padrao' => 'required|numeric',
                'dias_da_semana' => 'array',  // Garantir que os dias da semana estão selecionados
                'dias_da_semana.*' => 'exists:dias_da_semana,id',  // Validar os IDs dos dias
            ]);
            $planta->update($validated);       // Buscar a planta e atualizar
            // Remover os vínculos antigos
            PlantaPorDiaDaSemana::where('planta_id', $planta->id)->delete();

            // Adicionar os novos vínculos
            foreach ($request->dias_da_semana as $diaId) {
                PlantaPorDiaDaSemana::create([
                    'planta_id' => $planta->id,
                    'dia_da_semana_id' => $diaId,
                ]);
            }
            return redirect()->route('plantas.index')->with('sucess', $planta->nome . ' alterado!!!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput(request()->all());
        }
    }

    // Excluir uma planta e seus vínculos
    public function delete($id)
    {
        try {
            $planta = Planta::findOrFail($id);
            // Remover todos os vínculos com dias da semana
            PlantaPorDiaDaSemana::where('planta_id', $planta->id)->delete();
            // Excluir a planta
            $planta->delete();
            return redirect()->route('plantas.index')->with('sucess', 'Item deletado!!!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
