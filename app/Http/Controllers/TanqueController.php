<?php

namespace App\Http\Controllers;

use App\Http\Requests\TanqueCreateUpdate;
use App\Models\EntregasFuturas;
use App\Models\EstoqueFuturo;
use App\Models\PedidosFuturos;
use App\Models\Planta;
use App\Models\Tanque;
use App\Models\UnidadeDeMedida;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Log;
class TanqueController extends Controller
{
    public function index(): View
    {
        $tanques = Tanque::paginate(perPage: 10);
        return view(view: 'tanques.index', data: compact(var_name: 'tanques'));
    }
    public function create(): View
    {
        $plantas            = Planta::all();
        $unidadesDeMedidas  = UnidadeDeMedida::all();
        return view(view: 'tanques.create',data: compact(var_name: ['plantas','unidadesDeMedidas']));
    }
    public function edit(int $id): View
    {
        $plantas            = Planta::all();
        $unidadesDeMedidas  = UnidadeDeMedida::all();
        $tanque             = Tanque::findOrFail(id: $id);
        return view(view: 'tanques.edit', data: compact(var_name: ['tanque','plantas','unidadesDeMedidas']));
    }
    public function store(TanqueCreateUpdate $request): RedirectResponse
    {
        try {
            $ponto_de_pedido    = $request->ponto_de_pedido;
            $ponto_de_entrega   = $request->ponto_de_entrega;
            if($ponto_de_pedido){
                $ponto_de_entrega = $ponto_de_pedido - ($request->lead_time * $request->consumo_medio);
            }else if($ponto_de_entrega){
                $ponto_de_pedido = $ponto_de_entrega + ($request->lead_time * $request->consumo_medio);
            }else{
                return back()->with(key: 'error', value: 'Sem dados')->withInput(input: request()->all());
            }
            $tanque = Tanque::create(
                attributes: 
                    [                
                        'planta_id'             => $request->planta_id,
                        'maximo'                => $request->maximo,
                        'minimo'                => $request->minimo,
                        'estoque_atual'         => $request->estoque_atual,
                        'consumo_medio'         => $request->consumo_medio,
                        'qtd_entrega_padrao'    => $request->qtd_entrega_padrao,
                        'lead_time'             => $request->lead_time,
                        'unidade_de_medida_id'  => $request->unidade_de_medida_id,
                        'id_externo'            => $request->id_externo,
                        'ponto_de_pedido'       => $ponto_de_pedido,
                        'ponto_de_entrega'      => $ponto_de_entrega,
                    ]
            );        
            $response = $this->EstoqueFuturoStore(id: $tanque->id);
            if ($response->getStatusCode() == 201) {
                return redirect()->route(route: 'tanques.index')->with(key: 'success', value: $tanque->id_externo . ' criado e estoque futuro atualizado!!!');
            } else {
                return back()->with(key: 'error', value: 'Erro ao atualizar o estoque futuro: ' . $response->body())->withInput(input: request()->all());
            }
        } catch (\Exception $e) {
            return back()->with(key: 'error', value: $e->getMessage())->withInput(input: request()->all());
        }
    }
    public function update(TanqueCreateUpdate $request, int $id): RedirectResponse
    {
        try {
            $tanque             = Tanque::findOrFail(id: $id);
            $ponto_de_pedido    = $request->ponto_de_pedido;
            $ponto_de_entrega   = $request->ponto_de_entrega;
            if($ponto_de_pedido){
                $ponto_de_entrega = $ponto_de_pedido - ($request->lead_time * $request->consumo_medio);
            }else if($ponto_de_entrega){
                $ponto_de_pedido = $ponto_de_entrega + ($request->lead_time * $request->consumo_medio);
            }else{
                return back()->with(key: 'error', value: 'Sem dados')->withInput(input: request()->all());
            }
            $tanque->update(
                [                
                    'planta_id'             => $request->planta_id,
                    'maximo'                => $request->maximo,
                    'minimo'                => $request->minimo,
                    'estoque_atual'         => $request->estoque_atual,
                    'consumo_medio'         => $request->consumo_medio,
                    'qtd_entrega_padrao'    => $request->qtd_entrega_padrao,
                    'lead_time'             => $request->lead_time,
                    'unidade_de_medida_id'  => $request->unidade_de_medida_id,
                    'id_externo'            => $request->id_externo,
                    'ponto_de_pedido'       => $ponto_de_pedido,
                    'ponto_de_entrega'      => $ponto_de_entrega,
                ]
            );  
            $response = $this->EstoqueFuturoStore(id: $tanque->id);
            if ($response->getStatusCode() == 201) {
                return redirect()->route(route: 'tanques.index')->with(key: 'success', value: $tanque->id_externo . ' alterado e estoque futuro atualizado!!!');
            } else {
                return back()->with(key: 'error', value: 'Erro ao atualizar o estoque futuro: ' . $response->body())->withInput(input: request()->all());
            }
        } catch (\Exception $e) {
            return back()->with(key: 'error', value: $e->getMessage())->withInput(input: request()->all());
        }
    }
    public function delete($id): RedirectResponse
    {
        try {
            $tanque = Tanque::findOrFail(id: $id);
            $tanque->estoqueFuturo()->delete();
            $tanque->delete();
            return redirect()->route(route: 'tanques.index')->with(key: 'sucess', value: 'Item deletado!!!');
        } catch (\Exception $e) {
            return back()->with(key: 'error', value: $e->getMessage());
        }
    }
    public function dados(int $id): View
    { 
        $tanque     = Tanque::findOrFail(id: $id);
        // $tanque = [
        //     'pedidos'   => $tanqueModel->pedidos,
        //     'entregas'  => $tanqueModel->entregas,
        //     'nome'      => $tanqueModel->id_externo,
        //     'dados'     => $tanqueModel->EstoqueFuturo,
        //     'minimo'    => $tanqueModel->minimo,
        //     'maximo'    => $tanqueModel->maximo,
        // ];
        //dd($tanque);
        return view(view: 'tanques.dados', data: compact(var_name: 'tanque'));
    }
    private function EstoqueFuturoStore(int $id): JsonResponse
    {
        try {
            $tanque = Tanque::findOrFail($id);
            
            $tanque->estoqueFuturo()->delete();
            $tanque->pedidos()->delete();
            $tanque->entregas()->delete();
            $nivelEstoque = $tanque->estoque_atual;
            
            $criou_pedido           = false;
            $PontoDePedidoValido    = false;
            $PontoDeEntregaValido   = false;
            $nivel                  = 0;
            $dataEntrega            = now()->addDays(value: 0);

            for ($i = 0; $i < 30; $i++) {
                $PontoDePedidoValido    = false;
                $data                   = now()->addDays($i);
                $nivel                  = $i == 0 ? $nivelEstoque : $nivel - $tanque->consumo_medio;

                // Atualize entrega quando a data coincidir
                if ($data->isSameDay(date: $dataEntrega) && $criou_pedido) {
                    $PontoDeEntregaValido   = true;
                    $criou_pedido           = false;
                    $entrega = EntregasFuturas::create(attributes: [
                        'tanque_id'     => $tanque->id,
                        'nivel_atual'   => $nivel,
                        'quantidade'    => $pedido->quantidade,
                        'data'          => $data,
                    ]);
                }

                //Verifique se há uma entrega existente e atualize o nível
                if ($PontoDeEntregaValido) {
                    if ($nivel + $entrega->quantidade <= $tanque->maximo){
                        //dd($nivel,$entrega->quantidade);
                        $PontoDeEntregaValido   = false;
                        $nivel                  += $entrega->quantidade;
                    }
                }

                // Verifica se é necessário criar um pedido
                if ($nivel < $tanque->ponto_de_pedido && !$criou_pedido && !$PontoDeEntregaValido) {//acho que ta errado
                    $PontoDePedidoValido    = true;
                    $criou_pedido           = true;
                    $dataEntrega            = $data->copy()->addDays(value: $tanque->lead_time);
                    $quantidade_padrao      = intdiv(num1: ($tanque->maximo - $nivel),num2: $tanque->qtd_entrega_padrao) < 1 ? 1 : intdiv(num1: ($tanque->maximo - $nivel),num2: $tanque->qtd_entrega_padrao);
                    $quantidade             = $tanque->qtd_entrega_padrao * 1;//$quantidade_padrao;

                    $pedido = PedidosFuturos::create(attributes: [
                        'tanque_id'     => $tanque->id,
                        'nivel_atual'   => $nivel,
                        'quantidade'    => $quantidade,
                        'data'          => $data,
                    ]);

                    
                }

                // Cria o registro de Estoque Futuro
                EstoqueFuturo::create(attributes: [
                    'data'          => $data,
                    'nivel'         => $nivel,
                    'tanque_id'     => $tanque->id,
                    'ponto_pedido'  => $PontoDePedidoValido,
                    'ponto_entrega' => $PontoDeEntregaValido,
                ]);
            }
            
            return response()->json(data: null, status: 201);
        } catch (\Throwable $e) {
            Log::error(message: "Erro ao criar estoque futuro: " . $e->getMessage());
            
            return response()->json(data: [
                'status' => 'error',
                'message' => $e->getMessage(),
            ], status: 500);
        }
    }

}
