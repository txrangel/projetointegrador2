@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <div class="max-w-xl">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ __('Novo Dia da Semana') }}
                        </h2>
                
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            {{ __('Preencha as informações para criar um novo dia da semana.') }}
                        </p>
                    </header>
                
                    <form method="post" action="{{ route('dias_da_semana.store') }}" class="mt-6 space-y-6">
                        @csrf
                
                        <div>
                            <x-input-label for="numero" :value="__('Número')" />
                            <x-text-input id="numero" name="numero" type="text" oninput="this.value = this.value.replace(/[^0-9]/g, '');" class="mt-1 block w-full" :value="old('numero')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('numero')" />
                        </div>

                        <div>
                            <x-input-label for="nome" :value="__('Nome')" />
                            <x-text-input id="nome" name="nome" type="text" class="mt-1 block w-full" :value="old('nome')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('nome')" />
                        </div>

                        <div>
                            <x-input-label for="horario_inicio" :value="__('Horário Início')" />
                            <x-text-input id="horario_inicio" name="horario_inicio" type="time" class="mt-1 block w-full" :value="old('horario_inicio')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('horario_inicio')" />
                        </div>

                        <div>
                            <x-input-label for="horario_fim" :value="__('Horário Fim')" />
                            <x-text-input id="horario_fim" name="horario_fim" type="time" class="mt-1 block w-full" :value="old('horario_fim')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('horario_fim')" />
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
