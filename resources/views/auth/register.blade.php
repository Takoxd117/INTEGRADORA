<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" id="registrationForm">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Nombre Completo')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" :value="__('Correo Electrónico')" />
            <x-text-input id="email" 
                class="block mt-1 w-full" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required 
                placeholder="usuario@dominio.com"
                pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$"
                title="El correo debe tener un dominio válido (ejemplo: .com, .es, .net)" />
            
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="telefono1" :value="__('Teléfono')" />
            <x-text-input id="telefono1" class="block mt-1 w-full" type="text" name="telefono1" :value="old('telefono1')" required placeholder="Ej. 3511234567" />
            <x-input-error :messages="$errors->get('telefono1')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Contraseña')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-6">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#00723F]" href="{{ route('login') }}">
                {{ __('¿Ya tienes una cuenta?') }}
            </a>

            <x-primary-button class="ms-4 btn-cfe-primary" id="submitBtn">
                {{ __('Registrarse') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

<style>
    .btn-cfe-primary {
        background-color: #00723F !important;
        transition: all 0.3s ease;
    }
    .btn-cfe-primary:hover {
        background-color: #00a35a !important;
    }
</style>

<script>
    // Validación extra antes de enviar
    document.getElementById('registrationForm').addEventListener('submit', function(e) {
        const email = document.getElementById('email').value;
        const emailError = document.getElementById('email-error');
        
        // Lista negra de dominios temporales (opcional)
        const blacklistedDomains = ['yopmail.com', 'mailinator.com', '10minutemail.com'];
        const domain = email.split('@')[1];

        if (blacklistedDomains.includes(domain)) {
            e.preventDefault();
            emailError.style.display = 'block';
            emailError.innerText = "No se permiten correos de dominios temporales.";
        }
    });
</script>