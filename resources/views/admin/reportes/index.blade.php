<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ auth()->user()->role === 'admin' ? __('Gestión de Reportes - CFE Zamora') : __('Mis Reportes Asignados') }}
        </h2>
    </x-slot>

    <style>
        .btn-cfe { 
            background-color: #00723F !important; 
            color: white !important; 
            transition: all 0.3s ease; 
        }
        .btn-cfe:hover { 
            background-color: #00a35a !important; 
            transform: translateY(-1px); 
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Formulario de Filtrado (Solo visible para Admin) --}}
            @if(auth()->user()->role === 'admin')
                <div class="bg-white p-6 rounded-lg shadow-sm mb-6 border-l-4 border-[#00723F]">
                    <form action="{{ route('admin.reportes.index') }}" method="GET" class="flex flex-wrap gap-4 items-end">
                        <div class="flex-1 min-w-[200px]">
                            <label class="block text-xs font-black text-gray-600 uppercase mb-1">Buscar por No. Servicio</label>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#00723F] focus:ring-[#00723F]" 
                                placeholder="Ej: 0012345678">
                        </div>

                        <div class="w-48">
                            <label class="block text-xs font-black text-gray-600 uppercase mb-1">Filtrar por Estado</label>
                            <select name="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#00723F] focus:ring-[#00723F]">
                                <option value="">Todos</option>
                                <option value="Sin revisar" {{ request('status') == 'Sin revisar' ? 'selected' : '' }}>Sin revisar</option>
                                <option value="Revisado" {{ request('status') == 'Revisado' ? 'selected' : '' }}>Finalizado</option>
                            </select>
                        </div>

                        <div class="flex gap-2">
                            {{-- Botón Filtrar con clase btn-cfe --}}
                            <button type="submit" class="btn-cfe px-6 py-2 rounded-md font-bold text-xs uppercase tracking-widest shadow-md">
                                Filtrar
                            </button>
                            
                            {{-- Botón Limpiar estilizado --}}
                            <a href="{{ route('admin.reportes.index') }}" 
                            class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md font-bold text-xs uppercase tracking-widest hover:bg-gray-300 transition">
                                Limpiar
                            </a>
                        </div>
                    </form>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg border border-green-200 font-bold">
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
                                    <td class="p-3">
                                        <a href="{{ route('admin.reportes.show', $report->id) }}" class="text-blue-700 font-bold hover:underline">
                                            #{{ str_pad($report->id, 5, '0', STR_PAD_LEFT) }}
                                        </a>
                                    </td>
                                    <td class="p-3">
                                        <span class="text-xs px-2 py-1 bg-blue-50 text-blue-800 rounded font-bold uppercase">{{ $report->tipo }}</span>
                                    </td>
                                    <td class="p-3">
                                        <div class="text-sm font-semibold text-gray-800">{{ $report->calle }} #{{ $report->numero }}</div>
                                        <div class="text-xs text-gray-500 italic">Col. {{ $report->colonia }}</div>
                                    </td>
                                    <td class="p-3 text-sm text-gray-600">
                                        {{ $report->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="p-3">
                                        @if($report->status == 'Sin revisar')
                                            <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-[10px] font-bold uppercase">Sin revisar</span>
                                        @elseif($report->status == 'Por revisar')
                                            <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-[10px] font-bold uppercase">En Proceso</span>
                                        @elseif($report->status == 'Revisado')
                                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-[10px] font-bold uppercase">Finalizado</span>
                                        @else
                                            <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-[10px] font-bold uppercase">{{ $report->status }}</span>
                                        @endif
                                    </td>
                                    <td class="p-3 text-center">
                                        <a href="{{ route('admin.reportes.show', $report->id) }}" 
                                           class="btn-cfe inline-flex items-center px-6 py-2 rounded-md font-bold text-xs uppercase tracking-widest">
                                            Ver
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-8 text-center text-gray-500 italic">No se encontraron reportes con los criterios seleccionados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>