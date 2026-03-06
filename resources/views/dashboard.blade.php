<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sistema de Reportes CFE - Zamora') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if(auth()->user()->role == 'admin')
                    <div class="text-center">
                        <h3 class="text-2xl font-bold text-blue-800">Panel de Administración</h3>
                        <p class="mt-2">Bienvenido, administrador. Tienes reportes pendientes por revisar.</p>
                        <div class="mt-6">
                            <a href="{{ route('admin.reports.index') }}" class="bg-blue-600 text-white px-6 py-2 rounded shadow">Ir a Gestión de Reportes</a>
                        </div>
                    </div>

                @elseif(auth()->user()->role == 'empleado')
                    <div class="text-center">
                        <h3 class="text-2xl font-bold text-green-700">Panel de Cuadrilla</h3>
                        <p class="mt-2">Tienes tareas de mantenimiento asignadas para hoy.</p>
                        <div class="mt-6">
                            <a href="{{ route('admin.reports.index') }}" class="bg-green-600 text-white px-6 py-2 rounded shadow">Ver Mis Tareas</a>
                        </div>
                    </div>

                @else
                    {{-- Si es ciudadano, mostramos el formulario de reporte que creamos antes --}}
                    <h3 class="text-xl font-bold mb-4 text-center">¿Tienes una falla eléctrica? Repórtala aquí</h3>
                    @include('components.report-form') {{-- O pega aquí el formulario que hicimos en pasos anteriores --}}
                @endif

            </div>
        </div>
    </div>
</x-app-layout>