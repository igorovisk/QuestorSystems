<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background-color: #4F46E5;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }

        .content {
            background-color: #f9fafb;
            padding: 20px;
            border: 1px solid #e5e7eb;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: white;
        }

        .table th,
        .table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }

        .table th {
            background-color: #f3f4f6;
            font-weight: bold;
        }

        .table tr:last-child td {
            border-bottom: none;
        }

        .footer {
            background-color: #f3f4f6;
            padding: 15px;
            text-align: center;
            font-size: 12px;
            color: #6b7280;
            border-radius: 0 0 5px 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Parcelas do Serviço de Cobrança</h1>
        </div>

        <div class="content">
            <p>Olá <strong>{{ $cliente->nome }}</strong>,</p>

            <p>Segue abaixo o detalhamento das parcelas do serviço <strong>{{ $servico->nome_servico }}</strong>:</p>

            <table class="table">
                <thead>
                    <tr>
                        <th>Parcela</th>
                        <th>Valor</th>
                        <th>Data de Vencimento</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($parcelas as $parcela)
                    <tr>
                        <td>{{ $parcela->numero_parcela }}/{{ $servico->quantidade_parcelas }}</td>
                        <td>R$ {{ number_format($parcela->valor, 2, ',', '.') }}</td>
                        <td>{{ \Carbon\Carbon::parse($parcela->data_vencimento)->format('d/m/Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <p><strong>Valor Total:</strong> R$ {{ number_format($servico->valor_total, 2, ',', '.') }}</p>
            <p><strong>Banco:</strong> {{ $servico->banco->nome_banco }} ({{ $servico->banco->codigo_banco }})</p>

            <p>Atenciosamente,<br>Equipe QuestorSystem</p>
        </div>

        <div class="footer">
            Este é um email automático, por favor não responda.
        </div>
    </div>
</body>

</html>