@extends('layouts.app')

@section('title', 'Boletos')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Boletos</h1>
    <a href="{{ route('boletos.create') }}"
        class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md">
        Novo Boleto
    </a>
</div>

<!-- Filtros -->
<div id="filtersPanel" class="mb-6 bg-white shadow-sm rounded-lg p-4">
    <form method="GET" action="{{ route('boletos.index') }}" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="nome_pagador" class="block text-sm font-medium text-gray-700 mb-1">Nome do Pagador</label>
                <input type="text" name="nome_pagador" id="nome_pagador" value="{{ $filters['nome_pagador'] ?? '' }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label for="nome_beneficiario" class="block text-sm font-medium text-gray-700 mb-1">Nome do Beneficiário</label>
                <input type="text" name="nome_beneficiario" id="nome_beneficiario" value="{{ $filters['nome_beneficiario'] ?? '' }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label for="cpf_cnpj_pagador" class="block text-sm font-medium text-gray-700 mb-1">CPF/CNPJ Pagador</label>
                <input type="text" name="cpf_cnpj_pagador" id="cpf_cnpj_pagador" value="{{ $filters['cpf_cnpj_pagador'] ?? '' }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="valor_min" class="block text-sm font-medium text-gray-700 mb-1">Valor Mínimo (R$)</label>
                <input type="number" name="valor_min" id="valor_min" step="0.01" min="0"
                    value="{{ $filters['valor_min'] ?? '' }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label for="valor_max" class="block text-sm font-medium text-gray-700 mb-1">Valor Máximo (R$)</label>
                <input type="number" name="valor_max" id="valor_max" step="0.01" min="0"
                    value="{{ $filters['valor_max'] ?? '' }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label for="data_vencimento_inicio" class="block text-sm font-medium text-gray-700 mb-1">Vencimento Início</label>
                <input type="date" name="data_vencimento_inicio" id="data_vencimento_inicio"
                    value="{{ $filters['data_vencimento_inicio'] ?? '' }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label for="data_vencimento_fim" class="block text-sm font-medium text-gray-700 mb-1">Vencimento Fim</label>
                <input type="date" name="data_vencimento_fim" id="data_vencimento_fim"
                    value="{{ $filters['data_vencimento_fim'] ?? '' }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
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
            <a href="{{ route('boletos.index') }}"
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
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pagador</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valor</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vencimento</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Banco</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($boletos as $boleto)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $boleto->id }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    {{ $boleto->nome_pagador }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    R$ {{ number_format($boleto->valor, 2, ',', '.') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $boleto->data_vencimento->format('d/m/Y') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $boleto->banco->nome_banco ?? 'N/A' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $boleto->cliente->nome ?? 'N/A' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <div class="flex gap-2">
                        <a href="{{ route('boletos.show', $boleto->id) }}"
                            class="text-blue-600 hover:text-blue-900">Ver</a>
                        <a href="{{ route('boletos.edit', $boleto->id) }}"
                            class="text-indigo-600 hover:text-indigo-900">Editar</a>
                        <form action="{{ route('boletos.destroy', $boleto->id) }}" method="POST"
                            class="inline"
                            onsubmit="return confirm('Tem certeza que deseja deletar este boleto?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Deletar</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                    Nenhum boleto encontrado.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if ($boletos->hasPages())
    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
        {{ $boletos->links() }}
    </div>
    @endif
</div>

@endsection