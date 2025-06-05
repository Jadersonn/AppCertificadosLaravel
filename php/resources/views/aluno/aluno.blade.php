<x-app-layout>
    <div class="flex h-screen bg-green-900 text-white">
        <!-- Sidebar -->
        <aside class="w-60 bg-green-800 flex flex-col justify-between p-4">
            <div>
                <!-- Logo -->
                <div class="w-12 h-12 bg-white mb-4 rounded"></div>
                <nav class="space-y-4 text-sm">
                    <p><a href="#" class="hover:underline">Sistema Acadêmico</a></p>
                    <p><a href="#" class="hover:underline">EAD - Moodle</a></p>
                    <p><a href="#" class="hover:underline">Site IFMS</a></p>
                </nav>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="bg-black p-2 rounded w-full mt-4">SAIR</button>
            </form>
        </aside>

        <!-- Main content -->
        <main class="flex-1 bg-white text-black p-8 flex">
            <!-- Coluna central -->
            <div class="w-3/4 pr-6">
                <h1 class="text-3xl font-bold mb-4">Olá, {{ $aluno->user->name ?? 'Usuário' }}</h1>

                <h2 class="text-xl font-semibold mb-4">CATEGORIAS</h2>

                @php
                    $categorias = [
                        ['nome' => 'Categoria 1', 'progresso' => 50],
                        ['nome' => 'Categoria 2', 'progresso' => 90],
                        ['nome' => 'Categoria 3', 'progresso' => 0],
                        ['nome' => 'Categoria 4', 'progresso' => 100],
                    ];
                @endphp

                @foreach ($categorias as $cat)
                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-1">
                            <span class="font-semibold">{{ $cat['nome'] }}</span>
                            <button class="bg-blue-500 text-white text-sm px-3 py-1 rounded">enviar</button>
                        </div>
                        <div class="w-full h-5 bg-gray-300 rounded">
                            <!--<div class="h-full bg-green-600 rounded" style="width: {{ $cat[''] }}%"></div>-->
                        </div>
                        <p class="text-right text-sm mt-1">{{ $cat['progresso'] }}%</p>
                    </div>
                @endforeach
            </div>

            <!-- Coluna direita -->
            <div class="w-1/4 space-y-4">
                <div class="bg-gray-200 text-center text-green-700 p-6 rounded-full">
                    <p class="text-xl font-bold">RESTAM:</p>
                    <p class="text-4xl font-bold">
                        {{ 170 - $aluno->pontosRecebidos }}
                        <br><span class="text-lg">Pontos</span>
                    </p>
                </div>
                <div class="bg-gray-200 text-center p-4 rounded">
                    <p>-----Mostra msgs de status-----</p>
                </div>
                <div class="bg-gray-200 text-center p-4 rounded">
                    <p>Regulamento de Carga<br>Horária</p>
                </div>
                <div class="bg-gray-200 text-center p-4 rounded">
                    <p>Dicas para gerenciamento<br>de suas horas<br>complementares durante o curso</p>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
