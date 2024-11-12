<?php

namespace App\Http\Controllers;

use App\Models\Camiseta;
use App\Models\Fornecedor;
use App\Models\Historico;
use App\Models\Tecido;
use App\Models\Tinta;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function camiseta_search(Request $request)
    {
        $search = $request->input('search');
        $camisetas = Camiseta::where('codigo', 'like', "%$search")
            ->orWhere('modelo', 'like', "%$search%")
            ->orWhere('cor', 'like', "%$search%")
            ->paginate(10);

        return view('components.tables.camisetas-table', compact('camisetas'));
    }

    public function tinta_search(Request $request)
    {
        $search = $request->input('search');
        $tintas = Tinta::where('codigo', 'like', "%$search")
            ->orWhere('cor', 'like', "%$search%")
            ->paginate(10);

        return view('components.tables.tintas-table', compact('tintas'));
    }

    public function tecido_search(Request $request)
    {
        $search = $request->input('search');
        $tecidos = Tecido::where('codigo', 'like', "%$search")
            ->orWhere('cor', 'like', "%$search%")
            ->paginate(10);

        return view('components.tables.tecidos-table', compact('tecidos'));
    }


    public function fornecedor_search(Request $request)
    {
        $search = $request->input('search');
        $fornecedores = Fornecedor::where('nome', 'like', "%$search")
            ->paginate(10);

        return view('components.tables.fornecedores', compact('fornecedores'));
    }

    public function funcionario_search(Request $request)
    {
        $search = $request->input('search');
        $funcionarios = User::where('name', 'like', "%$search")
            ->orWhere('cpf', 'like', "%$search")
            ->orWhere('email', 'like', "%$search")
            ->paginate(10);

        return view('components.tables.funcionarios', compact('funcionarios'));
    }

    public function envios_search(Request $request)
    {
        $search = $request->input('search');
        $historicosSaida = Historico::where('descricao', 'Saída')
            ->with(['historicoable'])
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('components.tables.funcionarios', compact('historicosSaida'));
    }
    public function entrada_search(Request $request)
    {
        $search = $request->input('search');

        $entradas = Historico::with('historicoable', 'historicoable.fornecedor')
            ->where('descricao', 'Entrada')
            ->where(function ($query) use ($search) {
                $query->whereHas('historicoable', function ($query) use ($search) {
                    $query->where('codigo', 'like', "%$search%");
                });
            })
            ->orderByDesc('created_at')
            ->paginate(5);

        return view('components.tables.entradas', compact('entradas'));
    }

    public function saida_search(Request $request)
    {
        $search = $request->input('search');
        $saidas = Historico::with('historicoable')
            ->where('descricao', 'Saída')
            ->where(function ($query) use ($search) {
                $query->whereHas('historicoable', function ($query) use ($search) {
                    $query->where('codigo', 'like', "%$search%");
                });
            })
            ->orderByDesc('created_at')
            ->paginate(5);

        return view('components.tables.saidas', compact('saidas'));
    }
}
