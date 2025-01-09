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

    <div class="main-container py-4">
        <!-- Formulario de Filtro en una sola línea -->
        <form method="GET" action="{{ route('lista.citas') }}" class="search-form d-flex flex-wrap gap-3 mb-3">
            <div class="search-input-container me-3 flex-grow-1">
                <input type="text" name="paciente" class="form-control" placeholder="Buscar por paciente" value="{{ request('paciente') }}">
            </div>
            <div class="search-input-container me-3 flex-grow-1">
                <input type="text" name="dentista" class="form-control" placeholder="Buscar por dentista" value="{{ request('dentista') }}">
            </div>
            <div class="search-input-container me-3">
                <input type="date" name="fecha" class="form-control" value="{{ request('fecha') }}">
            </div>
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>

        <!-- Tabla de Citas -->
        @if($citas->isNotEmpty())
            <div class="table-container">
                <table class="dentist-table">
                    <thead>
                        <tr>
                            <th>Paciente</th>
                            <th>Dentista</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Motivo</th>
                            <th>Acciones</th> <!-- Nueva columna para acciones -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($citas as $cita)
                        <tr>
                            <td>{{ $cita->paciente ? $cita->paciente->nombres . ' ' . $cita->paciente->apaterno : 'Desconocido' }}</td>
                            <td>{{ $cita->dentista ? $cita->dentista->nombres . ' ' . $cita->dentista->apaterno : 'Desconocido' }}</td>
                            <td>{{ $cita->fecha }}</td>
                            <td>{{ $cita->hora }}</td>
                            <td>{{ $cita->descripcion }}</td>
                            <td>
                                <!-- Botón de Editar -->
                                <a href="{{ route('editar.cita', $cita->id) }}" class="btn btn-edit">Editar</a>

                                <!-- Botón de Cancelar -->
                                <form action="{{ route('cancelar.cita', $cita->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-cancel">Cancelar</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="no-citas-message">No hay citas disponibles.</p>
        @endif
    </div>
</x-app-layout>

<style>
    /* General */
    body, .navbar-brand, .navbar-text, p, table, th, td, a, button, label, select, input, textarea, h1, h2, h3, h4, h5 {
        font-family: 'Merriweather', serif;
    }

    /* Contenedor principal */
    .main-container {
        max-width: 1500px;
        margin: 0 auto;
        padding: 20px;
    }

    /* Barra de navegación */
    .navbar {
        background-color: #112f48;
        padding: 20px;
    }

    /* Estilo de Formulario */
    .search-form {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        background-color: #eef3f4;
        padding: 15px;
        border-radius: 5px;
    }

    .search-form input[type="text"],
    .search-form input[type="date"] {
        border: 1px solid #ccc;
        padding: 10px;
        border-radius: 4px;
        width: 100%;
    }

    .search-form button {
        background-color: #3182ce;
        color: #ffffff;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: bold;
    }

    .search-form button:hover {
        background-color: #2b6cb0;
    }

    /* Tabla de Citas */
    .dentist-table {
        width: 100%;
        max-width: 1400px;
        border-collapse: collapse;
        background-color: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
    }

    .dentist-table thead {
        background-color: #112f48;
        color: #fff;
    }

    .dentist-table th,
    .dentist-table td {
        padding: 0.75rem 1rem;
        text-align: left;
        font-size: 0.875rem;
    }

    .dentist-table th {
        font-weight: 600;
        text-transform: uppercase;
    }

    .dentist-table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .dentist-table tbody tr:hover {
        background-color: #e6fffa;
    }

    .dentist-table td {
        color: #000000;
    }

    /* Botones de acciones */
    .btn {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        border-radius: 4px;
        color: #fff;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    .btn-edit {
        background-color: #3182ce;
    }

    .btn-edit:hover {
        background-color: #2b6cb0;
    }

    .btn-cancel {
        background-color: #dc3545;
    }

    .btn-cancel:hover {
        background-color: #c82333;
    }

    .no-citas-message {
        color: #112f48;
        font-style: italic;
        text-align: center;
        margin-top: 20px;
    }
</style>
