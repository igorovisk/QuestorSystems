<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'QuestorSystem')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50">
    <nav class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex gap-8">
                    <div class="flex items-center">
                        <a href="{{ url('/') }}" class="text-xl font-bold text-gray-900">
                            QuestorSystem
                        </a>
                    </div>
                    <div class="flex items-center gap-4">
                        <a href="{{ route('clientes.index') }}"
                            class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('clientes.*') ? 'bg-gray-100 text-gray-900' : '' }}">
                            Clientes
                        </a>
                        <a href="{{ route('bancos.index') }}"
                            class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('bancos.*') ? 'bg-gray-100 text-gray-900' : '' }}">
                            Bancos
                        </a>
                        <a href="{{ route('boletos.index') }}"
                            class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('boletos.*') ? 'bg-gray-100 text-gray-900' : '' }}">
                            Boletos
                        </a>
                        <a href="{{ route('servicos-cobranca.index') }}"
                            class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('servicos-cobranca.*') ? 'bg-gray-100 text-gray-900' : '' }}">
                            Serviços de Cobrança
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if (session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
            role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif

        @if (session('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
        @endif

        @if (isset($errors) && $errors->any())
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @yield('content')
    </main>
</body>

</html>