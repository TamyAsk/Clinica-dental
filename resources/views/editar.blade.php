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

    <link rel="stylesheet" href="{{ asset('css/formulario.css') }}">

    <!-- Sección de Formulario -->
    <div class="form-container">
        <h2>Editar Dentista</h2>
        <form action="{{ route('dentista.actualizar', $dentista->id) }}" method="POST">
            @csrf
            @method('PUT')
        
            <!-- Fila: Nombre y Apellidos -->
            <div class="form-row">
                <div class="form-group">
                    <label for="nombres">Nombre</label>
                    <input type="text" name="nombres" id="nombres" value="{{ old('nombres', $dentista->nombres) }}" required>
                </div>
        
                <div class="form-group">
                    <label for="apaterno">Apellido paterno</label>
                    <input type="text" name="apaterno" id="apaterno" value="{{ old('apaterno', $dentista->apaterno) }}" required>
                </div>
        
                <div class="form-group">
                    <label for="amaterno">Apellido materno</label>
                    <input type="text" name="amaterno" value="{{ old('amaterno', $dentista->amaterno) }}">
                </div>
            </div>
        
            <!-- Fila: Correo, Teléfono, Días laborales y Especialidades -->
            <div class="form-row">
                <div class="form-group">
                    <label for="email">Correo</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $dentista->email) }}" required>
                </div>
        
                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <input type="tel" name="telefono" id="telefono" value="{{ old('telefono', $dentista->telefono) }}" required>
                </div>
        
                <div class="form-group">
                    <label for="dias_laborales">Días laborales</label>
                    <input type="number" name="dias_laborales" id="dias_laborales" value="{{ old('dias_laborales', $dentista->dias_laborales) }}" min="1" max="7" placeholder="0-7" required>
                </div>
        
                <div class="form-group">
                    <label for="especialidades">Especialidades</label>
                    <select name="especialidad_id" id="especialidades" required>
                        <option value="" disabled>Selecciona una opción</option>
                        @foreach ($especialidad as $item)
                            <option value="{{ $item->id }}" {{ $dentista->especialidad_id == $item->id ? 'selected' : '' }}>
                                {{ $item->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        
            <!-- Botón alineado a la derecha -->
            <div class="button-row">
                <input type="submit" value="Actualizar" class="submit-btn">
            </div>
        </form>
        
    </div>
    
</x-app-layout>
<style>
    body, .navbar-brand, .navbar-text, .box, p, table, th, td, a, button,label, select,input, textarea,h1, h2, h3, h4,h5{
font-family: 'Merriweather', serif;
}

</style>