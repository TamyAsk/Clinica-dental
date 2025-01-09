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

    <link rel="stylesheet" href="{{ asset('css/table_dentistas.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Tabla de Dentistas -->
    <div class="table-container">
        <table class="dentist-table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>Correo</th>
                    <th>Días Laborales</th>
                    <th>Teléfono</th>
                    <th>Especialidad</th>
                    <th>Estatus</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dentista as $item)
                    <tr>
                        <td>{{$item->nombres}}</td>
                        <td>{{$item->apaterno}}</td>
                        <td>{{$item->amaterno}}</td>
                        <td>{{$item->email}}</td>
                        <td>{{$item->dias_laborales}}</td>
                        <td>{{$item->telefono}}</td>
                        <td>{{$item->especialidad->nombre}}</td>
                        <td>{{$item->estatus == 1 ? 'Activo' : 'Inactivo' }}</td>
                        <td>
                            <a href="{{ route('dentista.editar', $item->id) }}" class="btn btn-edit">Editar</a>
                            <a href="{{ route('dentista.toggleStatus', $item->id) }}" 
                                class="btn {{ $item->estatus == 1 ? 'btn-deactivate' : 'btn-activate' }}"
                                onclick="event.preventDefault(); document.getElementById('toggle-status-{{ $item->id }}').submit();">
                                 {{ $item->estatus == 1 ? 'Desactivar' : 'Activar' }}
                             </a>
                             
                             <form id="toggle-status-{{ $item->id }}" action="{{ route('dentista.toggleStatus', $item->id) }}" method="POST" style="display: none;">
                                 @csrf
                                 @method('PATCH')
                             </form>                             
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
<style>
    body, .navbar-brand, .navbar-text, .box, p, table, th, td, a, button,label, select,input, textarea,h1, h2, h3, h4,h5{
font-family: 'Merriweather', serif;
}

</style>