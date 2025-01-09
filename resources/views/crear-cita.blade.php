<!-- resources/views/crear-cita.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Cita') }}
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 py-10 bg-white shadow-md rounded-lg mt-6">
        <form action="{{ route('guardar.cita') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label for="fecha" class="block text-sm font-medium text-gray-700">Paciente</label>
                <input type="text" id="fecha" name="fecha" value="{{ Auth::user()->name }}" readonly 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-gray-100">
            </div>

            <div>
                <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha de la Cita</label>
                <input type="text" id="fecha" name="fecha" value="{{ $fecha }}" readonly 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-gray-100">
            </div>

            <div>
                <label for="dentista" class="block text-sm font-medium text-gray-700">Dentista</label>
                <select id="dentista" name="dentista" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="" disabled selected>Elige dentista</option>
                    @foreach ($usuarios as $usuario)
                        @if ($usuario->fk_cat_usuarios == 3)
                            <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div>
                <label for="hora" class="block text-sm font-medium text-gray-700">Hora de la Cita</label>
                <select id="hora" name="hora" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="" disabled selected>Selecciona una hora</option>
                    @for ($hour = 8; $hour <= 17; $hour++)
                        <option value="{{ $hour }}:00">{{ $hour }}:00</option>
                        <option value="{{ $hour }}:30">{{ $hour }}:30</option>
                    @endfor
                    <option value="18:00">18:00</option>
                </select>
            </div>

            <div>
                <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                <textarea id="descripcion" name="descripcion" required rows="4" 
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
            </div>

            <div class="flex items-center justify-end">
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 border border-black text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Guardar Cita
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
