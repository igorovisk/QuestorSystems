<?php

namespace App\Http\Controllers;

use App\DTOs\CreateServicoCobrancaDTO;
use App\Http\Resources\ServicoCobrancaCollection;
use App\Http\Resources\ServicoCobrancaResource;
use App\Models\Banco;
use App\Models\Cliente;
use App\Models\ServicoCobranca;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServicoCobrancaController extends Controller
{
    public function create(): View
    {
        $clientes = Cliente::all();
        $bancos = Banco::all();

        return view('servicos-cobranca.create', compact('clientes', 'bancos'));
    }

    public function store(Request $request)
    {
        // Pega dados do request (JSON ou form)
        $data = $request->isJson() ? $request->json()->all() : $request->all();

        try {
            $dto = CreateServicoCobrancaDTO::from($data);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->wantsJson() || $request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'message' => 'Erro de validação',
                    'errors' => $e->errors(),
                ], 422);
            }

            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            if ($request->wantsJson() || $request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'message' => 'Erro ao processar requisição',
                    'error' => $e->getMessage(),
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Erro ao criar serviço: '.$e->getMessage())
                ->withInput();
        }

        $servicoCobranca = ServicoCobranca::create($dto->toArray());

        // O job será disparado pelo comando agendado à meia-noite
        // Não dispara imediatamente para atender ao requisito de envio à meia-noite

        if ($request->wantsJson() || $request->expectsJson() || $request->is('api/*')) {
            return (new ServicoCobrancaResource($servicoCobranca->load(['cliente', 'banco', 'parcelas'])))
                ->additional([
                    'message' => 'Serviço de cobrança criado com sucesso! O email será enviado à meia-noite.',
                ])
                ->response()
                ->setStatusCode(201);
        }

        return redirect()->route('servicos-cobranca.index')
            ->with('success', 'Serviço de cobrança criado com sucesso! O email será enviado à meia-noite.');
    }

    public function index(Request $request)
    {
        $filters = $request->only(['nome_servico', 'cliente_id', 'banco_id', 'parcelas_geradas']);
        $sortBy = $request->get('sort_by', 'id');
        $sortOrder = $request->get('sort_order', 'desc');
        $perPage = (int) $request->get('per_page', 15);

        $query = ServicoCobranca::with(['cliente', 'banco', 'parcelas']);

        // Aplicar filtros
        if (! empty($filters['nome_servico'])) {
            $query->where('nome_servico', 'ilike', '%'.$filters['nome_servico'].'%');
        }
        if (! empty($filters['cliente_id'])) {
            $query->where('cliente_id', $filters['cliente_id']);
        }
        if (! empty($filters['banco_id'])) {
            $query->where('banco_id', $filters['banco_id']);
        }
        if (isset($filters['parcelas_geradas']) && $filters['parcelas_geradas'] !== '') {
            $query->where('parcelas_geradas', filter_var($filters['parcelas_geradas'], FILTER_VALIDATE_BOOLEAN));
        }

        // Ordenação
        $query->orderBy($sortBy, $sortOrder);

        $servicos = $query->paginate($perPage)->withQueryString();

        if ($request->is('api/*')) {
            return new ServicoCobrancaCollection($servicos);
        }

        $clientes = Cliente::all();
        $bancos = Banco::all();

        return view('servicos-cobranca.index', compact('servicos', 'filters', 'sortBy', 'sortOrder', 'perPage', 'clientes', 'bancos'));
    }

    public function show(Request $request, string $id)
    {
        $servico = ServicoCobranca::with(['cliente', 'banco', 'parcelas'])
            ->findOrFail($id);

        if ($request->is('api/*')) {
            return new ServicoCobrancaResource($servico);
        }

        return view('servicos-cobranca.show', compact('servico'));
    }
}
