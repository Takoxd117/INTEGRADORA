<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ auth()->user()->role === 'admin' ? __('Gestión de Reportes - CFE Zamora') : __('Mis Reportes Asignados') }}
        </h2>
    </x-slot>

    <style>
        .btn-cfe { background-color: #00723F !important; color: white !important; transition: all 0.3s ease; }
        .btn-cfe:hover { background-color: #00a35a !important; transform: translateY(-1px); }
    </style>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Formulario de Filtrado --}}
            @if(auth()->user()->role === 'admin')
                <div class="bg-white p-4 sm:p-6 rounded-lg shadow-sm mb-6 border-l-4 border-[#00723F] mx-4 sm:mx-0">
                    <form action="{{ route('admin.reportes.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
                        <div>
                            <label class="block text-xs font-black text-gray-600 uppercase mb-1">No. Servicio</label>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#00723F] focus:ring-[#00723F]" 
                                placeholder="Ej: 0012345678">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-gray-600 uppercase mb-1">Estado</label>
                            <select name="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#00723F] focus:ring-[#00723F]">
                                <option value="">Todos</option>
                                <option value="Sin revisar" {{ request('status') == 'Sin revisar' ? 'selected' : '' }}>Sin revisar</option>
                                <option value="Revisado" {{ request('status') == 'Revisado' ? 'selected' : '' }}>Finalizado</option>
                            </select>
                        </div>

                        <div class="flex gap-2 col-span-1 lg:col-span-2">
                            <button type="submit" class="btn-cfe flex-1 px-4 py-2 rounded-md font-bold text-xs uppercase shadow-md">Filtrar</button>
                            <a href="{{ route('admin.reportes.index') }}" class="flex-1 bg-gray-200 text-center text-gray-700 px-4 py-2 rounded-md font-bold text-xs uppercase hover:bg-gray-300">Limpiar</a>
                        </div>
                    </form>
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg p-4 sm:p-6 mx-4 sm:mx-0">
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg border border-green-200 font-bold">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-sm">
                        <thead>
                            <tr class="bg-gray-100 border-b">
                                <th class="p-3 font-bold text-gray-700 whitespace-nowrap">Folio</th>
                                <th class="p-3 font-bold text-gray-700">Tipo</th>
                                <th class="p-3 font-bold text-gray-700">Ubicación</th>
                                <th class="p-3 font-bold text-gray-700">Estado</th>
                                <th class="p-3 font-bold text-gray-700 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($reportes as $report)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="p-3 font-bold text-blue-700 underline">
                                        <a href="{{ route('admin.reportes.show', $report->id) }}">#{{ str_pad($report->id, 5, '0', STR_PAD_LEFT) }}</a>
                                    </td>
                                    <td class="p-3 whitespace-nowrap">
                                        <span class="text-[10px] px-2 py-1 bg-blue-50 text-blue-800 rounded font-bold uppercase">{{ $report->tipo }}</span>
                                    </td>
                                    <td class="p-3 min-w-[150px]">
                                        <div class="font-semibold text-gray-800">{{ $report->calle }} #{{ $report->numero }}</div>
                                        <div class="text-[10px] text-gray-500 italic">Col. {{ $report->colonia }}</div>
                                    </td>
                                    <td class="p-3 whitespace-nowrap">
                                        @if($report->status == 'Sin revisar')
                                            <span class="px-2 py-1 bg-red-100 text-red-700 rounded-full text-[10px] font-bold uppercase">Sin revisar</span>
                                        @elseif($report->status == 'Por revisar')
                                            <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full text-[10px] font-bold uppercase">En Proceso</span>
                                        @else
                                            <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-[10px] font-bold uppercase">Finalizado</span>
                                        @endif
                                    </td>
                                    <td class="p-3 text-center">
                                        <a href="{{ route('admin.reportes.show', $report->id) }}" class="btn-cfe inline-block px-4 py-2 rounded-md font-bold text-[10px] uppercase">Ver</a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="p-8 text-center text-gray-500">No hay reportes.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>