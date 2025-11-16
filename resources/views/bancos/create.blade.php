@extends('layouts.app')

@section('title', 'Novo Banco')

@section('content')
<div class="mb-6">
    <a href="{{ route('bancos.index') }}"
        class="text-blue-600 hover:text-blue-800 mb-4 inline-block">← Voltar para lista</a>
    <h1 class="text-3xl font-bold text-gray-900">Novo Banco</h1>
</div>

<div class="bg-white shadow-sm rounded-lg p-6">
    <form action="{{ route('bancos.store') }}" method="POST">
        @csrf

        <div class="space-y-4">
            <div>
                <label for="nome_banco" class="block text-sm font-medium text-gray-700 mb-1">
                    Nome do Banco *
                </label>
                <input type="text" name="nome_banco" id="nome_banco" value="{{ old('nome_banco') }}" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                @error('nome_banco')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="codigo_banco" class="block text-sm font-medium text-gray-700 mb-1">
                    Código do Banco *
                </label>
                <input type="text" name="codigo_banco" id="codigo_banco" value="{{ old('codigo_banco') }}" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                @error('codigo_banco')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="percentual_juros" class="block text-sm font-medium text-gray-700 mb-1">
                    Percentual de Juros (%) *
                </label>
                <input type="number" name="percentual_juros" id="percentual_juros" step="0.01" min="0" max="100"
                    value="{{ old('percentual_juros') }}" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                @error('percentual_juros')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-6 flex gap-4">
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md">
                Criar Banco
            </button>
            <a href="{{ route('bancos.index') }}"
                class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium py-2 px-4 rounded-md">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection