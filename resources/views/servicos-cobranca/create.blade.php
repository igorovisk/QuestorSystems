<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Serviço de Cobrança</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-6">Criar Serviço de Cobrança</h1>

            <form id="formServicoCobranca" class="space-y-4">
                @csrf

                <!-- Nome do Serviço -->
                <div>
                    <label for="nome_servico" class="block text-sm font-medium text-gray-700 mb-1">
                        Nome do Serviço *
                    </label>
                    <input type="text"
                        id="nome_servico"
                        name="nome_servico"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Cliente -->
                <div>
                    <label for="cliente_id" class="block text-sm font-medium text-gray-700 mb-1">
                        Cliente *
                    </label>
                    <select id="cliente_id"
                        name="cliente_id"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Selecione um cliente</option>
                        @foreach($clientes as $cliente)
                        <option value="{{ $cliente->id }}">{{ $cliente->nome }} - {{ $cliente->email }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Banco -->
                <div>
                    <label for="banco_id" class="block text-sm font-medium text-gray-700 mb-1">
                        Banco *
                    </label>
                    <select id="banco_id"
                        name="banco_id"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Selecione um banco</option>
                        @foreach($bancos as $banco)
                        <option value="{{ $banco->id }}">{{ $banco->nome_banco }} ({{ $banco->codigo_banco }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Valor Total -->
                <div>
                    <label for="valor_total" class="block text-sm font-medium text-gray-700 mb-1">
                        Valor Total (R$) *
                    </label>
                    <input type="number"
                        id="valor_total"
                        name="valor_total"
                        step="0.01"
                        min="0.01"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Quantidade de Parcelas -->
                <div>
                    <label for="quantidade_parcelas" class="block text-sm font-medium text-gray-700 mb-1">
                        Quantidade de Parcelas *
                    </label>
                    <input type="number"
                        id="quantidade_parcelas"
                        name="quantidade_parcelas"
                        min="1"
                        max="60"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Botões -->
                <div class="flex gap-4 pt-4">
                    <button type="submit"
                        class="flex-1 bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Criar Serviço
                    </button>
                    <a href="/"
                        class="flex-1 bg-gray-300 text-gray-700 py-2 px-4 rounded-md hover:bg-gray-400 text-center">
                        Cancelar
                    </a>
                </div>
            </form>

            <!-- Mensagem de Sucesso/Erro -->
            <div id="mensagem" class="mt-4 hidden"></div>
        </div>
    </div>

    <script>
        document.getElementById('formServicoCobranca').addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const data = Object.fromEntries(formData);
            data.valor_total = parseFloat(data.valor_total);
            data.quantidade_parcelas = parseInt(data.quantidade_parcelas);
            data.cliente_id = parseInt(data.cliente_id);
            data.banco_id = parseInt(data.banco_id);

            const mensagemDiv = document.getElementById('mensagem');
            mensagemDiv.classList.remove('hidden');

            try {
                const response = await fetch('/servicos-cobranca', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: JSON.stringify(data)
                });

                const contentType = response.headers.get('content-type');

                if (contentType && contentType.includes('application/json')) {
                    const result = await response.json();

                    if (response.ok) {
                        mensagemDiv.className = 'mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded';
                        mensagemDiv.textContent = result.message || 'Serviço criado com sucesso! O email será enviado em breve.';
                        this.reset();

                        // Redireciona após 2 segundos
                        setTimeout(() => {
                            window.location.href = '/servicos-cobranca';
                        }, 2000);
                    } else {
                        mensagemDiv.className = 'mt-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded';
                        let errorMessage = result.message || 'Erro ao criar serviço.';

                        // Se houver erros de validação, mostra eles
                        if (result.errors) {
                            const errorsList = Object.values(result.errors).flat().join(', ');
                            errorMessage += ' ' + errorsList;
                        }

                        mensagemDiv.textContent = errorMessage;
                    }
                } else {
                    // Se não for JSON, pode ser um redirect HTML
                    if (response.redirected) {
                        window.location.href = response.url;
                    } else {
                        mensagemDiv.className = 'mt-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded';
                        mensagemDiv.textContent = 'Erro ao processar requisição.';
                    }
                }
            } catch (error) {
                mensagemDiv.className = 'mt-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded';
                mensagemDiv.textContent = 'Erro ao processar requisição.';
            }
        });
    </script>
</body>

</html>