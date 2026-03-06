<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto bg-white p-8 shadow-lg rounded-lg">
            <h2 class="text-2xl font-bold mb-6 border-b pb-2">Detalles del Reporte #{{ $reporte->id }}</h2>
            
            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <p class="text-sm text-gray-600">Reportante:</p>
                    <p class="font-bold">{{ $reporte->nombre_report }}</p>
                    <p class="text-sm text-gray-500">{{ $reporte->telefono }}</p>
                    <p class="text-sm text-gray-500">{{ $reporte->correo }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Número de Servicio:</p>
                    <p class="font-bold">{{ $reporte->numero_servicio }}</p>
                </div>
            </div>

            <div class="mb-6 bg-blue-50 p-4 rounded">
                <p class="text-sm text-blue-700 font-bold uppercase">Ubicación de la falla:</p>
                <p>{{ $reporte->calle }} #{{ $reporte->numero }}, Col. {{ $reporte->colonia }}</p>
                <p class="text-sm italic">Ref: {{ $reporte->referencia }}</p>
            </div>

            <form action="{{ route('admin.reportes.assign', $reporte->id) }}" method="POST" class="flex gap-2">
    @csrf
    <select name="user_id" required class="rounded-md border-gray-300 text-sm">
        <option value="">Seleccionar Trabajador...</option>
        @foreach($trabajadores as $trabajadores)
            <option value="{{ $trabajadores->id }}">{{ $trabajadores->name }}</option>
        @endforeach
    </select>
    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 text-xs font-bold uppercase">
        Asignar
    </button>
</form>
        </div>
    </div>
</x-app-layout>