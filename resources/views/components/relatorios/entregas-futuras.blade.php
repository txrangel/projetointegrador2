<section class="p-4 rounded-lg shadow-lg">
    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">
        {{ __('Lista de Entregas') }} - {{count($tanque->entregas)}}
    </h2>
    <table class="w-full text-sm text-center rtl:text-right text-gray-500 dark:text-gray-400 overflow-hidden">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border border-gray-700">
            <tr class="border border-gray-700 bg-gray-800 text-white">
                <th scope="col" class="px-6 py-3 tracking-wider border-r border-gray-700">
                    {{ __('Data') }}
                </th>
                <th scope="col" class="px-6 py-3 tracking-wider border-r border-gray-700">
                    {{ __('Quantidade') }}
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tanque->entregas as $entrega)
                <tr class="{{ $loop->iteration % 2 == 0 ? 'bg-gray-50 dark:bg-gray-800' : 'bg-white dark:bg-gray-900' }} border border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white border-r border-gray-700">
                        {{ $entrega->data }}
                    </th>
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white border-r border-gray-700">
                        {{ $entrega->quantidade }}
                    </th>
                </tr>
            @endforeach
        </tbody>
    </table>
</section>