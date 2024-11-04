@extends('layouts.app')

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="text-gray-900 dark:text-gray-100">
                    @include('components.relatorios.nivel-tanque-por-periodo', ['tanque' => $tanque])
                </div>
                <div class="inline-flex items-center justify-center w-full">
                    <hr class="w-3/4 h-px my-4 bg-gray-900 border-0">
                    <span class="absolute px-3 font-medium text-gray-900 -translate-x-1/2 bg-white left-1/2">Tabelas</span>
                </div>
                <div class="grid grid-cols-2 gap-2 text-gray-900 dark:text-gray-100">
                    @include('components.relatorios.pedidos-futuros', ['tanque' => $tanque])
                    @include('components.relatorios.entregas-futuras', ['tanque' => $tanque])
                </div>
            </div>
        </div>
    </div>
@endsection