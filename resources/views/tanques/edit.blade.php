@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100"> {{ __('Editar Tanque') }} </h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Atualize as informações do tanque.') }} </p>
                        </header>
                        <form method="post" action="{{ route('tanques.update', $tanque->id) }}" class="mt-6 space-y-6">
                            @csrf
                            @method('PUT') <!-- Método PUT para atualização -->
                            <div>
                                <x-input-label for="planta_id" :value="__('Planta')" />
                                <select id="planta_id" name="planta_id" class="mt-1 block w-full" required>
                                    <option value="">Selecione uma planta</option>
                                    @foreach ($plantas as $planta)
                                        <option value="{{ $planta->id }}" {{ $tanque->planta_id == $planta->id ? 'selected' : '' }}>
                                            {{ $planta->nome }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('planta_id')" />
                            </div>
                            <div>
                                <x-input-label for="unidade_de_medida_id" :value="__('Unidade de Medida')" />
                                <select id="unidade_de_medida_id" name="unidade_de_medida_id" class="mt-1 block w-full" required>
                                    <option value="">Selecione uma unidade de medida</option>
                                    @foreach ($unidadesDeMedidas as $unidade)
                                        <option value="{{ $unidade->id }}" {{ $tanque->unidade_de_medida_id == $unidade->id ? 'selected' : '' }}>
                                            {{ $unidade->nome }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('unidade_de_medida_id')" />
                            </div>
                            <div>
                                <x-input-label for="id_externo" :value="__('ID Externo')" />
                                <x-text-input id="id_externo" name="id_externo" type="text" class="mt-1 block w-full" :value="old('id_externo', $tanque->id_externo)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('id_externo')" />
                            </div>
                            <div>
                                <x-input-label for="maximo" :value="__('Máximo')" />
                                <x-text-input id="maximo" name="maximo" type="text" oninput="this.value = this.value.replace(/[^0-9]/g, '');" class="mt-1 block w-full" :value="old('maximo', $tanque->maximo)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('maximo')" />
                            </div>
                            <div>
                                <x-input-label for="minimo" :value="__('Mínimo')" />
                                <x-text-input id="minimo" name="minimo" type="text" oninput="this.value = this.value.replace(/[^0-9]/g, '');" class="mt-1 block w-full" :value="old('minimo', $tanque->minimo)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('minimo')" />
                            </div>
                            <div>
                                <x-input-label for="estoque_atual" :value="__('Estoque Atual')" />
                                <x-text-input id="estoque_atual" name="estoque_atual" type="text" oninput="this.value = this.value.replace(/[^0-9]/g, '');" class="mt-1 block w-full" :value="old('estoque_atual', $tanque->estoque_atual)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('estoque_atual')" />
                            </div>
                            <div>
                                <x-input-label for="consumo_medio" :value="__('Consumo Médio')" />
                                <x-text-input id="consumo_medio" name="consumo_medio" type="text" oninput="this.value = this.value.replace(/[^0-9]/g, '');" class="mt-1 block w-full" :value="old('consumo_medio', $tanque->consumo_medio)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('consumo_medio')" />
                            </div>
                            <div>
                                <x-input-label for="lead_time" :value="__('Lead Time')" />
                                <x-text-input id="lead_time" name="lead_time" type="text" oninput="this.value = this.value.replace(/[^0-9]/g, '');" class="mt-1 block w-full" :value="old('lead_time', $tanque->lead_time)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('lead_time')" />
                            </div>
                            <div>
                                <x-input-label for="qtd_entrega_padrao" :value="__('Quantidade de Entregas Padrão')" />
                                <x-text-input id="qtd_entrega_padrao" name="qtd_entrega_padrao" type="text" oninput="this.value = this.value.replace(/[^0-9]/g, '');" class="mt-1 block w-full" :value="old('qtd_entrega_padrao', $tanque->qtd_entrega_padrao)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('qtd_entrega_padrao')" />
                            </div>
                            <h1>Ponto de pedido fixo ou relativo?</h1>
                            <div>
                                <label>
                                    <input type="radio" name="tipo_ponto_pedido" value="fixo" onclick="toggleFields()" {{ $tanque->tipo_ponto_pedido === 'fixo' ? 'checked' : '' }}> Fixo
                                </label>
                                <label class="ml-4">
                                    <input type="radio" name="tipo_ponto_pedido" value="relativo" onclick="toggleFields()" {{ $tanque->tipo_ponto_pedido === 'relativo' ? 'checked' : '' }}> Relativo
                                </label>
                            </div>
                            <div id="pontoPedidoContainer" style="{{ $tanque->tipo_ponto_pedido === 'fixo' ? 'display:block;' : 'display:none;' }}">
                                <x-input-label for="ponto_de_pedido" :value="__('Ponto de Pedido')" />
                                <x-text-input id="ponto_de_pedido" name="ponto_de_pedido" type="text" oninput="this.value = this.value.replace(/[^0-9]/g, '');" class="mt-1 block w-full" :value="old('ponto_de_pedido', $tanque->ponto_de_pedido)" />
                                <x-input-error class="mt-2" :messages="$errors->get('ponto_de_pedido')" />
                            </div>
                            <div id="pontoEntregaContainer" style="{{ $tanque->tipo_ponto_pedido === 'relativo' ? 'display:block;' : 'display:none;' }}">
                                <x-input-label for="ponto_de_entrega" :value="__('Ponto de Entrega')" />
                                <x-text-input id="ponto_de_entrega" name="ponto_de_entrega" type="text" oninput="this.value = this.value.replace(/[^0-9]/g, '');" class="mt-1 block w-full" :value="old('ponto_de_entrega', $tanque->ponto_de_entrega)" />
                                <x-input-error class="mt-2" :messages="$errors->get('ponto_de_entrega')" />
                            </div>
                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Atualizar Tanque') }}</x-primary-button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
    <script>
        function toggleFields() {
            const tipoPontoPedido = document.querySelector('input[name="tipo_ponto_pedido"]:checked').value;
            const pontoPedidoContainer = document.getElementById('pontoPedidoContainer');
            const pontoEntregaContainer = document.getElementById('pontoEntregaContainer');
            if (tipoPontoPedido === 'fixo') {
                pontoPedidoContainer.style.display = 'block';
                pontoEntregaContainer.style.display = 'none';
                document.getElementById('ponto_de_entrega').value = '';
            } else {
                pontoPedidoContainer.style.display = 'none';
                pontoEntregaContainer.style.display = 'block';
                document.getElementById('ponto_de_pedido').value = '';
            }
        }
    </script>
@endsection