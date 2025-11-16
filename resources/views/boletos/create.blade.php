@extends('layouts.app')

@section('title', 'Novo Boleto')

@section('content')
<div class="mb-6">
    <a href="{{ route('boletos.index') }}"
        class="text-blue-600 hover:text-blue-800 mb-4 inline-block">← Voltar para lista</a>
    <h1 class="text-3xl font-bold text-gray-900">Novo Boleto</h1>
</div>

<div class="bg-white shadow-sm rounded-lg p-6">
    <form action="{{ route('boletos.store') }}" method="POST">
        @csrf

        <div class="space-y-4">
            <div>
                <label for="nome_pagador" class="block text-sm font-medium text-gray-700 mb-1">
                    Nome do Pagador *
                </label>
                <input type="text" name="nome_pagador" id="nome_pagador" value="{{ old('nome_pagador') }}" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                @error('nome_pagador')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="cpf_cnpj_pagador" class="block text-sm font-medium text-gray-700 mb-1">
                    CPF/CNPJ do Pagador *
                </label>
                <input type="text" name="cpf_cnpj_pagador" id="cpf_cnpj_pagador" value="{{ old('cpf_cnpj_pagador') }}"
                    required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                @error('cpf_cnpj_pagador')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="nome_beneficiario" class="block text-sm font-medium text-gray-700 mb-1">
                    Nome do Beneficiário *
                </label>
                <input type="text" name="nome_beneficiario" id="nome_beneficiario"
                    value="{{ old('nome_beneficiario') }}" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                @error('nome_beneficiario')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="cpf_cnpj_beneficiario" class="block text-sm font-medium text-gray-700 mb-1">
                    CPF/CNPJ do Beneficiário *
                </label>
                <input type="text" name="cpf_cnpj_beneficiario" id="cpf_cnpj_beneficiario"
                    value="{{ old('cpf_cnpj_beneficiario') }}" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                @error('cpf_cnpj_beneficiario')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="valor" class="block text-sm font-medium text-gray-700 mb-1">
                    Valor (R$) *
                </label>
                <input type="number" name="valor" id="valor" step="0.01" min="0.01"
                    value="{{ old('valor') }}" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                @error('valor')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="data_vencimento" class="block text-sm font-medium text-gray-700 mb-1">
                    Data de Vencimento *
                </label>
                <input type="date" name="data_vencimento" id="data_vencimento"
                    value="{{ old('data_vencimento') }}" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                @error('data_vencimento')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="banco_id" class="block text-sm font-medium text-gray-700 mb-1">
                    Banco *
                </label>
                <select name="banco_id" id="banco_id" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Selecione um banco</option>
                    @foreach ($bancos as $banco)
                    <option value="{{ $banco->id }}" {{ old('banco_id') == $banco->id ? 'selected' : '' }}>
                        {{ $banco->nome_banco }} ({{ $banco->codigo_banco }})
                    </option>
                    @endforeach
                </select>
                @error('banco_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="cliente_id" class="block text-sm font-medium text-gray-700 mb-1">
                    Cliente *
                </label>
                <select name="cliente_id" id="cliente_id" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Selecione um cliente</option>
                    @foreach ($clientes as $cliente)
                    <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                        {{ $cliente->nome }} - {{ $cliente->email }}
                    </option>
                    @endforeach
                </select>
                @error('cliente_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="observacao" class="block text-sm font-medium text-gray-700 mb-1">
                    Observação
                </label>
                <textarea name="observacao" id="observacao" rows="3"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('observacao') }}</textarea>
                @error('observacao')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-6 flex gap-4">
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md">
                Criar Boleto
            </button>
            <a href="{{ route('boletos.index') }}"
                class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium py-2 px-4 rounded-md">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection