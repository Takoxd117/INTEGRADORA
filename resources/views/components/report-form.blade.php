<style>
    .btn-cfe-primary { background-color: #00723F !important; color: white !important; transition: all 0.3s ease; }
    .btn-cfe-primary:hover { background-color: #00a35a !important; transform: translateY(-1px); shadow: 0 4px 6px rgba(0,0,0,0.1); }
    .input-cfe:focus { border-color: #00723F !important; --tw-ring-color: #00723F !important; }
</style>

@if ($errors->any())
    <div class="col-span-2 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 shadow-sm rounded">
        <p class="font-bold">Error al enviar el reporte:</p>
        <ul class="list-disc ml-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <div class="col-span-2 bg-green-100 border-l-4 border-green-600 text-green-800 p-4 mb-4 shadow-sm rounded font-bold">
        {{ session('success') }}
    </div>
@endif

<form action="{{ route('reports.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
    @csrf
    
    <div class="col-span-2 shadow-sm p-4 bg-gray-50 rounded-lg border-l-4 border-[#00723F]">
        <h4 class="font-bold text-[#00723F] mb-3">Datos del Reportante</h4>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="text-[10px] font-bold text-gray-500 uppercase ml-1">Nombre Completo</label>
                <input type="text" name="nombre_report" value="{{ auth()->user()->name }}" class="input-cfe rounded border-gray-300 w-full bg-gray-100" readonly required>
            </div>
            <div>
                <label class="text-[10px] font-bold text-gray-500 uppercase ml-1">Teléfono</label>
                <input type="text" name="telefono" value="{{ auth()->user()->telefono1 }}" class="input-cfe rounded border-gray-300 w-full" required>
            </div>
            <div>
                <label class="text-[10px] font-bold text-gray-500 uppercase ml-1">Correo Electrónico</label>
                <input type="email" name="correo" value="{{ auth()->user()->email }}" class="input-cfe rounded border-gray-300 w-full bg-gray-100" readonly required>
            </div>
        </div>
    </div>

    <div class="col-span-2 shadow-sm p-4 bg-gray-50 rounded-lg mt-2 border-l-4 border-[#00723F]">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4 gap-2">
            <h4 class="font-bold text-[#00723F]">Ubicación de la Falla</h4>
            <div class="flex items-center">
                <button type="button" id="btn-location" class="btn-cfe-primary inline-flex items-center px-4 py-2 text-sm rounded-md shadow-sm font-bold">
                    Usar mi ubicación actual
                </button>
                <span id="location-loader" class="hidden ml-3 text-xs text-green-700 animate-pulse font-semibold">Localizando...</span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="text-[10px] font-bold text-gray-500 uppercase ml-1">Calle</label>
                <input type="text" id="street" name="calle" placeholder="Calle" class="input-cfe rounded border-gray-300 w-full" required>
            </div>
            <div>
                <label class="text-[10px] font-bold text-gray-500 uppercase ml-1">Número</label>
                <input type="text" id="number" name="numero" placeholder="Número" class="input-cfe rounded border-gray-300 w-full" required>
            </div>
            <div>
                <label class="text-[10px] font-bold text-gray-500 uppercase ml-1">Colonia</label>
                <input type="text" id="colony" name="colonia" placeholder="Colonia" class="input-cfe rounded border-gray-300 w-full" required>
            </div>
        </div>

        <textarea name="referencia" placeholder="Referencia (ej. Frente al parque, casa color verde)" class="input-cfe rounded border-gray-300 w-full mt-4" rows="2" required></textarea>

        <input type="hidden" id="lat" name="latitude">
        <input type="hidden" id="lng" name="longitude">
    </div>

    <div class="mb-4">
        <label class="block font-bold text-gray-700 mb-1">Tipo de reporte</label>
        <select name="tipo" class="input-cfe w-full rounded border-gray-300 shadow-sm">
            <option value="Alumbrado Público">Alumbrado Público</option>
            <option value="Servicio Doméstico">Servicio Doméstico</option>
            <option value="Transformador">Transformador / Poste</option>
            <option value="Cables Caídos">Cables Caídos</option>
        </select>
    </div>

    <div class="mb-4">
        <label class="block font-bold text-gray-700 mb-1">Número de Servicio</label>
        <input type="text" name="numero_servicio" placeholder="Ej. 123456789" class="input-cfe w-full rounded border-gray-300 shadow-sm" required>
    </div>

    <div class="col-span-2 mt-2">
        <button type="submit" class="btn-cfe-primary w-full py-4 rounded-xl font-black uppercase tracking-widest text-lg shadow-lg">
            Enviar Reporte a CFE Zamora
        </button>
    </div>
</form>

<script>
document.getElementById('btn-location').addEventListener('click', function() {
    const loader = document.getElementById('location-loader');
    const btn = this;
    
    loader.classList.remove('hidden');
    btn.disabled = true;
    btn.classList.add('opacity-50', 'cursor-not-allowed');

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;

            document.getElementById('lat').value = lat;
            document.getElementById('lng').value = lng;

            fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`)
                .then(response => response.json())
                .then(data => {
                    const addr = data.address;
                    document.getElementById('street').value = addr.road || addr.pedestrian || addr.cycleway || "";
                    document.getElementById('number').value = addr.house_number || "S/N";
                    
                    const colonia = addr.suburb || addr.neighbourhood || addr.quarter || addr.residential || addr.city_district || addr.village || "";
                    document.getElementById('colony').value = colonia;

                    loader.classList.add('hidden');
                    btn.disabled = false;
                    btn.classList.remove('opacity-50', 'cursor-not-allowed');
                })
                .catch(error => {
                    console.error('Error:', error);
                    loader.classList.add('hidden');
                    btn.disabled = false;
                    btn.classList.remove('opacity-50', 'cursor-not-allowed');
                });

        }, function(error) {
            loader.classList.add('hidden');
            btn.disabled = false;
            btn.classList.remove('opacity-50', 'cursor-not-allowed');
            alert('Error: Por favor permite el acceso al GPS.');
        }, { enableHighAccuracy: true });
    } else {
        alert('Tu navegador no soporta geolocalización.');
    }
});
</script>