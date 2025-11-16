<?php

namespace App\Http\Controllers;

use App\DTOs\CreateClienteDTO;
use App\DTOs\UpdateClienteDTO;
use App\Http\Resources\ClienteCollection;
use App\Http\Resources\ClienteResource;
use App\Services\ClienteService;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function __construct(
        private readonly ClienteService $service
    ) {}

    /**
     * Display a listing of the resource.
     * GET /clientes?page=1&per_page=10&nome=João&email=teste@email.com&sort_by=nome&sort_order=asc
     */
    public function index(Request $request)
    {
        $filters = $request->only(['nome', 'email']);
        $sortBy = $request->get('sort_by', 'id');
        $sortOrder = $request->get('sort_order', 'asc');
        $perPage = (int) $request->get('per_page', 15);

        $clientes = $this->service->paginate($filters, $sortBy, $sortOrder, $perPage);

        if ($request->is('api/*')) {
            return new ClienteCollection($clientes);
        }

        return view('clientes.index', compact('clientes', 'filters', 'sortBy', 'sortOrder', 'perPage'));
    }

    /**
     * Show the form for creating a new resource.
     * GET /clientes/create
     */
    public function create()
    {
        return view('clientes.create');
    }

    /**
     * Store a newly created resource in storage.
     * POST /clientes
     */
    public function store(Request $request)
    {
        $dto = CreateClienteDTO::from($request->all());
        $cliente = $this->service->create($dto);

        if ($request->is('api/*')) {
            $clienteModel = \App\Models\Cliente::with('boletos')->findOrFail($cliente->id);

            return (new ClienteResource($clienteModel))->response()->setStatusCode(201);
        }

        return redirect()->route('clientes.show', $cliente->id)
            ->with('success', 'Cliente criado com sucesso!');
    }

    /**
     * Display the specified resource.
     * GET /clientes/{id}
     */
    public function show(Request $request, string $id)
    {
        if ($request->is('api/*')) {
            $cliente = \App\Models\Cliente::with('boletos')->findOrFail((int) $id);

            return new ClienteResource($cliente);
        }

        $cliente = \App\Models\Cliente::with('boletos')->findOrFail((int) $id);

        return view('clientes.show', compact('cliente'));
    }

    /**
     * Show the form for editing the specified resource.
     * GET /clientes/{id}/edit
     */
    public function edit(string $id)
    {
        $cliente = \App\Models\Cliente::findOrFail((int) $id);

        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     * PUT/PATCH /clientes/{id}
     */
    public function update(Request $request, string $id)
    {
        $dto = UpdateClienteDTO::from($request->all());
        $cliente = $this->service->update((int) $id, $dto);

        if ($request->is('api/*')) {
            $clienteModel = \App\Models\Cliente::with('boletos')->findOrFail((int) $id);

            return new ClienteResource($clienteModel);
        }

        return redirect()->route('clientes.show', $cliente->id)
            ->with('success', 'Cliente atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /clientes/{id}
     */
    public function destroy(Request $request, string $id)
    {
        $this->service->delete((int) $id);

        if ($request->is('api/*')) {
            return response()->json(['message' => 'Cliente deletado com sucesso'], 200);
        }

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente deletado com sucesso!');
    }
}
