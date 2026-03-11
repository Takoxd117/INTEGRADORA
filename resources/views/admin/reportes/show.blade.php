<x-app-layout>
    <style>
        .btn-cfe { 
            background-color: #00723F !important; 
            color: white !important; 
            transition: all 0.3s ease; 
        }
        .btn-cfe:hover { 
            background-color: #00a35a !important; 
            transform: scale(1.02); 
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
    </style>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detalles del Reporte #{{ str_pad($reporte->id, 5, '0', STR_PAD_LEFT) }}
            </h2>
            <a href="{{ route('admin.reportes.index') }}" class="text-sm font-bold text-[#00723F] hover:underline transition">
                ← Volver al listado
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-lg overflow-hidden border-t-8 border-[#00723F]">
                
                <div class="p-8">
                    {{-- Encabezado y Estado --}}
                    <div class="flex flex-wrap justify-between items-start mb-8 border-b pb-6">
                        <div>
                            <h3 class="text-3xl font-black text-gray-900 uppercase tracking-tighter">{{ $reporte->tipo }}</h3>
                            <p class="text-gray-500 text-sm font-mono mt-1">Folio Interno: CFE-{{ $reporte->id }}</p>
                        </div>
                        <div class="mt-2 md:mt-0">
                            <span class="px-6 py-2 rounded-full text-xs font-black uppercase shadow-sm 
                                {{ $reporte->status == 'Revisado' ? 'bg-green-600 text-white' : 'bg-yellow-400 text-yellow-900' }}">
                                Estatus: {{ $reporte->status }}
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        {{-- BLOQUE 1: Información Técnica --}}
                        <div class="space-y-8">
                            <div>
                                <h4 class="text-[#00723F] font-black text-xs uppercase tracking-widest border-l-4 border-[#00723F] pl-3 mb-3">Ubicación de la Falla</h4>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <p class="text-xl font-bold text-gray-800">{{ $reporte->calle }} #{{ $reporte->numero }}</p>
                                    <p class="text-gray-700 font-medium">Colonia: {{ $reporte->colonia }}</p>
                                    <p class="text-sm text-gray-600 mt-3 italic border-t pt-2">
                                        <strong>Referencia:</strong> {{ $reporte->referencia ?? 'No se proporcionó referencia adicional.' }}
                                    </p>
                                </div>
                            </div>

                            <div>
                                <h4 class="text-[#00723F] font-black text-xs uppercase tracking-widest border-l-4 border-[#00723F] pl-3 mb-3">Datos del Ciudadano</h4>
                                <div class="grid grid-cols-1 gap-2 text-gray-700">
                                    <p><strong>Nombre:</strong> {{ $reporte->nombre_report }}</p>
                                    <p><strong>Teléfono:</strong> {{ $reporte->telefono }}</p>
                                    <p><strong>No. Servicio:</strong> <span class="font-mono text-blue-700">{{ $reporte->numero_servicio ?? 'N/A' }}</span></p>
                                </div>
                            </div>
                        </div>

                        {{-- BLOQUE 2: Evidencia Fotográfica --}}
                        <div class="bg-gray-50 p-6 rounded-2xl border border-gray-200 shadow-inner">
                            <h4 class="text-[#00723F] font-black text-xs uppercase tracking-widest mb-4 text-center">Evidencia Fotográfica</h4>
                            @if($reporte->imagen)
                                <a href="{{ asset('storage/' . $reporte->imagen) }}" target="_blank" class="block group">
                                    <img src="{{ asset('storage/' . $reporte->imagen) }}" 
                                         alt="Evidencia" 
                                         class="w-full h-72 object-cover rounded-xl shadow-lg border-4 border-white group-hover:opacity-90 transition transform group-hover:scale-[1.01]">
                                    <p class="text-[10px] text-center text-gray-400 mt-3 font-bold uppercase tracking-widest">Clic para ver en tamaño real</p>
                                </a>
                            @else
                                <div class="h-72 flex flex-col items-center justify-center border-2 border-dashed border-gray-300 rounded-xl bg-white">
                                    <svg class="w-12 h-12 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span class="text-gray-400 font-bold italic uppercase text-xs">Sin evidencia adjunta</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- NUEVA SECCIÓN: ASIGNACIÓN (SOLO ADMIN) --}}
                    @if(auth()->user()->role === 'admin')
                        <div class="mt-12 p-6 bg-gray-50 rounded-xl border border-gray-200">
                            <h4 class="text-[#00723F] font-black text-xs uppercase tracking-widest mb-4">Gestión de Personal Técnico</h4>
                            
                            {{-- Formulario de Asignación --}}
                            <form action="{{ route('admin.reportes.assign', $reporte->id) }}" method="POST" class="flex flex-col sm:flex-row gap-3">
                                @csrf
                                <select name="user_id" required class="flex-1 rounded-md border-gray-300 text-sm focus:border-[#00723F] focus:ring-[#00723F]">
                                    <option value="">Seleccionar Trabajador...</option>
                                    @foreach($trabajadores as $trabajador)
                                        <option value="{{ $trabajador->id }}">{{ $trabajador->name }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn-cfe px-8 py-2 rounded-md font-bold text-xs uppercase tracking-widest">
                                    Asignar al Reporte
                                </button>
                            </form>

                            {{-- Lista de trabajadores ya asignados --}}
                            @if($reporte->workers->count() > 0)
                                <div class="mt-4">
                                    <p class="text-[10px] font-black text-gray-400 uppercase mb-2">Personal actualmente asignado:</p>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($reporte->workers as $worker)
                                            <div class="inline-flex items-center bg-white border border-[#00723F] px-3 py-1 rounded-full">
                                                <span class="text-xs font-bold text-gray-700">{{ $worker->name }}</span>
                                                <form action="{{ route('admin.reportes.detach', [$reporte->id, $worker->id]) }}" method="POST" class="ml-2">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700 font-bold text-xs">×</button>
                                                </form>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif

                    <div class="mt-8 pt-8 border-t flex flex-col md:flex-row gap-6">
    
                        {{-- Validación mejorada para las coordenadas --}}
                        @if(!empty($reporte->latitude) && !empty($reporte->longitude))
                            <a href="https://www.google.com/maps/search/?api=1&query={{ $reporte->latitude }},{{ $reporte->longitude }}" 
                            target="_blank" 
                            class="flex-1 bg-gray-800 text-white text-center py-5 rounded-xl font-black uppercase tracking-widest hover:bg-black transition shadow-xl flex items-center justify-center gap-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Mostrar en el mapa
                            </a>
                        @else
                            {{-- Botón deshabilitado si no hay coordenadas para que el diseño no se rompa --}}
                            <div class="flex-1 bg-gray-200 text-gray-400 text-center py-5 rounded-xl font-black uppercase tracking-widest cursor-not-allowed flex items-center justify-center gap-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 9.172a4 4 0 015.656 5.656m-2.828-2.828l-5.656-5.656m6.364 0l-5.656 5.656"></path>
                                </svg>
                                Ubicación no disponible
                            </div>
                        @endif

                        {{-- Botón de Finalizar --}}
                        @if($reporte->status !== 'Revisado')
                            @if(auth()->user()->role === 'admin' || $reporte->workers->contains(auth()->user()))
                                <form action="{{ route('admin.reportes.finalizar', $reporte->id) }}" method="POST" class="flex-1" onsubmit="return confirm('¿Confirmas que el reporte ha sido atendido?')">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn-cfe w-full py-5 rounded-xl font-black uppercase tracking-widest shadow-xl flex items-center justify-center gap-2">
                                        Finalizar reporte
                                    </button>
                                </form>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="mt-6 text-center">
                <p class="text-xs text-gray-400 font-bold uppercase tracking-widest">Sistema de Gestión de Reportes - Gutiérrez Zamora, Ver.</p>
            </div>
        </div>
    </div>
</x-app-layout>