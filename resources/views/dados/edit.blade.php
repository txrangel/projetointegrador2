@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <div class="max-w-xl">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ __('Editar Dado de Consumo') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            {{ __('Atualize as informações do dado de consumo.') }}
                        </p>
                    </header>

                    <form method="post" action="{{ route('dados_consumo.update', $dadoConsumo->id) }}" class="mt-6 space-y-6">
                        @csrf
                        @method('PUT')
                        <div>
                            <x-input-label for="data_hora" :value="__('Data e Hora')" />
                            <x-text-input id="data_hora" name="data_hora" type="datetime-local" class="mt-1 block w-full" :value="old('data_hora', $dadoConsumo->data_hora)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('data_hora')" />
                        </div>
                        <div>
                            <x-input-label for="tanque_id" :value="__('Tanque')" />
                            <select id="tanque_id" name="tanque_id" class="mt-1 block w-full" required>
                                <option value="">Selecione um tanque</option>
                                @foreach ($tanques as $tanque)
                                    <option value="{{ $tanque->id }}" {{ $tanque->id == $dadoConsumo->tanque_id ? 'selected' : '' }}>
                                        {{ $tanque->id_externo }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('tanque_id')" />
                        </div>
                        <div>
                            <x-input-label for="nivel" :value="__('Nível')" />
                            <x-text-input id="nivel" name="nivel" type="text" oninput="this.value = this.value.replace(/[^0-9]/g, '');" class="mt-1 block w-full" :value="old('nivel', $dadoConsumo->nivel)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('nivel')" />
                        </div>
                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Atualizar') }}</x-primary-button>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection