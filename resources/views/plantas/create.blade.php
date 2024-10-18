@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <div class="max-w-xl">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ __('Nova Planta') }}
                        </h2>
                
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            {{ __('Preencha as informações para criar uma nova planta.') }}
                        </p>
                    </header>
                
                    <form method="post" action="{{ route('plantas.store') }}" class="mt-6 space-y-6">
                        @csrf
                
                        <div>
                            <x-input-label for="nome" :value="__('Nome')" />
                            <x-text-input id="nome" name="nome" type="text" class="mt-1 block w-full" :value="old('nome')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('nome')" />
                        </div>

                        <div>
                            <x-input-label for="endereco" :value="__('Endereço')" />
                            <x-text-input id="endereco" name="endereco" type="text" class="mt-1 block w-full" :value="old('endereco')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('endereco')" />
                        </div>

                        <div>
                            <x-input-label for="cep" :value="__('CEP')" />
                            <x-text-input id="cep" name="cep" type="text" class="mt-1 block w-full" :value="old('cep')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('cep')" />
                        </div>

                        <div>
                            <x-input-label for="maximo_carretas" :value="__('Máximo de Carretas')" />
                            <x-text-input id="maximo_carretas" name="maximo_carretas" type="text" oninput="this.value = this.value.replace(/[^0-9]/g, '');" class="mt-1 block w-full" :value="old('maximo_carretas')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('maximo_carretas')" />
                        </div>

                        <div>
                            <x-input-label for="maximo_entregas" :value="__('Máximo de Entregas')" />
                            <x-text-input id="maximo_entregas" name="maximo_entregas" type="text" oninput="this.value = this.value.replace(/[^0-9]/g, '');" class="mt-1 block w-full" :value="old('maximo_entregas')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('maximo_entregas')" />
                        </div>

                        <div>
                            <x-input-label for="qtd_entrega_padrao" :value="__('Quantidade de Entregas Padrão')" />
                            <x-text-input id="qtd_entrega_padrao" name="qtd_entrega_padrao" type="text" oninput="this.value = this.value.replace(/[^0-9]/g, '');" class="mt-1 block w-full" :value="old('qtd_entrega_padrao')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('qtd_entrega_padrao')" />
                        </div>

                        <div>
                            <x-input-label for="dias_da_semana" :value="__('Dias da Semana')" />
                            <select name="dias_da_semana[]" id="dias_da_semana" multiple class="mt-1 block w-full">
                                @foreach ($diasDaSemana as $dia)
                                    <option value="{{ $dia->id }}" {{ in_array($dia->id, old('dias_da_semana', [])) ? 'selected' : '' }}>
                                        {{ $dia->nome }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('dias_da_semana')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Salvar') }}</x-primary-button>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection
