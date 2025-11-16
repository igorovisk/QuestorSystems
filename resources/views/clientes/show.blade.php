@extends('layouts.app')

@section('title', 'Cliente: ' . $cliente->nome)

@section('content')
<div class="mb-6">
    <a href="{{ route('clientes.index') }}"
        class="text-blue-600 hover:text-blue-800 mb-4 inline-block">← Voltar para lista</a>
    <h1 class="text-3xl font-bold text-gray-900">Cliente: {{ $cliente->nome }}</h1>
</div>

<div class="bg-white shadow-sm rounded-lg overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-medium text-gray-900">Informações do Cliente</h2>
    </div>
    <div class="px-6 py-4">
        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
                <dt class="text-sm font-medium text-gray-500">ID</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $cliente->id }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Nome</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $cliente->nome }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Email</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $cliente->email }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Total de Boletos</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $cliente->boletos->count() }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Criado em</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $cliente->created_at->format('d/m/Y H:i') }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Atualizado em</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $cliente->updated_at->format('d/m/Y H:i') }}</dd>
            </div>
        </dl>
    </div>
</div>

@if ($cliente->boletos->count() > 0)
<div class="mt-6 bg-white shadow-sm rounded-lg overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-medium text-gray-900">Boletos do Cliente</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pagador</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Valor</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Vencimento</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Banco</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ações</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($cliente->boletos as $boleto)
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
                        {{ $boleto->banco->nome_banco ?? 'N/A' }}
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
    <a href="{{ route('clientes.edit', $cliente->id) }}"
        class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-md">
        Editar Cliente
    </a>
    <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" class="inline"
        onsubmit="return confirm('Tem certeza que deseja deletar este cliente?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-md">
            Deletar Cliente
        </button>
    </form>
</div>
@endsection