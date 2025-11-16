<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BancoResource extends JsonResource
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
            'nome_banco' => $this->nome_banco,
            'codigo_banco' => $this->codigo_banco,
            'percentual_juros' => (float) $this->percentual_juros,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
            'boletos' => BoletoResource::collection($this->whenLoaded('boletos')),
            'boletos_count' => $this->when(isset($this->boletos_count), $this->boletos_count),
        ];
    }
}
