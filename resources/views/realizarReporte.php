<form action="{{ route('reports.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
    @csrf
    
    <div class="col-span-2 shadow-sm p-4 bg-gray-50 rounded-lg">
        <h4 class="font-bold text-blue-800 mb-2">Datos del Reportante</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <input type="text" name="nombre_report" placeholder="Nombre completo" class="rounded border-gray-300 w-full" required>
            <input type="text" name="telefono" placeholder="Teléfono" class="rounded border-gray-300 w-full" required>
            <input type="text" name="correo" placeholder="Correo" class="rounded border-gray-300 w-full" required>
        </div>
    </div>

    <div class="col-span-2 shadow-sm p-4 bg-gray-50 rounded-lg mt-2">
        <h4 class="font-bold text-blue-800 mb-2">Ubicación de la Falla</h4>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <input type="text" name="calle" placeholder="Calle" class="rounded border-gray-300" required>
            <input type="text" name="numero" placeholder="Número" class="rounded border-gray-300" required>
            <input type="text" name="colonio" placeholder="Colonia" class="rounded border-gray-300" required>
        </div>
        <textarea name="referencia" placeholder="Referencia (ej. Frente al parque, casa color verde)" class="rounded border-gray-300 w-full mt-4" rows="2" required></textarea>
        <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
            <p class="text-sm text-blue-800 mb-2 font-semibold">¿Te encuentras en el lugar de la falla?</p>
            <button type="button" id="btn-location" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                Obtener mi ubicación actual
            </button>
            <span id="location-loader" class="hidden ml-3 text-xs text-blue-600 animate-pulse">Obteniendo coordenadas...</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label>Calle</label>
                <input type="text" id="street" name="street" class="w-full rounded-md border-gray-300">
            </div>
            <div>
                <label>Colonia</label>
                <input type="text" id="colony" name="colony" class="w-full rounded-md border-gray-300">
            </div>
        </div>

        <input type="hidden" id="lat" name="latitude">
        <input type="hidden" id="lng" name="longitude">
    </div>

    <div class="mb-4">
        <label class="block font-bold">Tipo de reporte</label>
        <select name="tipo" class="w-full rounded border-gray-300">
            <option value="Alumbrado Público">Alumbrado Público</option>
            <option value="Servicio Doméstico">Servicio Doméstico</option>
            <option value="Transformador">Transformador / Poste</option>
        </select>
    </div>

    <div class="mb-4">
        <label class="block font-bold">Número de Servicio</label>
        <input type="text" name="numero_servicio" placeholder="Ej. 123456789 (Se encuentra en el recibo)" class="w-full rounded border-gray-300" required>
    </div>

    <div class="col-span-2">
        <button type="submit" class="w-full bg-blue-700 text-white font-bold py-3 rounded-lg hover:bg-blue-800">
            Enviar Reporte a CFE
        </button>
    </div>
</form>
