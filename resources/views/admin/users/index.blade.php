<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Lista de Personal Registrado</h2>
            <a href="{{ route('admin.users.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded shadow">Registrar Nuevo</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 border-b">
                            <th class="p-3 text-left">Nombre</th>
                            <th class="p-3 text-left">CURP</th>
                            <th class="p-3 text-left">Rol</th>
                            <th class="p-3 text-left">Teléfono</th>
                            <th class="p-3 text-left">Ingreso</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3">{{ $user->name }}</td>
                            <td class="p-3 font-mono text-sm">{{ $user->curp }}</td>
                            <td class="p-3 capitalize">{{ $user->role }}</td>
                            <td class="p-3">{{ $user->telefono1 }}</td>
                            <td class="p-3">{{ $user->fecha_ingreso }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>