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

    @if(session('status'))
        <script>
            Swal.fire({
                title: 'Éxito!',
                text: "{{ session('status') }}",
                icon: 'success',
                confirmButtonText: 'OK'
            });
        </script>
    @endif

    <div class="table-container">
        <table class="dentist-table">
            <thead>
                <tr>
                    <th>Fecha de ingreso</th>
                    <th>Nombre</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Estatus</th>
                    <th>Acciones</th>
                    <th>Recordatorios</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pacientes as $item)
                    <tr>
                        <td>{{ $item->created_at->format('Y-m-d') }}</td>
                        <td>{{ $item->nombres }}</td>
                        <td>{{ $item->apaterno }}</td>
                        <td>{{ $item->amaterno }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->telefono }}</td>
                        <td>{{ $item->estatus == 1 ? 'Activo' : 'Inactivo' }}</td>   
                        <td>
                            <!-- Botón de Editar -->
                            <a href="{{ route('paciente.editar', $item->id) }}" class="btn btn-edit">Editar</a>
                        
                            <!-- Botón de Activar/Desactivar -->
                            <a href="{{ route('paciente.toggleStatus', $item->id) }}" 
                               class="btn {{ $item->estatus == 1 ? 'btn-deactivate' : 'btn-activate' }}"
                               onclick="event.preventDefault(); document.getElementById('toggle-status-{{ $item->id }}').submit();">
                               {{ $item->estatus == 1 ? 'Desactivar' : 'Activar' }}
                            </a>
                        
                            <!-- Formulario para Activar/Desactivar -->
                            <form id="toggle-status-{{ $item->id }}" action="{{ route('paciente.toggleStatus', $item->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('PATCH')
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('paciente.enviarRecordatorio', $item->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-send-email" style="background-color: #4CAF50; color: white; padding: 5px 20px; border: none; border-radius: 5px; font-size: 14px; cursor: pointer; transition: background-color 0.3s;">
                                    Enviar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>

<style>
    body, .navbar-brand, .navbar-text, .box, p, table, th, td, a, button{
font-family: 'Merriweather', serif;
}

</style>