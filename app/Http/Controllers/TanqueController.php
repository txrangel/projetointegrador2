<?php

namespace App\Http\Controllers;

use App\Http\Requests\TanqueCreateUpdate;
use App\Models\Planta;
use App\Models\Tanque;
use App\Models\UnidadeDeMedida;
use Carbon\Carbon;
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
    public function store(TanqueCreateUpdate $request)
    {
        try {
            dd($request->all());
            $tanque = Tanque::create($request->all());
            return redirect()->route('tanques.index')->with('sucess', $tanque->id_externo . ' criado!!!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput(request()->all());
        }
    }
    public function update(TanqueCreateUpdate $request, $id)
    {
        try {
            $tanque = Tanque::findOrFail($id);
            $tanque->update($request->all());
            return redirect()->route('tanques.index')->with('sucess', $tanque->id_externo . ' alterado!!!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput(request()->all());
        }
    }
    public function delete($id)
    {
        try {
            $tanque = Tanque::findOrFail($id);
            $tanque->delete();
            return redirect()->route('tanques.index')->with('sucess', 'Item deletado!!!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    public function dashboard()
    {
        $tanquesModel = Tanque::with('dadosConsumo')->get();  // Carrega a relação 'dadosConsumo'
        $tanques = [];
        
        foreach ($tanquesModel as $tanque) {
            $dadosConsumo = $tanque->dadosConsumo->map(function($dado) {
                return [
                    'nivel' => $dado->nivel,  // Substitua 'nivel' pelo campo correto
                    'data' => $dado->created_at // Ou outros dados que precisar
                ];
            });
        
            $tanques[] = [
                'nome' => $tanque->id_externo,
                'dados'=> $dadosConsumo,  // Aqui estará o array de níveis
            ];
        }
        
        //dd($tanques);
    
        return view('dashboard', compact('tanques'));
    }
}
