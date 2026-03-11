<x-app-layout>
    <style>
        .btn-cfe { background-color: #00723F !important; color: white !important; transition: all 0.3s ease; }
        .btn-cfe:hover { background-color: #00a35a !important; }
        .text-cfe { color: #00723F !important; }
    </style>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Lista de Personal Registrado - CFE') }}
            </h2>
            <a href="{{ route('admin.users.create') }}" class="btn-cfe px-4 py-2 rounded shadow font-bold text-xs uppercase tracking-widest">
                Registrar Nuevo
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg border-l-4 border-green-600 font-bold">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-t-4 border-[#00723F]">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 border-b">
                            <th class="p-3 text-left text-xs font-black uppercase text-gray-600">Nombre</th>
                            <th class="p-3 text-left text-xs font-black uppercase text-gray-600">CURP</th>
                            <th class="p-3 text-left text-xs font-black uppercase text-gray-600">Rol</th>
                            <th class="p-3 text-left text-xs font-black uppercase text-gray-600">Teléfono</th>
                            <th class="p-3 text-left text-xs font-black uppercase text-gray-600">Ingreso</th>
                            <th class="p-3 text-center text-xs font-black uppercase text-gray-600">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="p-3">
                                {{-- Enlace al detalle del usuario --}}
                                <a href="{{ route('admin.users.show', $user->id) }}" class="text-blue-700 font-bold hover:underline">
                                    {{ $user->name }}
                                </a>
                            </td>
                            <td class="p-3 font-mono text-sm text-gray-600">{{ $user->CURP }}</td>
                            <td class="p-3">
                                <span class="px-2 py-1 rounded text-[10px] font-bold uppercase {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-gray-100 text-gray-700' }}">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="p-3 text-sm">{{ $user->telefono1 }}</td>
                            <td class="p-3 text-sm">{{ \Carbon\Carbon::parse($user->fecha_ingreso)->format('d/m/Y') }}</td>
                            <td class="p-3 text-center">
                                {{-- Botón de dar de baja (No permitir que un admin se borre a sí mismo) --}}
                                @if(auth()->id() !== $user->id)
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('¿Está seguro de dar de baja a este empleado? Esta acción no se puede deshacer.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 font-bold text-xs uppercase tracking-tighter">
                                            Dar de Baja
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400 text-[10px] italic">Usuario Actual</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>