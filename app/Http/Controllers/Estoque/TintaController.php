<?php

namespace App\Http\Controllers\Estoque;

use App\Http\Controllers\Controller;
use App\Models\Fornecedor;
use Illuminate\Http\Request;

use App\Rules\UniqueCodigo;
use App\Models\Tinta;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class TintaController extends Controller
{
    public function index()
    {
        $fornecedores = Fornecedor::all();
        $tintas = Tinta::paginate(5);
        return view('estoque.tinta.index', compact('tintas', 'fornecedores'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'codigo' => ['nullable', new UniqueCodigo],
            'marca' => 'required',
            'cor' => 'required',
            'quantidade' => 'required|integer',
            'capacidade' => 'required',
            'unidade' => 'required'
        ]);

        if (empty($request->codigo)) {
            $number = mt_rand(1000000000, 9999999999);

            while ($this->productCodeExists($number)) {
                $number = mt_rand(1000000000, 9999999999);
            }

            $codigo = $number;
        } else {
            $codigo = $request->codigo;

            if ($this->productCodeExists($codigo)) {
                return back()->withErrors(['codigo' => 'O código já existe. Escolha outro.']);
            }
        }


        $tintas = new Tinta;

        $tintas->codigo = $codigo;
        $tintas->marca = $request->marca;
        $tintas->cor = $request->cor;
        $tintas->quantidade = $request->quantidade;
        $tintas->capacidade = $request->capacidade;
        $tintas->unidade_tinta = $request->unidade;
        $tintas->fornecedor_id = $request->fornecedor;

        $tintas->save();

        $barcodeUrl = "https://barcode.tec-it.com/barcode.ashx?data={$tintas->codigo}&code=Code128&translate-esc=on&filetype=png";
        $response = Http::get($barcodeUrl);

        if ($response->successful()) {
            $directory = public_path('barcodes');
            $path = $directory . '/' . $tintas->codigo . '.png';

            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
            }

            file_put_contents($path, $response->body());
            $tintas->barcode_image = 'barcodes/' . $tintas->codigo . '.png';
            $tintas->save();
        }

        return back()->with('sucesso', 'Tinta registrada com sucesso');
    }

    public function productCodeExists($number)
    {
        return Tinta::where('codigo', $number)->exists();
    }

    public function edit($id)
    {
        $tinta = Tinta::where('codigo', $id)->firstOrFail();

        return view('estoque.tinta.tinta-update', compact('tinta'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'codigo' => ['required', 'unique:tintas,codigo,' . $request->id],
            'marca' => 'required',
            'cor' => 'required',
            'quantidade' => 'required|integer',
            'capacidade' => 'required',
            'unidade' => 'required'
        ]);

        $tinta = Tinta::findOrFail($request->id);

        if ($tinta->codigo !== $request->codigo) {
            $codigoAntigo = $tinta->codigo;
            $tinta->codigo = $request->codigo;
            $oldBarcodePath = public_path('barcodes/' . $codigoAntigo . '.png');
            if (file_exists($oldBarcodePath)) {
                unlink($oldBarcodePath);
            }

            $barcodeUrl = "https://barcode.tec-it.com/barcode.ashx?data={$tinta->codigo}&code=Code128&translate-esc=on&filetype=png";
            $response = Http::get($barcodeUrl);

            if ($response->successful()) {
                $directory = public_path('barcodes');
                $path = $directory . '/' . $tinta->codigo . '.png';
                if (!is_dir($directory)) {
                    mkdir($directory, 0755, true);
                }

                file_put_contents($path, $response->body());
                $tinta->barcode_image = 'barcodes/' . $tinta->codigo . '.png';
            }
        }

        // Atualizando os demais campos
        $tinta->codigo = $request->codigo;
        $tinta->marca = $request->marca;
        $tinta->cor = $request->cor;
        $tinta->quantidade = $request->quantidade;
        $tinta->capacidade = $request->capacidade;
        $tinta->unidade_tinta = $request->unidade;
        $tinta->fornecedor_id = $request->fornecedor;

        $tinta->save();

        return back()->with('sucesso', 'Tinta atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $tinta = Tinta::findOrFail($id);

        $tinta->delete();

        return back()->with('sucesso', 'Produto excluido com sucesso');
    }

    public function pdfGeral()
    {
        $camisetas = Tinta::all();

        $pdf = PDF::loadView('relatorios.camiseta-geral_pdf', [
            'camisetas' => $camisetas,
        ]);

        return $pdf->stream('camiseta-relatorio.pdf');
    }

    public function unicoPdf($codigo)
    {
        $tecido = Tinta::where('codigo', $codigo)->firstOrFail();

        $pdf = PDF::loadView(
            'relatorios.camiseta',
            ['tecido' => $tecido]
        );

        return $pdf->stream('camiseta-relatorio.pdf');
    }
}
