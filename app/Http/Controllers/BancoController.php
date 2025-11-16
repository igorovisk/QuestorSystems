<?php

namespace App\Http\Controllers;

use App\DTOs\CreateBancoDTO;
use App\DTOs\UpdateBancoDTO;
use App\Http\Resources\BancoCollection;
use App\Http\Resources\BancoResource;
use App\Services\BancoService;
use Illuminate\Http\Request;

class BancoController extends Controller
{
    public function __construct(
        private readonly BancoService $service
    ) {}

    /**
     * Display a listing of the resource.
     * GET /bancos?page=1&per_page=10&nome_banco=Banco&codigo_banco=001&sort_by=nome_banco&sort_order=asc
     */
    public function index(Request $request)
    {
        $filters = $request->only(['nome_banco', 'codigo_banco', 'percentual_juros_min', 'percentual_juros_max']);
        $sortBy = $request->get('sort_by', 'id');
        $sortOrder = $request->get('sort_order', 'asc');
        $perPage = (int) $request->get('per_page', 15);

        $bancos = $this->service->paginate($filters, $sortBy, $sortOrder, $perPage);

        if ($request->is('api/*')) {
            return new BancoCollection($bancos);
        }

        return view('bancos.index', compact('bancos', 'filters', 'sortBy', 'sortOrder', 'perPage'));
    }

    /**
     * Show the form for creating a new resource.
     * GET /bancos/create
     */
    public function create()
    {
        return view('bancos.create');
    }

    /**
     * Store a newly created resource in storage.
     * POST /bancos
     */
    public function store(Request $request)
    {
        $dto = CreateBancoDTO::from($request->all());
        $banco = $this->service->create($dto);

        if ($request->is('api/*')) {
            $bancoModel = \App\Models\Banco::with('boletos')->findOrFail($banco->id);

            return (new BancoResource($bancoModel))->response()->setStatusCode(201);
        }

        return redirect()->route('bancos.show', $banco->id)
            ->with('success', 'Banco criado com sucesso!');
    }

    /**
     * Display the specified resource.
     * GET /bancos/{id}
     */
    public function show(Request $request, string $id)
    {
        if ($request->is('api/*')) {
            $banco = \App\Models\Banco::with('boletos')->findOrFail((int) $id);

            return new BancoResource($banco);
        }

        $banco = \App\Models\Banco::with('boletos')->findOrFail((int) $id);

        return view('bancos.show', compact('banco'));
    }

    /**
     * Show the form for editing the specified resource.
     * GET /bancos/{id}/edit
     */
    public function edit(string $id)
    {
        $banco = \App\Models\Banco::findOrFail((int) $id);

        return view('bancos.edit', compact('banco'));
    }

    /**
     * Update the specified resource in storage.
     * PUT/PATCH /bancos/{id}
     */
    public function update(Request $request, string $id)
    {
        $dto = UpdateBancoDTO::from($request->all());
        $banco = $this->service->update((int) $id, $dto);

        if ($request->is('api/*')) {
            $bancoModel = \App\Models\Banco::with('boletos')->findOrFail((int) $id);

            return new BancoResource($bancoModel);
        }

        return redirect()->route('bancos.show', $banco->id)
            ->with('success', 'Banco atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /bancos/{id}
     */
    public function destroy(Request $request, string $id)
    {
        $this->service->delete((int) $id);

        if ($request->is('api/*')) {
            return response()->json(['message' => 'Banco deletado com sucesso'], 200);
        }

        return redirect()->route('bancos.index')
            ->with('success', 'Banco deletado com sucesso!');
    }
}
