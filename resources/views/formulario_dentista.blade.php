<x-app-layout>
    <link rel="stylesheet" href="{{ asset('css/formulario.css') }}">

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

    <!-- Sección de Formulario -->
    <div class="form-container">
        <h2>Registrar Dentista</h2>
        <form action="{{ route('crear.dentista') }}" method="POST">
            @csrf

            <!-- Fila: Nombre y Apellidos -->
            <div class="form-row">
                <div class="form-group">
                    <label for="nombres">Nombre</label>
                    <input type="text" name="nombres" id="nombres" required>
                </div>

                <div class="form-group">
                    <label for="apaterno">Apellido paterno</label>
                    <input type="text" name="apaterno" id="apaterno" required>
                </div>

                <div class="form-group">
                    <label for="amaterno">Apellido materno</label>
                    <input type="text" name="amaterno">
                </div>
            </div>

            <!-- Fila: Correo, Teléfono, Días laborales y Especialidades -->
            <div class="form-row">
                <div class="form-group">
                    <label for="email">Correo</label>
                    <input type="email" name="email" id="email" required>
                </div>

                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <input type="number " name="telefono" id="telefono" required>
                </div>

                <div class="form-group">
                    <label for="dias_laborales">Días laborales</label>
                    <input type="number" name="dias_laborales" id="dias_laborales" min="1" max="7" placeholder="0-7" required>
                </div>

                <div class="form-group">
                    <label for="especialidades">Especialidades</label>
                    <select name="especialidad_id" id="especialidades" required>
                        <option value="" disabled selected>Selecciona una opción</option>
                        @foreach ($especialidad as $item)
                            <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                        @endforeach
                        <option value="nueva">Agregar especialidad</option>
                    </select>
                </div>
            </div>

            <!-- Botón alineado a la derecha -->
            <div class="button-row">
                <input type="submit" value="Registrar" class="submit-btn">
            </div>
        </form>
    </div>

    <!-- Modal para agregar nueva especialidad -->
    <div id="modalEspecialidad" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close" onclick="cerrarModal()">&times;</span>
            <form action="{{route('especialidad.crear')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nombre_especialidad">Nombre de la Especialidad</label>
                    <input type="text" name="nombre" id="nombre_especialidad" required>
                </div>
                <div class="form-group">
                    <label for="descripcion_especialidad">Descripción</label>
                    <input name="descripcion" id="descripcion_especialidad" required></input>
                </div>
                <div class="button-row">
                    <input type="submit" value="Agregar Especialidad" class="submit-btn">
                </div>
            </form>
        </div>
    </div>

    <!-- Estilos del Modal -->
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            padding-top: 60px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fff;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            border-radius: 8px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>

    <!-- Script para manejar el modal -->
    <script>
        document.getElementById('especialidades').addEventListener('change', function () {
            if (this.value === 'nueva') {
                abrirModal();
            }
        });

        function abrirModal() {
            document.getElementById('modalEspecialidad').style.display = 'block';
        }

        function cerrarModal() {
            document.getElementById('modalEspecialidad').style.display = 'none';
            document.getElementById('especialidades').value = ''; // Resetea el select
        }

        // Cerrar el modal al hacer clic fuera de él
        window.onclick = function(event) {
            const modal = document.getElementById('modalEspecialidad');
            if (event.target === modal) {
                cerrarModal();
            }
        }
    </script>
</x-app-layout>
<style>
    body, .navbar-brand, .navbar-text, .box, p, table, th, td, a, button,label, select,input, textarea,h1, h2, h3, h4,h5{
font-family: 'Merriweather', serif;
}

</style>