<?php

namespace App\Http\Controllers;

use App\Models\Camiseta;
use App\Models\Tecido;
use App\Models\Tinta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function pdfRecentes()
    {
        $recentes = DB::select("
        (SELECT 'tintas' AS origem, tintas.codigo, tintas.quantidade, tintas.created_at, fornecedores.nome AS fornecedor
        FROM tintas
        LEFT JOIN fornecedores ON tintas.fornecedor_id = fornecedores.id
        ORDER BY tintas.created_at DESC
        LIMIT 3)
        UNION ALL
        (SELECT 'camisetas' AS origem, camisetas.codigo, camisetas.quantidade, camisetas.created_at, fornecedores.nome AS fornecedor
        FROM camisetas
        LEFT JOIN fornecedores ON camisetas.fornecedor_id = fornecedores.id
        ORDER BY camisetas.created_at DESC
        LIMIT 3)
        UNION ALL
        (SELECT 'tecidos' AS origem, tecidos.codigo, tecidos.quantidade, tecidos.created_at, fornecedores.nome AS fornecedor
        FROM tecidos
        LEFT JOIN fornecedores ON tecidos.fornecedor_id = fornecedores.id
        ORDER BY tecidos.created_at DESC
        LIMIT 3)
        ORDER BY created_at DESC
        LIMIT 3
    ");

        $totalTintas = DB::table('tintas')->count();
        $totalCamisetas = DB::table('camisetas')->count();
        $totalTecidos = DB::table('tecidos')->count();
        $totalRegistro = $totalTintas + $totalCamisetas + $totalTecidos;

        $sevenDaysAgo = Carbon::now()->subDays(7);
        $adicoesTintas = DB::table('tintas')->where('created_at', '>=', $sevenDaysAgo)->count();
        $adicoesCamisetas = DB::table('camisetas')->where('created_at', '>=', $sevenDaysAgo)->count();
        $adicoesTecidos = DB::table('tecidos')->where('created_at', '>=', $sevenDaysAgo)->count();
        $adicoesRecentes = $adicoesTintas + $adicoesCamisetas + $adicoesTecidos;

        $semEstoqueTintas = DB::table('tintas')->where('quantidade', 0)->count();
        $semEstoqueCamisetas = DB::table('camisetas')->where('quantidade', 0)->count();
        $semEstoqueTecidos = DB::table('tecidos')->where('quantidade', 0)->count();
        $semEstoqueTotal = $semEstoqueTintas + $semEstoqueCamisetas + $semEstoqueTecidos;

        $pdf = PDF::loadView('relatorio.recentes', [
            'recentes' => $recentes,
            'totalRegistro' => $totalRegistro,
            'adicoesRecentes' => $adicoesRecentes,
            'semEstoqueTotal' => $semEstoqueTotal
        ]);

        return $pdf->stream('dashboard-relatorio.pdf');
    }

    public function tecidoGeral()
    {
        $tecidos = Tecido::all();

        $pdf = PDF::loadView('relatorio.tecidos.geral', [
            'tecidos' => $tecidos,
        ]);

        return $pdf->stream('tecido-relatorio.pdf');
    }

    public function unicoTecido($codigo)
    {
        $tecido = Tecido::where('codigo', $codigo)->firstOrFail();

        $pdf = PDF::loadView(
            'relatorio.tecidos.tecido',
            ['tecido' => $tecido]
        );

        return $pdf->stream('tecido-relatorio.pdf');
    }
    public function tintaGeral()
    {
        $tintas = Tinta::all();

        $pdf = PDF::loadView('relatorio.tintas.geral', [
            'tintas' => $tintas,
        ]);

        return $pdf->stream('tintas-relatorio.pdf');
    }

    public function unicaTinta($codigo)
    {
        $tinta = Tinta::where('codigo', $codigo)->firstOrFail();

        $pdf = PDF::loadView(
            'relatorio.tintas.tinta',
            ['tinta' => $tinta]
        );

        return $pdf->stream('camiseta-relatorio.pdf');
    }
    public function camisetaGeral()
    {
        $camisetas = Camiseta::all();

        $pdf = PDF::loadView('relatorio.camisetas.geral', [
            'camisetas' => $camisetas,
        ]);

        return $pdf->stream('camiseta-relatorio.pdf');
    }

    public function unicaCamiseta($codigo)
    {
        $camiseta = Camiseta::where('codigo', $codigo)->firstOrFail();

        $pdf = PDF::loadView(
            'relatorio.camisetas.camiseta',
            ['camiseta' => $camiseta]
        );

        return $pdf->stream('camiseta-relatorio.pdf');
    }

    public function estoque()
    {
        $poucoestoque = DB::table('tintas')
            ->select('tintas.codigo', 'tintas.quantidade', 'fornecedores.nome AS fornecedor', 'tintas.marca AS especifico1', 'tintas.cor AS especifico2', 'tintas.capacidade AS especifico3', DB::raw("'tintas' AS origem"))
            ->leftJoin('fornecedores', 'tintas.fornecedor_id', '=', 'fornecedores.id')
            ->where('tintas.quantidade', '<', 6)
            ->unionAll(
                DB::table('camisetas')
                    ->select('camisetas.codigo', 'camisetas.quantidade', 'fornecedores.nome AS fornecedor', 'camisetas.modelo AS especifico1', 'camisetas.cor AS especifico2', 'camisetas.tamanho AS especifico3', DB::raw("'camisetas' AS origem"))
                    ->leftJoin('fornecedores', 'camisetas.fornecedor_id', '=', 'fornecedores.id')
                    ->where('camisetas.quantidade', '<', 6)
            )
            ->unionAll(
                DB::table('tecidos')
                    ->select('tecidos.codigo', 'tecidos.quantidade', 'fornecedores.nome AS fornecedor', 'tecidos.medida AS especifico1', 'tecidos.cor AS especifico2', DB::raw("NULL AS especifico3"), DB::raw("'tecidos' AS origem"))
                    ->leftJoin('fornecedores', 'tecidos.fornecedor_id', '=', 'fornecedores.id')
                    ->where('tecidos.quantidade', '<', 6)
            )
            ->get();

        // Gera o PDF e retorna a resposta
        return PDF::loadView('relatorio.pouco-estoque', ['poucoestoque' => $poucoestoque])
            ->setPaper('a4', 'landscape') 
            ->stream('relatorio_pouco_estoque.pdf');
    }
}
