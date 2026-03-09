<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalle del Reporte #' . str_pad($reporte->id, 5, '0', STR_PAD_LEFT)) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-8 border-t-4 border-[#00723F]">
                
                {{-- Alertas de Éxito o Error --}}
                @if(session('success'))
                    <div class="mb-6 bg-green-100 border-l-4 border-[#00723F] text-green-800 p-4 shadow-sm rounded-r-lg font-bold">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 bg-red-100 border-l-4 border-red-600 text-red-800 p-4 shadow-sm rounded-r-lg font-bold">
                        {{ session('error') }}
                    </div>
                @endif

                {{-- Información del Reporte --}}
                <div class="mb-8">
                    <h3 class="text-[#00723F] font-bold border-b mb-4 pb-1 uppercase text-sm">Detalles de la Falla</h3>
                    <p><strong>Tipo:</strong> {{ $reporte->tipo }}</p>
                    <p><strong>Ubicación:</strong> {{ $reporte->calle }} #{{ $reporte->numero }}, Col. {{ $reporte->colonia }}</p>
                </div>

                @if(auth()->user()->role === 'admin')
                    {{-- Formulario de Asignación --}}
                    <div class="mb-8 p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <h3 class="font-bold text-gray-700 mb-4 uppercase text-xs">Asignar Personal Técnico</h3>
                        <form action="{{ route('admin.reportes.assign', $reporte->id) }}" method="POST" class="flex gap-4">
                            @csrf
                            <select name="user_id" class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-[#00723F] focus:ring-[#00723F]" required>
                                <option value="">Seleccione un empleado...</option>
                                @foreach($trabajadores as $trabajador)
                                    <option value="{{ $trabajador->id }}">{{ $trabajador->name }}</path></option>
                                @endforeach
                            </select>
                            <button type="submit" style="background-color: #00723F; color: white;" class="px-6 py-2 rounded-md font-bold text-xs uppercase hover:opacity-90 transition">
                                Asignar
                            </button>
                        </form>
                    </div>

                    {{-- Tabla de Personal Asignado --}}
                    <div class="mt-8">
                        <h3 class="text-[#00723F] font-bold border-b mb-4 pb-1 uppercase text-sm">Personal Técnico Asignado</h3>
                        <div class="overflow-hidden border border-gray-200 rounded-lg">
                            <table class="w-full text-left">
                                <thead class="bg-gray-100 border-b">
                                    <tr>
                                        <th class="p-3 text-xs font-bold text-gray-600 uppercase">Nombre</th>
                                        <th class="p-3 text-xs font-bold text-gray-600 uppercase text-center">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($reporte->workers as $worker)
                                        <tr class="border-b bg-white hover:bg-gray-50 transition">
                                            <td class="p-3 text-sm text-gray-700 font-medium">{{ $worker->name }}</td>
                                            <td class="p-3 text-center">
                                                <form action="{{ route('admin.reportes.detach', [$reporte->id, $worker->id]) }}" method="POST" onsubmit="return confirm('¿Retirar a este empleado?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800 font-bold text-xs uppercase">Retirar</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="2" class="p-4 text-center text-gray-500 italic text-sm">No hay personal asignado.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>