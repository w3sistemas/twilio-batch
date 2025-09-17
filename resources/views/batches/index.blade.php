{{-- resources/views/batches/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lista de Validações') }}
        </h2>
    </x-slot>

    @if (session('ok'))
        <div class="p-4">
            <div class="bg-green-100 border border-green-200 text-green-800 rounded p-3">
                {{ session('ok') }}
            </div>
        </div>
    @endif

    {{-- Formulário de Upload --}}
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="post" action="{{ route('batches.store') }}" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nome do lote</label>
                        <input name="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Ex.: Clientes-Setembro" required>
                        @error('name') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Arquivo (XLSX/CSV/TXT)</label>
                        <label class="mt-1 flex flex-col items-center justify-center w-full h-12 border-2 border-dashed rounded-md cursor-pointer hover:border-indigo-400 transition">
                            <span class="text-gray-500 text-sm">Clique para selecionar</span>
                            <input type="file" name="file" accept=".xlsx,.csv,.txt" class="hidden" required>
                        </label>
                        @error('file') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="flex items-end">
                        <button class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 w-full">
                            Enviar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Tabela de Lotes --}}
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div id="batches-table">
                    @include('batches.partials.table', ['batches' => $batches])
                </div>
            </div>
        </div>
    </div>

    {{-- Script para auto-refresh da tabela --}}
    <script>
        function refreshBatches() {
            fetch("{{ route('batches') }}", { headers: { 'X-Requested-With': 'XMLHttpRequest' }})
                .then(r => r.text())
                .then(html => document.getElementById('batches-table').innerHTML = html)
                .catch(err => console.error("Erro ao atualizar:", err));
        }

        setInterval(refreshBatches, 10000);
    </script>
</x-app-layout>
