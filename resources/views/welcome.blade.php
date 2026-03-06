<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Reportes-CFE') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            /* Botón Verde Sólido */
            .btn-cfe-primary {
                background-color: #00723F !important;
                color: white !important;
                transition: all 0.3s ease;
            }
            .btn-cfe-primary:hover {
                background-color: #00a35a !important; /* Verde más claro */
                transform: translateY(-1px);
                box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            }

            /* Botón con Borde (Outline) */
            .btn-cfe-outline {
                border: 2px solid #00723F !important;
                color: #00723F !important;
                background-color: transparent;
                transition: all 0.3s ease;
            }
            .btn-cfe-outline:hover {
                background-color: #00723F !important;
                color: white !important;
            }

            .card-shadow {
                box-shadow: 0 10px 25px -5px rgba(0, 114, 63, 0.1);
            }
        </style>
    </head>
    <body class="bg-[#f8f9fa] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
        
        <header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6">
            
            @if (Route::has('login'))
                <nav class="flex items-center justify-end gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="inline-block px-5 py-2 rounded-md text-sm font-bold btn-cfe-primary">
                            Dashboard
                        </a>
                    @else
                    <h1 class="text-3xl font-black text-gray-900 tracking-tight">
                        Sistema de Reportes <span style="color: #00723F;">CFE Zamora</span>
                    </h1>
                        <a href="{{ route('login') }}" class="inline-block px-5 py-2 font-bold rounded-md text-sm btn-cfe-outline">
                            Iniciar Sesión
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="inline-block px-5 py-2 rounded-md text-sm font-bold btn-cfe-primary">
                                Registrarse
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>

        <main class="w-full lg:max-w-4xl bg-white card-shadow rounded-2xl overflow-hidden border border-gray-100">
            <div class="p-8 lg:p-12">
                <div class="flex items-center gap-4 mb-8">
                    <div class="bg-[#00723F] p-3 rounded-lg text-white shadow-lg">
                        
                    </div>
                    
                </div>

                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div>
                        <p class="text-lg text-gray-600 leading-relaxed mb-6">
                            Bienvenido a la plataforma de gestión de fallas eléctricas del municipio de <strong>Gutierrez Zamora</strong>. Un canal eficiente para ciudadanos y personal técnico.
                        </p>
                        
                        <div class="space-y-4">
                            <div class="flex items-center gap-3 p-3 rounded-lg hover:bg-green-50 transition-colors">
                                <span class="bg-[#00723F] text-white rounded-full h-6 w-6 flex items-center justify-center text-xs font-bold">1</span>
                                <span class="text-gray-700 font-medium text-sm">Reporta fallas.</span>
                            </div>
                            <div class="flex items-center gap-3 p-3 rounded-lg hover:bg-green-50 transition-colors">
                                <span class="bg-[#00723F] text-white rounded-full h-6 w-6 flex items-center justify-center text-xs font-bold">3</span>
                                <span class="text-gray-700 font-medium text-sm">Soluciones rápidas.</span>
                            </div>
                        </div>
                    </div>

                    <div class="relative group">
                        <div class="absolute -inset-1 bg-[#00723F] rounded-xl blur opacity-10 group-hover:opacity-20 transition duration-1000"></div>
                        <div class="relative bg-white p-8 rounded-xl border border-gray-100 shadow-sm text-center">
                            <img src="{{ asset('images/logo.svg') }}" 
                                 alt="CFE Logo" class="h-20 mx-auto mb-4">
                            <h4 class="font-bold text-gray-800 tracking-wide uppercase text-xs">Gutierrez Zamora</h4>
                            <p class="text-[10px] text-gray-400 mt-2 italic text-center uppercase">Gutierrez Zamora, Veracruz, México</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <footer class="mt-8 text-gray-400 text-[11px] uppercase tracking-widest font-bold">
            © {{ date('Y') }} Comisión Federal de Electricidad
        </footer>

    </body>
</html>