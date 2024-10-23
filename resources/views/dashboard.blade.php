<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Inicio') }}
        </h2>
    </x-slot>

    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

    {{-- <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg"> --}}
                <center>
                <div class="container">
                    <a href="{{ url('/ruta1') }}" class="box">
                        <h3 class="text-lg font-bold">Cuadro 1</h3>
                        <p>Agendar Citas</p>
                    </a>
                
                    <a href="{{ url('/ruta1') }}" class="box">
                        <h3 class="text-lg font-bold">Cuadro 1</h3>
                        <p>Gestion de Vacaciones</p>
                    </a>
            
                    <a href="{{ url('/ruta1') }}" class="box">
                        <h3 class="text-lg font-bold">Cuadro 1</h3>
                        <p>Recordatorios</p>
                    </a>
                </div>
                </center>
            {{-- </div>
        </div>
    </div> --}}
</x-app-layout>
