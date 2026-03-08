<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{-- Título dinámico según el rol --}}
            {{ auth()->user()->role === 'admin' ? __('Gestión de Reportes - CFE Zamora') : __('Mis Reportes Asignados') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg border border-green-200">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 border-b">
                                <th class="p-3 font-bold text-gray-700">Folio</th>
                                <th class="p-3 font-bold text-gray-700">Tipo</th>
                                <th class="p-3 font-bold text-gray-700">Ubicación</th>
                                <th class="p-3 font-bold text-gray-700">Fecha</th>
                                <th class="p-3 font-bold text-gray-700">Estado</th>
                                <th class="p-3 font-bold text-gray-700 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reportes as $report)
                                <tr class="border-b hover:bg-gray-50 transition">
                                    <td class="p-3 text-blue-700 font-bold">#{{ str_pad($report->id, 5, '0', STR_PAD_LEFT) }}</td>
                                    <td class="p-3">
                                        <span class="text-sm px-2 py-1 bg-blue-50 text-blue-800 rounded">{{ $report->tipo }}</span>
                                    </td>
                                    <td class="p-3">
                                        <div class="text-sm font-semibold">{{ $report->calle }} #{{ $report->numero }}</div>
                                        <div class="text-xs text-gray-500">Col. {{ $report->colonia }}</div>
                                    </td>
                                    <td class="p-3 text-sm text-gray-600">
                                        {{ $report->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="p-3">
                                        {{-- Lógica de etiquetas de estado actualizada --}}
                                        @if($report->status == 'Sin revisar')
                                            <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold uppercase">Sin revisar</span>
                                        @elseif($report->status == 'Por revisar')
                                            <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold uppercase">Por revisar</span>
                                        @elseif($report->status == 'Revisado')
                                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold uppercase">Finalizado</span>
                                        @else
                                            <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-bold uppercase">{{ $report->status }}</span>
                                        @endif
                                    </td>
                                    <td class="p-3 text-center">
                                        <div class="flex justify-center gap-2">
                                            @if($report->latitude && $report->longitude)
                                                <a href="https://www.google.com/maps?q={{ $report->latitude }},{{ $report->longitude }}" 
                                                   target="_blank" 
                                                   class="inline-flex items-center px-3 py-2 bg-green-600 text-white rounded-md text-xs font-bold hover:bg-green-700 transition"
                                                   title="Ver ubicación exacta">
                                                    Mapa
                                                </a>
                                            @endif

                                            {{-- Acciones según ROL --}}
                                            @if(auth()->user()->role === 'admin')
                                                <a href="{{ route('admin.reportes.show', $report->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition">
                                                    Asignar / Ver
                                                </a>
                                            @endif

                                            @if(auth()->user()->role === 'empleado' && $report->status === 'Sin revisar')
                                            <form action="{{ route('admin.reportes.finalizar', $report->id) }}" method="POST" onsubmit="return confirm('¿Confirmas que has atendido este reporte?')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                    style="background-color: #00723F; color: white;" 
                                                    class="hover:opacity-90 px-4 py-2 rounded-md font-bold shadow-md transition-all uppercase tracking-widest text-[10px] border-none">
                                                    Finalizar Reporte
                                                </button>
                                            </form>
                                        @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-8 text-center text-gray-500 italic">No hay reportes asignados con estado "Sin revisar".</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<style>
    .btn-cfe-primary {
        background-color: #00723F !important;
        transition: all 0.3s ease;
    }
    .btn-cfe-primary:hover {
        background-color: #00a35a !important;
    }
</style>