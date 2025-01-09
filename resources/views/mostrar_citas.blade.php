<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis Citas') }}
        </h2>
    </x-slot>

    <div class="max-w-5xl mx-auto py-10 px-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Citas Programadas</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow-md rounded-lg w-full">
                <thead>
                    <tr class="bg-gray-200 text-gray-700 text-left w-full">
                        <th class="py-2 px-4 border-b text-center">Paciente</th>
                        <th class="py-2 px-4 border-b text-center">Fecha</th>
                        <th class="py-2 px-4 border-b text-center">Hora</th>
                        <th class="py-2 px-4 border-b text-center">Descripción</th>
                        <th class="py-2 px-4 border-b text-center">Estado</th>
                        <th class="py-2 px-4 border-b text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($citas as $cita)
                        <tr class="hover:bg-gray-100">
                            <td class="py-2 px-4 border-b text-center">{{ $cita->paciente->name }}</td>
                            <td class="py-2 px-4 border-b text-center">{{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}</td>
                            <td class="py-2 px-4 border-b text-center">{{ $cita->hora }}</td>
                            <td class="py-2 px-4 border-b text-center">{{ $cita->descripcion }}</td>
                            <td class="py-2 px-4 border-b text-center">
                                @if ($cita->estatus == 1)
                                    Pendiente
                                @elseif ($cita->estatus == 0)
                                    Cancelada
                                @else
                                    Aceptada
                                @endif
                            </td>
                            
                            <td class="py-2 px-4 border-b text-center">
                                <a href="{{route('citas.cancelar', ['id' => $cita->id])}}">
                                <button class="px-4 py-2 bg-red-600 text-black rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" onclick="cancelarCita({{ $cita->id }})">
                                    Cancelar
                                </button>
                                </a>
                                <a href="{{route('citas.confirmar', ['id' => $cita->id])}}">
                                <button style="padding: 8px 16px; background-color: #38a169; color: black; border-radius: 8px; border: none; cursor: pointer;" onclick="confirmarCita({{ $cita->id }})">
                                    Confirmar
                                </button>  
                                </a>                                                          
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-2 px-4 border-b text-center">No tienes citas programadas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
</x-app-layout>
