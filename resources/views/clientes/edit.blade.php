@extends('layouts.app')

@section('title', 'Editar Cliente')

@section('content')
<div class="mb-6">
    <a href="{{ route('clientes.index') }}"
        class="text-blue-600 hover:text-blue-800 mb-4 inline-block">← Voltar para lista</a>
    <h1 class="text-3xl font-bold text-gray-900">Editar Cliente</h1>
</div>

<div class="bg-white shadow-sm rounded-lg p-6">
    <form action="{{ route('clientes.update', $cliente->id) }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="space-y-4">
            <div>
                <label for="nome" class="block text-sm font-medium text-gray-700 mb-1">
                    Nome *
                </label>
                <input type="text" name="nome" id="nome" value="{{ old('nome', $cliente->nome) }}" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                @error('nome')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                    Email *
                </label>
                <input type="email" name="email" id="email" value="{{ old('email', $cliente->email) }}" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-6 flex gap-4">
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md">
                Salvar
            </button>
            <a href="{{ route('clientes.show', $cliente->id) }}"
                class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium py-2 px-4 rounded-md">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection