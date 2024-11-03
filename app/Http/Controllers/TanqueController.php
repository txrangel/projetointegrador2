<?php

namespace App\Http\Controllers;

use App\Http\Requests\TanqueCreateUpdate;
use App\Models\EstoqueFuturo;
use App\Models\Planta;
use App\Models\Tanque;
use App\Models\UnidadeDeMedida;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
class TanqueController extends Controller
{
    public function index(): View
    {
        $tanques = Tanque::paginate(perPage: 10);
        return view(view: 'tanques.index', data: compact(var_name: 'tanques'));
    }
    public function create(): View
    {
        $plantas = Planta::all();
        $unidadesDeMedidas= UnidadeDeMedida::all();
        return view(view: 'tanques.create',data: compact(var_name: ['plantas','unidadesDeMedidas']));
    }
    public function edit(int $id): View
    {
        $plantas = Planta::all();
        $unidadesDeMedidas= UnidadeDeMedida::all();
        $tanque = Tanque::findOrFail(id: $id);
        return view(view: 'tanques.edit', data: compact(var_name: ['tanque','plantas','unidadesDeMedidas']));
    }
    public function store(TanqueCreateUpdate $request): RedirectResponse
    {
        try {
            $ponto_de_pedido = $request->ponto_de_pedido;
            $ponto_de_entrega = $request->ponto_de_entrega;
            if($ponto_de_pedido){
                $ponto_de_entrega = $ponto_de_pedido - ($request->lead_time * $request->consumo_medio);
            }else if($ponto_de_entrega){
                $ponto_de_pedido = $ponto_de_entrega + ($request->lead_time * $request->consumo_medio);
            }else{
                return back()->with(key: 'error', value: 'Sem dados')->withInput(input: request()->all());
            }
            $tanque = Tanque::create(
    attributes: [                
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
            // Fazer a requisição na rota 'estoque-futuro.store'
            $response = $this->EstoqueFuturoStore(id: $tanque->id);
            // Verificar se a requisição foi bem-sucedida
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
            $tanque = Tanque::findOrFail(id: $id);
            $ponto_de_pedido = $request->ponto_de_pedido;
            $ponto_de_entrega = $request->ponto_de_entrega;
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
            // Fazer a requisição na rota 'estoque-futuro.store'
            $response = $this->EstoqueFuturoStore(id: $tanque->id);
            // Verificar se a requisição foi bem-sucedida
            if ($response->getStatusCode() == 201) {
                return redirect()->route(route: 'tanques.index')->with('success', value: $tanque->id_externo . ' alterado e estoque futuro atualizado!!!');
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
    public function dashboard(): View
    { 
        $tanquesModel = Tanque::with(relations: 'EstoqueFuturo')->get();  // Carrega a relação 'dadosConsumo'
        $tanques = [];
        foreach ($tanquesModel as $tanque) {
            $EstoqueFuturo = $tanque->EstoqueFuturo->map(function($estoque): array {
                return [
                    'nivel' => $estoque->nivel,  // Substitua 'nivel' pelo campo correto
                    'data' => $estoque->data // Ou outros dados que precisar
                ];
            });
            $tanques[] = [
                'nome' => $tanque->id_externo,
                'dados'=> $EstoqueFuturo,  // Aqui estará o array de níveis
            ];
        }
        return view(view: 'dashboard', data: compact(var_name: 'tanques'));
    }

    private function EstoqueFuturoStore(int $id): JsonResponse
    {
        try {
            // 1. Encontrar o tanque pelo ID
            $tanque = Tanque::findOrFail(id: $id);
            // 2. Excluir todos os dados de estoque relacionados ao tanque
            $tanque->estoqueFuturo()->delete();//INATIVAR
            // 3. Inicializar o nível do estoque com o estoque atual do tanque
            $nivelEstoque = $tanque->estoque_atual;
            // 4. Definir o ponto de pedido e entrega com base nas regras
            $pontoPedido        = $tanque->ponto_de_pedido;
            $pontoEntrega       = $tanque->ponto_de_entrega;
            $qtdEntregaPadrao   = $tanque->qtd_entrega_padrao;
            $consumo_medio      = $tanque->consumo_medio;
            $maximo             = $tanque->maximo;
            $criou_pedido       = false;
            $entregue = false;
            // 5. Criar os dados de estoque para os próximos 30 dias
            $nivel              = 0;
            for ($i = 0; $i < 30; $i++) {
                $data               = now()->addDays($i);
                $pontoPedidoValido  = false;
                $pontoEntregaValido = false;
                if($i == 0) {
                    // No primeiro dia, o nível do estoque é igual ao estoque atual
                    $nivel = $nivelEstoque;
                }else{
                    // Para os dias subsequentes, calcular o nível do estoque
                    $nivel -= $consumo_medio;
                }
                // Verificar ponto de pedido e ponto de entrega
                if ($nivel <= $pontoPedido && $criou_pedido==false) {
                    $pontoPedidoValido = true;
                    $criou_pedido = true;
                    //CRIAR UM PEDIDO NA TABELA DEPEDIDOS
                }
                // Definir se o ponto de entrega deve ser ativado
                if ($nivel <= $pontoEntrega) {
                    $pontoEntregaValido = true;
                }
                if ($pontoEntregaValido) {
                    if($nivel+$qtdEntregaPadrao<=$maximo){
                        $nivel += $qtdEntregaPadrao;
                        $criou_pedido = false;
                        $entregue = true;
                        //CRIAR UMA ENTREGA NA TABELA DE ENTREGAS
                    }
                }
                // 6. Criar um novo registro de estoque
                EstoqueFuturo::create(attributes: [
                    'data'          => $data,
                    'nivel'         => $nivel,
                    'tanque_id'     => $tanque->id,
                    'ponto_pedido'  => $pontoPedidoValido,
                    'ponto_entrega' => $pontoEntregaValido,
                ]);
            }
            // 7. Redirecionar ou retornar uma resposta de sucesso
            return response()->json(data: null, status: 201);
        } catch (\Exception $e) {
            // Em caso de erro, retornar com mensagem de erro
            return response()->json(data: [
                'status' => 'error',
                'message' => $e->getMessage(),
            ], status: 500);
        }
    }
}
