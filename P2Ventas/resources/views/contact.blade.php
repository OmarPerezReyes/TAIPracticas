<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Contact') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form>
                        <div class="mb-3">
                            <label for="contactName" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="contactName">
                        </div>
                        <div class="mb-3">
                            <label for="contactEmail" class="form-label">Correo electrónico</label>
                            <input type="email" class="form-control" id="contactEmail">
                        </div>
                        <div class="mb-3">
                            <label for="contactMessage" class="form-label">Mensaje</label>
                            <textarea class="form-control" id="contactMessage" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>