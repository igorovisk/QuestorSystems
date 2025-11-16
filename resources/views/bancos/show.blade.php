@extends('layouts.app')

@section('title', 'Banco: ' . $banco->nome_banco)

@section('content')
<div class="mb-6">
    <a href="{{ route('bancos.index') }}"
        class="text-blue-600 hover:text-blue-800 mb-4 inline-block">← Voltar para lista</a>
    <h1 class="text-3xl font-bold text-gray-900">Banco: {{ $banco->nome_banco }}</h1>
</div>

<div class="bg-white shadow-sm rounded-lg overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-medium text-gray-900">Informações do Banco</h2>
    </div>
    <div class="px-6 py-4">
        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
                <dt class="text-sm font-medium text-gray-500">ID</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $banco->id }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Nome do Banco</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $banco->nome_banco }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Código do Banco</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $banco->codigo_banco }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Percentual de Juros</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ number_format($banco->percentual_juros, 2, ',', '.') }}%
                </dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Total de Boletos</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $banco->boletos->count() }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Criado em</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $banco->created_at->format('d/m/Y H:i') }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Atualizado em</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $banco->updated_at->format('d/m/Y H:i') }}</dd>
            </div>
        </dl>
    </div>
</div>

@if ($banco->boletos->count() > 0)
<div class="mt-6 bg-white shadow-sm rounded-lg overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-medium text-gray-900">Boletos do Banco</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pagador</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Valor</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Vencimento</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ações</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($banco->boletos as $boleto)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $boleto->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $boleto->nome_pagador }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        R$ {{ number_format($boleto->valor, 2, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $boleto->data_vencimento->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $boleto->cliente->nome ?? 'N/A' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('boletos.show', $boleto->id) }}"
                            class="text-blue-600 hover:text-blue-900">Ver</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

<div class="mt-6 flex gap-4">
    <a href="{{ route('bancos.edit', $banco->id) }}"
        class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-md">
        Editar Banco
    </a>
    <form action="{{ route('bancos.destroy', $banco->id) }}" method="POST" class="inline"
        onsubmit="return confirm('Tem certeza que deseja deletar este banco?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-md">
            Deletar Banco
        </button>
    </form>
</div>
@endsection