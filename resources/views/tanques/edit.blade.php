@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <div class="max-w-xl">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ __('Editar Tanque') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            {{ __('Atualize as informações do tanque.') }}
                        </p>
                    </header>

                    <form method="post" action="{{ route('tanques.update', $tanque->id) }}" class="mt-6 space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="planta_id" :value="__('Planta')" />
                            <select id="planta_id" name="planta_id" class="mt-1 block w-full">
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

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Atualizar Tanque') }}</x-primary-button>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection
