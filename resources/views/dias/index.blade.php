@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <a href="{{ route('dias_da_semana.create') }}" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center my-8 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800">
                    {{ __('Novo Dia da Semana') }}
                </a>
                <section class="mt-4">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">
                        {{ __('Lista de Dias da Semana') }}
                    </h2>
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3 tracking-wider">
                                    {{ __('ID') }}
                                </th>
                                <th scope="col" class="px-6 py-3 tracking-wider">
                                    {{ __('Nome') }}
                                </th>
                                <th scope="col" class="px-6 py-3 tracking-wider flex justify-center">
                                    {{ __('Ações') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dias as $dia)
                                <tr class="{{ $loop->iteration % 2 == 0 ? 'bg-gray-50 dark:bg-gray-800' : 'bg-white dark:bg-gray-900' }} border-b dark:border-gray-700">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $dia->id }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $dia->nome }}
                                    </td>
                                    <td class="px-6 py-4 flex justify-center space-x-4">
                                        <a href="{{ route('dias_da_semana.edit', $dia->id) }}" class="text-blue-600 dark:text-blue-500 hover:underline">
                                            {{ __('Editar') }}
                                        </a>
                                        <form action="{{ route('dias_da_semana.delete', $dia->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 dark:text-red-500 hover:underline">
                                                {{ __('Excluir') }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Paginação -->
                    <div class="mt-4">
                        {{ $dias->links() }}
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection
