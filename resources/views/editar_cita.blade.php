<x-layout>
    <x-slot name="header">
        
    </x-slot>

    <div class="form-container">
        <div class="card shadow-lg form-card">
            <form method="POST" action="{{ route('citas.update', $cita->id) }}">
                @csrf
                @method('PUT')

                <!-- Paciente -->
                <div class="form-group mb-4">
                    <label for="paciente" class="form-label">Paciente</label>
                    <input type="text" class="form-control" id="paciente" 
                           name="paciente_id" 
                           value="{{ $cita->paciente ? $cita->paciente->nombres . ' ' . $cita->paciente->apaterno : '' }}" 
                           disabled>
                </div>

                <!-- Dentista -->
                <div class="form-group mb-4">
                    <label for="dentista" class="form-label">Dentista</label>
                    <select name="dentista_id" id="dentista" class="form-control" required>
                        <option value="">Seleccione un dentista</option>
                        @foreach ($dentistas as $dentista)
                            <option value="{{ $dentista->id }}" 
                                    {{ $dentista->id == $cita->dentista_id ? 'selected' : '' }}>
                                {{ $dentista->nombres }} {{ $dentista->apaterno }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Fecha -->
                <div class="form-group mb-4">
                    <label for="fecha" class="form-label">Fecha</label>
                    <input type="date" class="form-control" id="fecha" 
                           name="fecha" value="{{ $cita->fecha }}" required>
                </div>

                <!-- Hora -->
                <div class="form-group mb-4">
                    <label for="hora" class="form-label">Hora</label>
                    <input type="time" class="form-control" id="hora" 
                           name="hora" value="{{ $cita->hora }}" required>
                </div>

                <!-- Descripción -->
                <div class="form-group mb-4">
                    <label for="descripcion" class="form-label">Motivo</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="4">{{ $cita->descripcion }}</textarea>
                </div>

                <!-- Botones -->
                <div class="d-flex justify-content-between">
                    <a href="{{ route('lista.citas') }}" class="btn btn-secondary btn-action">Cancelar</a>
                    <button type="submit" class="btn btn-success btn-action">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <style>
        body {
            font-family: 'Merriweather', serif;
            background-color: #f4f4f4;
            color: #333;
        }

        .form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 30vh;
            background-color: #eef3f4;
        }

        .form-card {
            width: 60%;
            max-width: 400px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin: 20px;
            box-sizing: border-box;
        }

        .form-label {
            font-weight: 600;
            font-size: 1.1rem;
            color: #0fa1b9;
        }

        .form-control {
            font-family: 'Merriweather', serif;
            background-color: #f9fafb;
            border-radius: 6px;
            border: 1px solid #ddd;
            padding: 10px;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            border-color: #0fa1b9;
            box-shadow: 0 0 5px rgba(15, 161, 185, 0.5);
        }

        .btn-action {
            font-family: 'Merriweather', serif;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 6px;
            width: 45%;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .btn-secondary {
            background-color: #6c757d;
            border: none;
            color:white;
        }

        .btn-secondary:hover {
            background-color: red;
        }

        .btn-success {
            background-color: green;
            border: none;
            color:white;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .d-flex {
            justify-content: space-between;
        }


        .text-primary {
            color: #0fa1b9;
        }

        textarea {
            font-family: 'Merriweather', serif;
            background-color: #f9fafb;
            border-radius: 6px;
            padding: 10px;
            width: 100%;
            resize: vertical;
            min-height: 120px;
        }

        textarea:focus {
            border-color: #0fa1b9;
            box-shadow: 0 0 5px rgba(15, 161, 185, 0.5);
        }

        .card {
            border: none;
        }

    </style>
</x-layout>
