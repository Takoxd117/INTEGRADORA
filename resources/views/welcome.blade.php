<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CFE - Sistema de Reportes Zamora</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .bg-cfe { background-color: #00723F; }
        .text-cfe { color: #00723F; }
        .border-cfe { border-color: #00723F; }
    </style>
</head>
<body class="bg-gray-50 antialiased text-gray-900">

    <nav class="bg-white shadow-sm border-b-4 border-cfe py-4 px-6">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center gap-2">
            <img src="{{ asset('images/logo.svg') }}" alt="CFE Logo" class="h-10 mx-auto mb-4">
        </div>
            <div class="hidden sm:flex items-center gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm font-bold text-cfe uppercase">Panel de Control</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-bold text-gray-600 hover:text-cfe uppercase transition">Entrar</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-cfe text-white px-5 py-2 rounded-full text-sm font-bold shadow-md hover:bg-green-700 transition">Registrarse</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <main>
        <div class="relative bg-white overflow-hidden">
            <div class="max-w-7xl mx-auto py-16 px-6 lg:py-24 flex flex-col lg:flex-row items-center gap-12">
                
                <div class="lg:w-1/2 text-center lg:text-left">
                    <h1 class="text-4xl sm:text-6xl font-black leading-none text-gray-900 mb-6">
                        Gestión Eficiente de <br>
                        <span class="text-cfe">Fallas Eléctricas</span>
                    </h1>
                    <p class="text-lg text-gray-600 mb-8 max-w-lg mx-auto lg:mx-0 font-medium">
                        Plataforma oficial para ciudadanos y personal técnico del municipio de 
                        <span class="font-bold text-gray-800">Gutierrez Zamora, Veracruz</span>. 
                        Reporta las fallas con un solo clic.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="{{ route('register') }}" class="bg-cfe text-white px-8 py-4 rounded-xl font-black uppercase text-sm shadow-xl hover:bg-green-700 transition transform hover:-translate-y-1 text-center">
                            Realizar un reporte
                        </a>
                        <a href="{{ route('login') }}" class="bg-white border-2 border-gray-200 text-gray-700 px-8 py-4 rounded-xl font-black uppercase text-sm hover:bg-gray-50 transition text-center sm:hidden">
                            Iniciar Sesión
                        </a>
                    </div>
                </div>

                <div class="lg:w-1/2 w-full">
                    <div class="relative">
                        <div class="absolute -top-6 -left-6 w-32 h-32 bg-green-100 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse"></div>
                        <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-green-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse delay-700"></div>
                        
                        <div class="relative bg-white p-8 rounded-3xl shadow-2xl border border-gray-100">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-cfe" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-xs font-black text-gray-400 uppercase tracking-widest">Mejorando Gutiérrez Zamora</p>
                                    <p class="text-xl font-bold text-gray-800 tracking-tight">Reportes en Tiempo Real</p>
                                </div>
                            </div>
                            <p class="text-sm text-gray-500 italic mb-4">"Optimizando la infraestructura eléctrica."</p>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-50 py-16 px-6">
            <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                    <div class="text-cfe text-3xl mb-4"></div>
                    <h3 class="font-black text-gray-800 uppercase text-sm mb-2">Geolocalización</h3>
                    <p class="text-sm text-gray-500">Ubicación exacta de las fallas para una atencion precisa.</p>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                    <div class="text-cfe text-3xl mb-4"></div>
                    <h3 class="font-black text-gray-800 uppercase text-sm mb-2">Soluciones precisas</h3>
                    <p class="text-sm text-gray-500">Nuestros técnicos se encargaran de solucionar las fallas.</p>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                    <div class="text-cfe text-3xl mb-4"></div>
                    <h3 class="font-black text-gray-800 uppercase text-sm mb-2">Seguimiento</h3>
                    <p class="text-sm text-gray-500">Monitoreo constante de los reportes de la ciudadania.</p>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-white py-10 px-6 border-t border-gray-200">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center text-gray-400 text-xs">
            <p>© 2026 COMISIÓN FEDERAL DE ELECTRICIDAD - GUTIÉRREZ ZAMORA</p>
        </div>
    </footer>

</body>
</html>