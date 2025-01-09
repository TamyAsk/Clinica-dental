<x-app-layout>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario de Vacaciones - Clínica Dental Sonrisa Perfecta</title>
    <!-- Estilos para FullCalendar y Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.7/index.global.min.css" rel="stylesheet">

    <style>
        /* Estilos generales */
        body {
            background-color: #eef3f4;
            font-family: Arial, sans-serif;
        }
        .navbar {
            background-color: #112f48;
            color: #fff;
            padding: 20px;
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.25rem;
        }
        .navbar-text {
            font-size: 0.9rem;
        }
        .sidebar {
            padding: 95px;
            border-top-right-radius: 8px;
            border-bottom-right-radius: 8px;
        }
        .sidebar .btn {
            background-color: #112f48;
            color: #fff;
            font-size: 0.9rem;
            padding: 8px 12px;
            margin-bottom: 0px;
            border-radius: 6px;
        }
        .sidebar .btn:hover {
            background-color: #0d263a;
        }
        /* Contenedor del calendario */
        #calendar-container {
            padding: 40px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        #calendar {
            max-width: 100%;
            padding: 10px;
        }
        /* Estilos específicos para FullCalendar */
        .btn-primary1 {
            background-color: #0fa1b9;
            border: none;
            padding: 8px 16px;
            font-size: 0.9rem;
            border-radius: 6px;
        }
        .btn-primary:hover {
            background-color: #0d6e89;
        }
        .navbar-logo {
            width: 60px;
            height: auto;
            margin-right: 10px;
        }
      
    </style>
</head>
<body>

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
    <div class="container-fluid">
        <div class="row">
          
            <div class="col-md-3 sidebar">
                <button class="btn btn-primary w-100 mb-2" id="vacacionesPersonalButton">+ Vacaciones personal</button>
                <div id="datepicker" class="mb-3"></div>
            </div>

          
            <div class="col-md-9" id="calendar-container">
                <div id="calendar"></div>
            </div>
        </div>
    </div>

    <!-- Modal para Vacaciones del Personal -->
    <div class="modal fade" id="vacacionesPersonalModal" tabindex="-1" aria-labelledby="vacacionesPersonalModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="vacacionesPersonalModalLabel">Registrar Vacaciones de Personal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formVacacionesPersonal" action="{{ route('vacacion.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                        <label for="dentista">Selecciona un Dentista:</label>
                        <select name="dentista_id" id="dentista" class="form-control" required>
                            <option value="">Selecciona un dentista</option>
                            @foreach($dentistas as $dentista)
                                <!-- Asegúrate de mostrar el nombre completo del dentista -->
                                <option value="{{ $dentista->id }}" data-especialidad="{{ $dentista->especialidad->nombre }}">
                                    {{ $dentista->nombres}} {{ $dentista->apaterno }} {{ $dentista->amaterno }} <!-- Cambia esto si el nombre está en otro campo -->
                                </option>
                            @endforeach
                        </select>
                    </div>


                            <div class="form-group">
                                <label for="especialidad">Especialidad:</label>
                                <input type="text" id="especialidad" class="form-control" disabled>
                            </div>

                        <div class="mb-3">
                            <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
                        </div>
                        <div class="mb-3">
                            <label for="fecha_fin" class="form-label">Fecha de Fin</label>
                            <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required>
                        </div>
                        <div class="mb-3">
                            <label for="motivo" class="form-label">Motivo</label>
                            <textarea class="form-control" id="motivo" name="motivo" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar Vacaciones</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="detallesVacacionModal" tabindex="-1" aria-labelledby="detallesVacacionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detallesVacacionModalLabel">Detalles de Vacación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Dentista:</strong> <span id="detallePersonal"></span></p>
                    <p><strong>Fecha de Inicio:</strong> <span id="detalleFechaInicio"></span></p>
                    <p><strong>Fecha de Fin:</strong> <span id="detalleFechaFin"></span></p>
                    <p><strong>Motivo:</strong> <span id="detalleMotivo"></span></p>
                </div>
            </div>
        </div>
    </div>
    
    

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.7/index.global.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Inicializar el calendario
        var calendarEl = document.getElementById('calendar');
var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth', // Vista de mes
    events: @json($vacacionesEventos), // Pasar los eventos desde PHP a JS
    editable: true,
    selectable: true,
    eventRender: function(info) {
        // Personaliza el contenido del evento (nombre del dentista)
        var eventEl = info.el;
        var title = info.event.title;

        // Aquí podemos añadir un estilo o formato adicional al nombre del dentista
        var titleEl = document.createElement('div');
        titleEl.className = 'dentista-title';
        titleEl.innerText = title;  // Nombre del dentista

        // Añadir el título al evento
        eventEl.querySelector('.fc-event-title').innerHTML = titleEl.outerHTML;
    },
    eventClick: function(info) {
    // Rellena los campos del modal
    document.getElementById('detallePersonal').innerText = info.event.title;
    document.getElementById('detalleFechaInicio').innerText = info.event.start.toLocaleDateString();
    document.getElementById('detalleFechaFin').innerText = info.event.end.toLocaleDateString();
    document.getElementById('detalleMotivo').innerText = info.event.extendedProps.notes;

    // Abre el modal
    $('#detallesVacacionModal').modal('show');
}


});

calendar.render();



        // Mostrar el modal de vacaciones
        $('#vacacionesPersonalButton').on('click', function() {
            $('#vacacionesPersonalModal').modal('show');
        });

        $('#dentista').on('change', function () {
        var especialidad = $('#dentista option:selected').data('especialidad');
        $('#especialidad').val(especialidad); // Mostrar especialidad en el campo
    });
    </script>
</body>
</html>
</x-app-layout>

<style>
            body, .navbar-brand, .navbar-text, .box, p, table, th, td, a, button,label, select,input, textarea,h1, h2, h3, h4,h5{
    font-family: 'Merriweather', serif;
    }
</style>