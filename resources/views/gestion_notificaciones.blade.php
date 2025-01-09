<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Enviar Email') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('enviar.email') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="titulo" class="block font-medium text-sm text-gray-700">Título</label>
                            <input type="text" id="titulo" name="titulo" class="form-input rounded-md shadow-sm mt-1 block w-full">
                        </div>

                        <div class="mb-4">
                            <label for="mensaje" class="block font-medium text-sm text-gray-700">Mensaje</label>
                            <textarea id="mensaje" name="mensaje" class="form-textarea rounded-md shadow-sm mt-1 block w-full"></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block font-medium text-sm text-gray-700">Email Destinatario</label>
                            <input type="email" id="email" name="email" class="form-input rounded-md shadow-sm mt-1 block w-full">
                        </div>

                        <div>
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150" style="background-color: #000000;">
                                Enviar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
