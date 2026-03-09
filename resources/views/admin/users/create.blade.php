<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Registro de empleado de Personal - CFE') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700">
                    <ul class="list-disc ml-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.users.store') }}" method="POST" class="bg-white shadow-sm sm:rounded-lg p-8 border-t-4 border-[#00723F]">
                @csrf

                <h3 class="text-[#00723F] font-bold border-b mb-4 pb-1 uppercase text-sm">Datos Personales</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nombre Completo</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#00723F] focus:ring-[#00723F]" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">CURP</label>
                        <input type="text" name="curp" value="{{ old('curp') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#00723F] focus:ring-[#00723F]" placeholder="18 caracteres" required>
                    </div>
                </div>

                <h3 class="text-[#00723F] font-bold border-b mb-4 pb-1 uppercase text-sm">Domicilio</h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Calle</label>
                        <input type="text" name="calle" value="{{ old('calle') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#00723F] focus:ring-[#00723F]" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Número</label>
                        <input type="text" name="numero" value="{{ old('numero') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#00723F] focus:ring-[#00723F]" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Colonia</label>
                        <input type="text" name="colonia" value="{{ old('colonia') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#00723F] focus:ring-[#00723F]" required>
                    </div>
                </div>

                <h3 class="text-[#00723F] font-bold border-b mb-4 pb-1 uppercase text-sm">Información Laboral y Contacto</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Teléfono 1</label>
                        <input type="text" name="telefono1" value="{{ old('telefono1') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#00723F] focus:ring-[#00723F]" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Teléfono 2 (Opcional)</label>
                        <input type="text" name="telefono2" value="{{ old('telefono2') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#00723F] focus:ring-[#00723F]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Rol</label>
                        <select name="role" class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#00723F] focus:ring-[#00723F]">
                            <option value="empleado">Empleado</option>
                            <option value="admin">Administrador</option>
                        </select>
                    </div>
                    <div class="md:col-span-3">
                        <label class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#00723F] focus:ring-[#00723F]" required>
                    </div>
                </div>

                <h3 class="text-[#00723F] font-bold border-b mb-4 pb-1 uppercase text-sm">Seguridad de Acceso</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Contraseña</label>
                        <input type="password" id="password" name="password" class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#00723F] focus:ring-[#00723F]" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Confirmar Contraseña</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#00723F] focus:ring-[#00723F]" required>
                    </div>
                </div>

                <div class="flex items-center justify-end border-t pt-4">
                    <button type="submit" class="bg-[#00723F] hover:bg-[#00a35a] text-black px-8 py-3 rounded-lg font-bold shadow-md transition-all uppercase tracking-widest text-sm">
                        Finalizar Registro de Empleado
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const pass = document.getElementById('password');
        const conf = document.getElementById('password_confirmation');
    </script>
</x-app-layout>