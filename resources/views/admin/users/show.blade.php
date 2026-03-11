<x-app-layout>
    <style>
        .card-cfe { border-top: 5px solid #00723F; }
        .text-cfe { color: #00723F; }
        .bg-cfe { background-color: #00723F; }
    </style>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalles del Personal') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg card-cfe p-8">
                
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h1 class="text-3xl font-black text-gray-800">{{ $user->name }}</h1>
                        <span class="inline-block mt-2 px-3 py-1 text-xs font-bold uppercase rounded-full bg-green-100 text-[#00723F]">
                            {{ $user->role }}
                        </span>
                    </div>
                    
                    {{-- Botón de baja en la misma vista --}}
                    @if(auth()->id() !== $user->id)
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('¿Está seguro de dar de baja a este empleado?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-bold text-sm transition">
                                Dar de baja del sistema
                            </button>
                        </form>
                    @endif
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-t pt-6">
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase">CURP</p>
                        <p class="font-mono text-lg text-gray-700">{{ $user->CURP }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase">Correo Electrónico</p>
                        <p class="text-lg text-gray-700">{{ $user->email }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase">Teléfono Principal</p>
                        <p class="text-lg text-gray-700">{{ $user->telefono1 }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase">Fecha de Ingreso</p>
                        <p class="text-lg text-gray-700">{{ \Carbon\Carbon::parse($user->fecha_ingreso)->format('d/m/Y') }}</p>
                    </div>
                </div>

                <div class="mt-8 bg-gray-50 p-4 rounded-lg">
                    <p class="text-[10px] font-black text-gray-400 uppercase mb-2">Dirección Registrada</p>
                    <p class="text-gray-700 font-medium">
                        {{ $user->calle }} #{{ $user->numero }}, Col. {{ $user->colonia }} <br>
                        {{ $user->municipio }}
                    </p>
                </div>

                <div class="mt-8">
                    <a href="{{ route('admin.users.index') }}" class="text-gray-500 hover:text-gray-800 font-bold underline">
                        Regresar a la lista de personal
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>