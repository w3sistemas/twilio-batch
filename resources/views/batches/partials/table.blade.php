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
            <td class="px-6 py-4 text-sm text-gray-900">{{ $b->id }}</td>
            <td class="px-6 py-4 text-sm text-gray-900">{{ $b->name }}</td>
            <td class="px-6 py-4 text-sm">
                @php
                    $map = ['done'=>'green','failed'=>'red','processing'=>'yellow','pending'=>'gray'];
                    $color = $map[$b->status] ?? 'gray';
                @endphp
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $color }}-100 text-{{ $color }}-800">
            {{ __("status.$b->status") }}
          </span>
            </td>
            <td class="px-6 py-4 text-sm text-gray-900">{{ $b->processed }} / {{ $b->total }}</td>
            <td class="px-6 py-4 text-sm">
                @if($b->status==='done' && $b->result_path)
                    <a href="{{ route('batches.download',$b) }}"
                       class="inline-flex items-center px-3 py-1 bg-indigo-600 text-white text-xs font-medium rounded hover:bg-indigo-500 transition">
                        ⬇️ Baixar
                    </a>
                @else
                    —
                @endif
            </td>
            <td class="px-6 py-4 text-sm text-gray-900">{{ $b->created_at->format('d/m/Y H:i') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<div class="p-4">
    {{ $batches->links() }}
</div>
