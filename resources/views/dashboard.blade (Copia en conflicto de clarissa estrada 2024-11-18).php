<x-app-layout>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    

    <nav class="navbar navbar-expand-lg navbar-dark bg-[#112f48] p-4">
        <div class="flex items-center">
            <img src="{{ asset('img/logo_clinica.png') }}" alt="Logo Clínica" class="h-12 w-auto mr-4">
            <div class="flex flex-col">
                <a class="navbar-brand text-white font-bold text-xl" href="#">Clínica Dental Sonrisa Perfecta</a>
                <span class="navbar-text text-white text-sm italic">Cuidando tu sonrisa, cuidamos tu salud.</span>
            </div>
        </div>
    </nav>
    
    <!-- Sección de Iconos de Acciones -->
    <div class="flex justify-center mt-10 space-x-16">
        <a href="{{ route('lista.citas') }}" class="box text-center p-4 border border-blue-500 rounded-lg">
            <img src="{{ asset('img/cita.png') }}" alt="imagen de recordatorios" class="h-16 w-16 mx-auto">
            <p class="mt-2 text-gray-700">Citas</p>
        </a>
        <a href="{{ route('calendario') }}" class="box text-center p-4 border border-blue-500 rounded-lg">
            <img src="{{ asset('img/calendario.png') }}" alt="imagen de agenda" class="h-16 w-16 mx-auto">
            <p class="mt-2 text-gray-700">Agendar Cita</p>
        </a>
        <a href="" class="box text-center p-4 border border-blue-500 rounded-lg">
            <img src="{{ asset('img/vaca.png') }}" alt="imagen de vacaciones" class="h-16 w-16 mx-auto">
            <p class="mt-2 text-gray-700">Gestión Vacacional Para El Personal</p>
        </a>
    </div>
    <style>
        body, .navbar-brand, .navbar-text, .box p {
    font-family: 'Merriweather', serif;
}

    </style>
</x-app-layout>
