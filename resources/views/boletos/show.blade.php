@extends('layouts.app')

@section('title', 'Boleto #' . $boleto->id)

@section('content')
<div class="mb-6">
    <a href="{{ route('boletos.index') }}"
        class="text-blue-600 hover:text-blue-800 mb-4 inline-block">← Voltar para lista</a>
    <h1 class="text-3xl font-bold text-gray-900">Boleto #{{ $boleto->id }}</h1>
</div>

<div class="bg-white shadow-sm rounded-lg overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-medium text-gray-900">Informações do Boleto</h2>
    </div>
    <div class="px-6 py-4">
        <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <div>
                <dt class="text-sm font-medium text-gray-500">ID</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $boleto->id }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Valor</dt>
                <dd class="mt-1 text-sm text-gray-900 font-semibold">
                    R$ {{ number_format($boleto->valor, 2, ',', '.') }}
                </dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Data de Vencimento</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $boleto->data_vencimento->format('d/m/Y') }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Pagador</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $boleto->nome_pagador }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">CPF/CNPJ Pagador</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $boleto->cpf_cnpj_pagador }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Beneficiário</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $boleto->nome_beneficiario }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">CPF/CNPJ Beneficiário</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $boleto->cpf_cnpj_beneficiario }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Banco</dt>
                <dd class="mt-1 text-sm text-gray-900">
                    <a href="{{ route('bancos.show', $boleto->banco_id) }}"
                        class="text-blue-600 hover:text-blue-800">
                        {{ $boleto->banco->nome_banco ?? 'N/A' }} ({{ $boleto->banco->codigo_banco ?? 'N/A' }})
                    </a>
                </dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Cliente</dt>
                <dd class="mt-1 text-sm text-gray-900">
                    <a href="{{ route('clientes.show', $boleto->cliente_id) }}"
                        class="text-blue-600 hover:text-blue-800">
                        {{ $boleto->cliente->nome ?? 'N/A' }}
                    </a>
                </dd>
            </div>
            @if ($boleto->observacao)
            <div class="sm:col-span-2">
                <dt class="text-sm font-medium text-gray-500">Observação</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $boleto->observacao }}</dd>
            </div>
            @endif
            <div>
                <dt class="text-sm font-medium text-gray-500">Criado em</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $boleto->created_at->format('d/m/Y H:i') }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Atualizado em</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $boleto->updated_at->format('d/m/Y H:i') }}</dd>
            </div>
        </dl>
    </div>
</div>

<div class="mt-6 flex gap-4">
    <a href="{{ route('boletos.edit', $boleto->id) }}"
        class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-md">
        Editar Boleto
    </a>
    <form action="{{ route('boletos.destroy', $boleto->id) }}" method="POST" class="inline"
        onsubmit="return confirm('Tem certeza que deseja deletar este boleto?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-md">
            Deletar Boleto
        </button>
    </form>
</div>
@endsection