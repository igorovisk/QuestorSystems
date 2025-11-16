<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Questor Systems</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <nav class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold p-4" style="color: #f97316; ">
                        Questor Systems
                    </h1>
                </div>
            </div>
        </div>
    </nav>

    <!-- Conteúdo Principal -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6">
            <!-- Listar Clientes -->
            <a href="{{ route('clientes.index') }}"
                class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200 p-6 group">
                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 rounded-lg flex items-center justify-center mb-4 transition-colors p-5"
                        style="background-color: #f97316;">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-1">Listar Clientes</h3>
                    <p class="text-sm text-gray-600">Gerenciar clientes</p>
                </div>
            </a>

            <!-- Listar Bancos -->
            <a href="{{ route('bancos.index') }}"
                class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200 p-6 group">
                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 rounded-lg flex items-center justify-center mb-4 transition-colors  p-5"
                        style="background-color: #f97316;">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-1">Listar Bancos</h3>
                    <p class="text-sm text-gray-600">Gerenciar bancos</p>
                </div>
            </a>

            <!-- Listar Boletos -->
            <a href="{{ route('boletos.index') }}"
                class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200 p-6 group">
                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 rounded-lg flex items-center justify-center mb-4 transition-colors  p-5"
                        style="background-color: #f97316;">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-1">Listar Boletos</h3>
                    <p class="text-sm text-gray-600">Gerenciar boletos</p>
                </div>
            </a>

            <!-- Monitorar Jobs -->
            <a href="{{ url('/horizon') }}"
                class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200 p-6 group">
                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 rounded-lg flex items-center justify-center mb-4 transition-colors  p-5"
                        style="background-color: #f97316;">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-1">Monitorar Jobs</h3>
                    <p class="text-sm text-gray-600">Laravel Horizon</p>
                </div>
            </a>

            <!-- Criar Serviço de Cobrança -->
            <a href="{{ route('servicos-cobranca.create') }}"
                class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200 p-6 group">
                <div class="flex flex-col items-center text-center">
                    <div class="w-16 h-16 rounded-lg flex items-center justify-center mb-4 transition-colors  p-5"
                        style="background-color: #f97316;">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-1">Criar Serviço</h3>
                    <p class="text-sm text-gray-600">Gerar parcelas e enviar email</p>
                </div>
            </a>
        </div>
    </main>
</body>

</html>