<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BoletoResource extends JsonResource
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
            'nome_pagador' => $this->nome_pagador,
            'cpf_cnpj_pagador' => $this->cpf_cnpj_pagador,
            'nome_beneficiario' => $this->nome_beneficiario,
            'cpf_cnpj_beneficiario' => $this->cpf_cnpj_beneficiario,
            'valor' => (float) $this->valor,
            'data_vencimento' => $this->data_vencimento?->format('Y-m-d'),
            'observacao' => $this->observacao,
            'banco_id' => $this->banco_id,
            'cliente_id' => $this->cliente_id,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
            'cliente' => new ClienteResource($this->whenLoaded('cliente')),
            'banco' => new BancoResource($this->whenLoaded('banco')),
        ];
    }
}
