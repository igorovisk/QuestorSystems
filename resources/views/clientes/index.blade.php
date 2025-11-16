@extends('layouts.app')

@section('title', 'Clientes')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Clientes</h1>
    <a href="{{ route('clientes.create') }}"
        class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md">
        Novo Cliente
    </a>
</div>

<!-- Filtros -->
<div id="filtersPanel" class="mb-6 bg-white shadow-sm rounded-lg p-4">
    <form method="GET" action="{{ route('clientes.index') }}" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="nome" class="block text-sm font-medium text-gray-700 mb-1">Nome</label>
                <input type="text" name="nome" id="nome" value="{{ $filters['nome'] ?? '' }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="text" name="email" id="email" value="{{ $filters['email'] ?? '' }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label for="per_page" class="block text-sm font-medium text-gray-700 mb-1">Itens por página</label>
                <select name="per_page" id="per_page"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="15" {{ $perPage == 15 ? 'selected' : '' }}>15</option>
                    <option value="30" {{ $perPage == 30 ? 'selected' : '' }}>30</option>
                    <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                </select>
            </div>
        </div>
        <div class="flex gap-2">
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md">
                Aplicar Filtros
            </button>
            <a href="{{ route('clientes.index') }}"
                class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium py-2 px-4 rounded-md">
                Limpar Filtros
            </a>
        </div>
    </form>
</div>

<div class="bg-white shadow-sm rounded-lg overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Boletos</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($clientes as $cliente)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $cliente->id }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $cliente->nome }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $cliente->email }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs">
                        {{ $cliente->boletos->count() }} boleto(s)
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <div class="flex gap-2">
                        <a href="{{ route('clientes.show', $cliente->id) }}"
                            class="text-blue-600 hover:text-blue-900">Ver</a>
                        <a href="{{ route('clientes.edit', $cliente->id) }}"
                            class="text-indigo-600 hover:text-indigo-900">Editar</a>
                        <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST"
                            class="inline"
                            onsubmit="return confirm('Tem certeza que deseja deletar este cliente?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Deletar</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                    Nenhum cliente encontrado.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if ($clientes->hasPages())
    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
        {{ $clientes->links() }}
    </div>
    @endif
</div>

@endsection