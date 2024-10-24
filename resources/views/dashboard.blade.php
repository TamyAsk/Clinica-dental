<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Inicio') }}
        </h2>
    </x-slot>

    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
                <center>
                <div class="container">
                    <a href="{{ url('/ruta1') }}" class="box">
                        <img src="" alt="imagen de agenda">
                        <p>Agendar Citas</p>
                    </a>
                
                    <a href="{{ url('/ruta1') }}" class="box">
                        <img src="" alt="imagen de vacaciones">
                        <p>Gestion de Vacaciones</p>
                    </a>
            
                    <a href="{{ url('/ruta1') }}" class="box">
                        <img src="" alt="imagen de recordatorios">
                        <p>Recordatorios</p>
                    </a>
                </div>
                </center>
</x-app-layout>
