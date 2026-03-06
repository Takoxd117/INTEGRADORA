<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn-cfe-primary inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>

<style>
    .btn-cfe-primary {
        background-color: #00723F !important;
        color: white !important;
        transition: all 0.3s ease !important;
    }
    .btn-cfe-primary:hover {
        background-color: #00a35a !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    .btn-cfe-primary:active {
        background-color: #005c32 !important;
        transform: translateY(0);
    }
</style>