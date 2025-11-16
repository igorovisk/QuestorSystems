@extends('layouts.app')

@section('title', 'Serviços de Cobrança')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Serviços de Cobrança</h1>
    <a href="{{ route('servicos-cobranca.create') }}"
        class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md">
        Novo Serviço
    </a>
</div>

<!-- Filtros -->
<div id="filtersPanel" class="mb-6 bg-white shadow-sm rounded-lg p-4">
    <form method="GET" action="{{ route('servicos-cobranca.index') }}" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="nome_servico" class="block text-sm font-medium text-gray-700 mb-1">Nome do Serviço</label>
                <input type="text" name="nome_servico" id="nome_servico" value="{{ $filters['nome_servico'] ?? '' }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label for="cliente_id" class="block text-sm font-medium text-gray-700 mb-1">Cliente</label>
                <select name="cliente_id" id="cliente_id"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Todos os clientes</option>
                    @foreach ($clientes as $cliente)
                    <option value="{{ $cliente->id }}" {{ ($filters['cliente_id'] ?? '') == $cliente->id ? 'selected' : '' }}>
                        {{ $cliente->nome }} - {{ $cliente->email }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="banco_id" class="block text-sm font-medium text-gray-700 mb-1">Banco</label>
                <select name="banco_id" id="banco_id"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Todos os bancos</option>
                    @foreach ($bancos as $banco)
                    <option value="{{ $banco->id }}" {{ ($filters['banco_id'] ?? '') == $banco->id ? 'selected' : '' }}>
                        {{ $banco->nome_banco }} ({{ $banco->codigo_banco }})
                    </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="parcelas_geradas" class="block text-sm font-medium text-gray-700 mb-1">Parcelas Geradas</label>
                <select name="parcelas_geradas" id="parcelas_geradas"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Todos</option>
                    <option value="1" {{ ($filters['parcelas_geradas'] ?? '') === '1' ? 'selected' : '' }}>Sim</option>
                    <option value="0" {{ ($filters['parcelas_geradas'] ?? '') === '0' ? 'selected' : '' }}>Não</option>
                </select>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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
            <a href="{{ route('servicos-cobranca.index') }}"
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
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome do Serviço</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valor Total</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantidade de Parcelas</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Banco</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Parcelas Geradas</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total de Parcelas</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($servicos as $servico)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $servico->id }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    {{ $servico->nome_servico }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    R$ {{ number_format($servico->valor_total, 2, ',', '.') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $servico->quantidade_parcelas }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $servico->cliente->nome ?? 'N/A' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $servico->banco->nome_banco ?? 'N/A' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    @if($servico->parcelas_geradas)
                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                        Sim
                    </span>
                    @else
                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                        Não
                    </span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $servico->parcelas->count() }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">
                    Nenhum serviço de cobrança encontrado.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if ($servicos->hasPages())
    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
        {{ $servicos->links() }}
    </div>
    @endif
</div>

@endsection