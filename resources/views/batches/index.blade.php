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

  <div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <form method="post" action="{{ route('batches.store') }}" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-3 gap-4">
          @csrf
          <div>
            <label class="block text-sm font-medium">Nome do lote</label>
            <input name="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="Clientes-Setembro" required>
            @error('name') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
          </div>

          <div>
            <label class="block text-sm font-medium">Arquivo (XLSX/CSV)</label>
            <input name="file" type="file" accept=".xlsx,.csv,.txt" class="mt-1 block w-full" required>
            @error('file') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
          </div>

          <div class="flex items-end">
            <button class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 w-full">
              Enviar
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Progresso</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Resultado</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @foreach($batches as $b)
              <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $b->id }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $b->name }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                  @php
                    $map = ['done'=>'green','failed'=>'red','processing'=>'yellow','pending'=>'gray'];
                    $color = $map[$b->status] ?? 'gray';
                  @endphp
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $color }}-100 text-{{ $color }}-800">
                    {{ strtoupper($b->status) }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $b->processed }} / {{ $b->total }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  @if($b->status==='done' && $b->result_path)
                    <a class="text-indigo-600 hover:text-indigo-900" href="{{ route('batches.download',$b) }}">Baixar</a>
                  @else
                    —
                  @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $b->created_at->format('d/m/Y H:i') }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
        <div class="p-4">
          {{ $batches->links() }}
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
