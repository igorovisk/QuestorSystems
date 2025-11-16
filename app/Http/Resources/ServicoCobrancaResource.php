<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServicoCobrancaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nome_servico' => $this->nome_servico,
            'valor_total' => (float) $this->valor_total,
            'quantidade_parcelas' => $this->quantidade_parcelas,
            'parcelas_geradas' => $this->parcelas_geradas,
            'cliente_id' => $this->cliente_id,
            'banco_id' => $this->banco_id,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
            'cliente' => new ClienteResource($this->whenLoaded('cliente')),
            'banco' => new BancoResource($this->whenLoaded('banco')),
            'parcelas' => $this->whenLoaded('parcelas', function () {
                return $this->parcelas->map(function ($parcela) {
                    return [
                        'id' => $parcela->id,
                        'numero_parcela' => $parcela->numero_parcela ?? null,
                        'valor' => (float) ($parcela->valor ?? 0),
                        'data_vencimento' => $parcela->data_vencimento?->format('Y-m-d'),
                    ];
                });
            }),
            'parcelas_count' => $this->when(isset($this->parcelas_count), $this->parcelas_count),
        ];
    }
}
