<x-app-layout>
    <style>
        .btn-cfe { background-color: #00723F !important; color: white !important; transition: all 0.3s ease; }
        .btn-cfe:hover { background-color: #00a35a !important; }
        .text-cfe { color: #00723F !important; }
    </style>

    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Personal Registrado - CFE') }}
            </h2>
            <a href="{{ route('admin.users.create') }}" class="btn-cfe w-full sm:w-auto text-center px-4 py-2 rounded shadow font-bold text-xs uppercase tracking-widest">
                Registrar Nuevo
            </a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg border-l-4 border-green-600 font-bold mx-4 sm:mx-0">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg border-t-4 border-[#00723F] overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse text-left text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="p-3 font-black uppercase text-gray-600 whitespace-nowrap">Nombre</th>
                                <th class="p-3 font-black uppercase text-gray-600 whitespace-nowrap">CURP</th>
                                <th class="p-3 font-black uppercase text-gray-600 whitespace-nowrap">Rol</th>
                                <th class="p-3 font-black uppercase text-gray-600 whitespace-nowrap">Teléfono</th>
                                <th class="p-3 font-black uppercase text-gray-600 whitespace-nowrap">Ingreso</th>
                                <th class="p-3 font-black uppercase text-gray-600 text-center whitespace-nowrap">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($users as $user)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-3 font-bold text-blue-700">
                                    <a href="{{ route('admin.users.show', $user->id) }}" class="hover:underline">
                                        {{ $user->name }}
                                    </a>
                                </td>
                                <td class="p-3 font-mono text-gray-600">{{ $user->CURP }}</td>
                                <td class="p-3">
                                    <span class="px-2 py-1 rounded text-[10px] font-bold uppercase {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-gray-100 text-gray-700' }}">
                                        {{ $user->role }}
                                    </span>
                                </td>
                                <td class="p-3">{{ $user->telefono1 }}</td>
                                <td class="p-3 whitespace-nowrap">{{ \Carbon\Carbon::parse($user->fecha_ingreso)->format('d/m/Y') }}</td>
                                <td class="p-3 text-center">
                                    @if(auth()->id() !== $user->id)
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('¿Dar de baja?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 font-bold text-xs uppercase hover:text-red-900">
                                                Baja
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-gray-400 text-[10px] italic">Actual</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>