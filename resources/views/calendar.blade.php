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
    
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario de Citas - Clínica Dental Sonrisa Perfecta</title>
    <!-- Estilos para FullCalendar y Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.7/index.global.min.css" rel="stylesheet">
    <style>
        /* Estilos generales */
        body {
            background-color: #eef3f4;
            font-family: Arial, sans-serif;
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
            font-family: 'Merriweather', serif;
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
            font-family: 'Merriweather', serif;

        }
        .btn-primary:hover {
            background-color: #0d6e89;
            font-family: 'Merriweather', serif;
        }

       
        body, .navbar-brand, .navbar-text, .box, p, table, th, td, a, button,label, select,input, textarea,h1, h2, h3, h4,h5{
    font-family: 'Merriweather', serif;
    }

    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Barra lateral -->
            <div class="col-md-3 sidebar">
                <button class="btn btn-primary w-100 mb-2" id="agendarCitaButton">+ Agendar Cita</button>
            
                <div id="datepicker" class="mb-3"></div>
            </div>

            <!-- Calendario principal -->
            <div class="col-md-9" id="calendar-container">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
<!-- Modal para Agendar Cita -->
<div class="modal fade" id="agendarCitaModal" tabindex="-1" aria-labelledby="agendarCitaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agendarCitaModalLabel">Agendar Cita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formAgendarCita" action="{{ route('citas.store') }}" method="POST">
                    @csrf
                    <!-- Buscar Paciente -->
                    <div class="form-group">
                        <label for="paciente_buscar">Buscar Paciente:</label>
                        <input type="text" id="paciente_buscar" class="form-control" placeholder="Buscar paciente..." autocomplete="off">
                        <div id="lista-pacientes" class="list-group mt-2"></div>
                        <button type="button" class="btn btn-link" id="nuevoPacienteButton">Agregar Nuevo Paciente</button>
                    </div>
                    <input type="hidden" name="paciente_id" id="paciente_id">

                    <!-- Especialidad -->
                    <div class="form-group">
                        <label for="especialidad">Especialidad:</label>
                        <select name="especialidad_id" id="especialidad" class="form-control" required>
                            @if (isset($especialidades) && $especialidades->count())
                                @foreach ($especialidades as $especialidad)
                                    <option value="{{ $especialidad->id }}">{{ $especialidad->nombre }}</option>
                                @endforeach
                            @else
                                <option value="">No hay especialidades disponibles</option>
                            @endif
                        </select>
                    </div>

                    <!-- Dentista -->
                    <div class="form-group">
                        <label for="dentista">Dentista:</label>
                        <select name="dentista_id" id="dentista" class="form-control">
                            <option value="">Asignar automáticamente</option>
                            @foreach ($dentistas as $dentista)
                                <option value="{{ $dentista->id }}" data-especialidad="{{ $dentista->especialidad_id }}">
                                    {{ $dentista->nombres }} {{ $dentista->apaterno }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Fecha -->
                    <div class="form-group">
                        <label for="fecha">Fecha de la Cita:</label>
                        <input type="date" name="fecha" id="fecha" class="form-control" required min="{{ date('Y-m-d') }}">
                    </div>

                    <!-- Hora -->
                    <div class="form-group">
                    <label for="hora">Hora:</label>
<select id="hora" name="hora">
  <option value="">Seleccione una hora</option>
  <option value="08:00">08:00 AM</option>
  <option value="09:00">09:00 AM</option>
  <option value="10:00">10:00 AM</option>
  <option value="11:00">11:00 AM</option>
  <option value="12:00">12:00 PM</option>
  <option value="13:00">01:00 PM</option>
  <option value="14:00">02:00 PM</option>
  <option value="15:00">03:00 PM</option>
  <option value="16:00">04:00 PM</option>
  <option value="17:00">05:00 PM</option>
</select>

                    </div>

                    <!-- Notas -->
                    <div class="form-group">
                        <label for="notas">Notas (opcional):</label>
                        <textarea name="descripcion" id="notas" class="form-control" rows="3"></textarea>
                    </div>

                    <!-- Botones -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Agendar Cita</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    <!-- Modal para Agregar Nuevo Paciente -->
    <div class="modal fade" id="agregarNuevoPacienteModal" tabindex="-1" aria-labelledby="agregarNuevoPacienteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    
                    <h5 class="modal-title" id="agregarNuevoPacienteModalLabel">Agregar Nuevo Paciente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form id="formNuevoPaciente" action="/nuevo-paciente" method="POST">
                @csrf
                        <div class="form-group">
                            <label for="nuevo_paciente_nombre">Nombre:</label>
                            <input type="text" name="nuevo_paciente_nombre" id="nuevo_paciente_nombre" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="nuevo_paciente_apaterno">Apellido Paterno:</label>
                            <input type="text" name="nuevo_paciente_apaterno" id="nuevo_paciente_apaterno" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="nuevo_paciente_amaterno">Apellido Materno:</label>
                            <input type="text" name="nuevo_paciente_amaterno" id="nuevo_paciente_amaterno" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="nuevo_paciente_email">Correo:</label>
                            <input type="email" name="nuevo_paciente_email" id="nuevo_paciente_email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="nuevo_paciente_telefono">Teléfono:</label>
                            <input type="text" name="nuevo_paciente_telefono" id="nuevo_paciente_telefono" class="form-control">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar Paciente</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
   <!-- Modal para Vacaciones del Personal -->


<!-- Modal para Detalles de Cita -->
<div class="modal fade" id="detallesCitaModal" tabindex="-1" aria-labelledby="detallesCitaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detallesCitaModalLabel">Detalles de la Cita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Paciente:</strong> <span id="detallePaciente"></span></p>
                <p><strong>Dentista:</strong> <span id="detalleDentista"></span></p>
                <p><strong>Fecha:</strong> <span id="detalleFecha"></span></p>
                <p><strong>Hora:</strong> <span id="detalleHora"></span></p>
                <p><strong>Notas:</strong> <span id="detalleNotas"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


   <!-- Scripts -->
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.7/index.global.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#agendarCitaButton').on('click', function() {
                $('#agendarCitaModal').modal('show');
            });

            $('#paciente_buscar').on('input', function() {
                let query = $(this).val();
                if (query.length > 0) {
                    $.ajax({
                        url: '/buscar-pacientes',
                        method: 'GET',
                        data: { query: query },
                        success: function(data) {
                            $('#lista-pacientes').empty();
                            data.forEach(function(paciente) {
                                $('#lista-pacientes').append(`<a href="#" class="list-group-item list-group-item-action paciente-item" data-id="${paciente.id}" data-nombre="${paciente.nombres} ${paciente.apaterno} ${paciente.amaterno}">${paciente.nombres} ${paciente.apaterno} ${paciente.amaterno}</a>`);
                            });
                        }
                    });
                } else {
                    $('#lista-pacientes').empty();
                }
            });

            $(document).on('click', '.paciente-item', function() {
                let id = $(this).data('id');
                let nombre = $(this).data('nombre');
                $('#paciente_id').val(id);
                $('#paciente_buscar').val(nombre);
                $('#lista-pacientes').empty();
            });

            $('#nuevoPacienteButton').on('click', function() {
                $('#agregarNuevoPacienteModal').modal('show');
            });

            $('#formNuevoPaciente').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: '/nuevo-paciente',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(paciente) {
                        $('#paciente_id').val(paciente.id);
                        $('#paciente_buscar').val(paciente.nombres + ' ' + paciente.apaterno + ' ' + paciente.amaterno);
                        $('#lista-pacientes').empty();
                        $('#agregarNuevoPacienteModal').modal('hide');
                    },
                    error: function(xhr) {
                        console.error(xhr);
                    }
                });
            });

            // Inicializar el calendario
            $('#calendar').fullCalendar({
    events: @json($eventos),
    eventRender: function(event, element) {
        element.find('.fc-title').append('<br>' + event.hora); // Muestra la hora en el evento
    }         // Otras configuraciones del calendario
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'es',
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        dateClick: function(info) {
    var selectedDate = new Date(info.dateStr);
    var today = new Date();
    today.setHours(0, 0, 0, 0);

    if (selectedDate < today) {
        alert('No puedes seleccionar fechas anteriores a hoy.');
    } else {
        // Muestra el modal
        $('#agendarCitaModal').modal('show');
    }
},

        events: [
            @foreach($eventos as $evento)
                {
                    id: '{{ $evento['id'] }}', 
                    title: '{{ $evento['title'] }}',
                    start: '{{ $evento['start'] }}',
                    end: '{{ $evento['end'] }}',
                    notes: '{{ $evento['notes'] }}',
                    paciente: '{{ $evento['paciente'] }}',
                    dentista: '{{ $evento['dentista'] }}'
                },
            @endforeach
        ],
        editable: true,
        selectable: true,
        eventClick: function(info) {
            // Establece los detalles de la cita en el modal
            document.getElementById('detallePaciente').innerText = info.event.extendedProps.paciente;
            document.getElementById('detalleDentista').innerText = info.event.extendedProps.dentista;
            document.getElementById('detalleFecha').innerText = info.event.start.toLocaleDateString();
            document.getElementById('detalleHora').innerText = info.event.start.toLocaleTimeString();
            document.getElementById('detalleNotas').innerText = info.event.extendedProps.notes;

            // Muestra el modal
            $('#detallesCitaModal').modal('show');
        }
    });

    calendar.render();


       
    });

    $('#especialidad').on('change', function () {
    var especialidadSeleccionada = $(this).val();
    $('#dentista option').each(function () {
        if ($(this).data('especialidad') == especialidadSeleccionada || especialidadSeleccionada === "") {
            $(this).show();
        } else {
            $(this).hide();
        }
    });
    $('#dentista').val(''); // Resetear el valor del select
});
document.getElementById('fecha').addEventListener('change', cargarHorasDisponibles);
document.getElementById('dentista_id').addEventListener('change', cargarHorasDisponibles);

function cargarHorasDisponibles() {
    const fechaSeleccionada = document.getElementById('fecha').value;
    const dentistaId = document.getElementById('dentista_id').value;

    if (fechaSeleccionada && dentistaId) {
        fetch(`/horas-disponibles?fecha=${fechaSeleccionada}&dentista_id=${dentistaId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al obtener las horas disponibles.');
                }
                return response.json();
            })
            .then(data => {
                const selectHora = document.getElementById('hora');
                selectHora.innerHTML = '<option value="">Seleccione una hora</option>'; // Limpiar el select

                if (data.horasDisponibles.length === 0) {
                    const option = document.createElement('option');
                    option.value = '';
                    option.textContent = 'No hay horas disponibles';
                    selectHora.appendChild(option);
                } else {
                    data.horasDisponibles.forEach(hora => {
                        const option = document.createElement('option');
                        option.value = hora;
                        option.textContent = hora;
                        selectHora.appendChild(option);
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('No se pudieron cargar las horas disponibles.');
            });
    }
}


</script>

</x-app-layout>
</body>
</html>

