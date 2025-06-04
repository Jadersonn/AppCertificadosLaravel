<!-- It is never too late to be what you might have been. - George Eliot -->
<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Aluno') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200">
                    <h1 class="text-3xl font-bold text-green-custom text-center mb-2">ALUNO</h1>
                    <p class="text-center text-gray-700 mb-6">Bem-vindo ao sistema de gestão de alunos!</p>
                    <!-- Conteúdo do aluno -->
                </div>
            </div>
        </div>
    </div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200">
                <h2 class="text-xl font-semibold mb-4">Informações do Aluno</h2>
            </div>
        </div>
    </div>
</x-guest-layout>