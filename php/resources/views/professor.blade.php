<div>
    <!-- Nothing in life is to be feared, it is only to be understood. Now is the time to understand more, so that we may fear less. - Marie Curie -->
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Professor') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200">
                        <h1 class="text-3xl font-bold text-green-custom text-center mb-2">PROFESSOR</h1>
                        <p class="text-center text-gray-700 mb-6">Bem-vindo ao sistema de gestão de professores!</p>
                        <!-- Conteúdo do professor -->
                    </div>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200">
                    <h2 class="text-xl font-semibold mb-4">Informações do Professor</h2>
                    <p>Nome: {{ $professor->nome }}</p>
                    <p>Email: {{ $professor->email }}</p>
                    <!-- Adicione mais informações conforme necessário -->
                </div>
            </div>
        </div>
</div>
