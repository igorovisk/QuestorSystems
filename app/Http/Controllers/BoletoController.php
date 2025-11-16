<?php

namespace App\Http\Controllers;

use App\DTOs\CreateBoletoDTO;
use App\DTOs\UpdateBoletoDTO;
use App\Http\Resources\BoletoCollection;
use App\Http\Resources\BoletoResource;
use App\Services\BoletoService;
use Illuminate\Http\Request;

class BoletoController extends Controller
{
    public function __construct(
        private readonly BoletoService $service
    ) {}

    /**
     * Display a listing of the resource.
     * GET /boletos?page=1&per_page=10&nome_pagador=João&valor_min=100&valor_max=5000&banco_id=1&cliente_id=1&sort_by=valor&sort_order=desc
     */
    public function index(Request $request)
    {
        $filters = $request->only([
            'nome_pagador',
            'nome_beneficiario',
            'cpf_cnpj_pagador',
            'valor_min',
            'valor_max',
            'data_vencimento_inicio',
            'data_vencimento_fim',
            'banco_id',
            'cliente_id',
        ]);
        $sortBy = $request->get('sort_by', 'id');
        $sortOrder = $request->get('sort_order', 'asc');
        $perPage = (int) $request->get('per_page', 15);

        $boletos = $this->service->paginate($filters, $sortBy, $sortOrder, $perPage);

        if ($request->is('api/*')) {
            return new BoletoCollection($boletos);
        }

        $bancos = \App\Models\Banco::all();
        $clientes = \App\Models\Cliente::all();

        return view('boletos.index', compact('boletos', 'filters', 'sortBy', 'sortOrder', 'perPage', 'bancos', 'clientes'));
    }

    /**
     * Show the form for creating a new resource.
     * GET /boletos/create
     */
    public function create()
    {
        $bancos = \App\Models\Banco::all();
        $clientes = \App\Models\Cliente::all();

        return view('boletos.create', compact('bancos', 'clientes'));
    }

    /**
     * Store a newly created resource in storage.
     * POST /boletos
     */
    public function store(Request $request)
    {
        $dto = CreateBoletoDTO::from($request->all());
        $boleto = $this->service->create($dto);

        if ($request->is('api/*')) {
            $boletoModel = \App\Models\Boleto::with(['cliente', 'banco'])->findOrFail($boleto->id);

            return (new BoletoResource($boletoModel))->response()->setStatusCode(201);
        }

        return redirect()->route('boletos.show', $boleto->id)
            ->with('success', 'Boleto criado com sucesso!');
    }

    /**
     * Display the specified resource.
     * GET /boletos/{id}
     */
    public function show(Request $request, string $id)
    {
        if ($request->is('api/*')) {
            $boleto = \App\Models\Boleto::with(['cliente', 'banco'])->findOrFail((int) $id);

            return new BoletoResource($boleto);
        }

        $boleto = \App\Models\Boleto::with(['cliente', 'banco'])->findOrFail((int) $id);

        return view('boletos.show', compact('boleto'));
    }

    /**
     * Show the form for editing the specified resource.
     * GET /boletos/{id}/edit
     */
    public function edit(string $id)
    {
        $boleto = \App\Models\Boleto::with(['cliente', 'banco'])->findOrFail((int) $id);
        $bancos = \App\Models\Banco::all();
        $clientes = \App\Models\Cliente::all();

        return view('boletos.edit', compact('boleto', 'bancos', 'clientes'));
    }

    /**
     * Update the specified resource in storage.
     * PUT/PATCH /boletos/{id}
     */
    public function update(Request $request, string $id)
    {
        $dto = UpdateBoletoDTO::from($request->all());
        $boleto = $this->service->update((int) $id, $dto);

        if ($request->is('api/*')) {
            $boletoModel = \App\Models\Boleto::with(['cliente', 'banco'])->findOrFail((int) $id);

            return new BoletoResource($boletoModel);
        }

        return redirect()->route('boletos.show', $boleto->id)
            ->with('success', 'Boleto atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /boletos/{id}
     */
    public function destroy(Request $request, string $id)
    {
        $this->service->delete((int) $id);

        if ($request->is('api/*')) {
            return response()->json(['message' => 'Boleto deletado com sucesso'], 200);
        }

        return redirect()->route('boletos.index')
            ->with('success', 'Boleto deletado com sucesso!');
    }
}
