<?php

namespace App\Http\Controllers\Estoque;

use App\Http\Controllers\Controller;
use App\Models\Camiseta;
use App\Models\Fornecedor;
use App\Rules\UniqueCodigo;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class CamisetaController extends Controller
{
    public function index()
    {
        $camisetas = Camiseta::paginate(5);

        $fornecedores = Fornecedor::all();
        return view('estoque.camiseta.index', compact('camisetas', 'fornecedores'));
    }



    // Insert
    public function store(Request $request)
    {
        $request->validate([
            'codigo' => ['nullable', new UniqueCodigo],
            'modelo' => 'required',
            'tamanho' => 'required',
            'cor' => 'required',
            'quantidade' => 'required|integer',
            'categoria' => 'required'
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

        $camiseta = new Camiseta;

        $camiseta->id = $request->id;
        $camiseta->codigo = $codigo;
        $camiseta->modelo = $request->modelo;
        $camiseta->tamanho = $request->tamanho;
        $camiseta->cor = $request->cor;
        $camiseta->quantidade = $request->quantidade;
        $camiseta->categoria = $request->categoria;
        $camiseta->fornecedor_id = $request->fornecedor;

        $camiseta->save();

        $barcodeUrl = "https://barcode.tec-it.com/barcode.ashx?data={$camiseta->codigo}&code=Code128&translate-esc=on&filetype=png";
        $response = Http::get($barcodeUrl);

        if ($response->successful()) {
            // Caminho completo para o arquivo
            $directory = public_path('barcodes');
            $path = $directory . '/' . $camiseta->codigo . '.png';

            // Verifica se o diretório 'public/barcodes' existe, caso contrário, cria-o
            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
            }

            // Salva o conteúdo da imagem no diretório
            file_put_contents($path, $response->body());

            // Atualiza o caminho da imagem no modelo
            $camiseta->barcode_image = 'barcodes/' . $camiseta->codigo . '.png';
            $camiseta->save();
        }

        return back()->with('sucesso', 'Camiseta registrada com sucesso.');
    }

    public function productCodeExists($number)
    {
        return Camiseta::where('codigo', $number)->exists();
    }



    // Update
    public function update(Request $request)
    {
        $request->validate([
            'codigo' => ['required', 'unique:camisetas,codigo,' . $request->id],
            'modelo' => 'required',
            'tamanho' => 'required',
            'cor' => 'required',
            'quantidade' => 'required|integer',
            'categoria' => 'required'
        ]);

        $camisetas = Camiseta::all();

        Camiseta::findOrFail($request->id)->update($request->all());


        return back()->with('sucesso', 'Camiseta atualizada com sucesso!');
    }

    // Delete
    public function destroy($id)
    {
        $camiseta = Camiseta::findOrFail($id);

        $path = 'barcodes/' . $camiseta->codigo . '.png';

        if (Storage::disk('public')->exists($path)) {

            Storage::disk('public')->delete($path);
        }

        $camiseta->delete();

        return redirect()->route('camiseta.index')->with('sucesso', 'Camiseta excluida com sucesso!');
    }

    public function pdfGeral()
    {
        $camisetas = Camiseta::all();

        $pdf = PDF::loadView('relatorios.camiseta-geral_pdf', [
            'camisetas' => $camisetas,
        ]);

        return $pdf->stream('camiseta-relatorio.pdf');
    }

    public function unicoPdf($codigo)
    {
        $camiseta = Camiseta::where('codigo', $codigo)->firstOrFail();

        $pdf = PDF::loadView(
            'relatorios.camiseta',
            ['camiseta' => $camiseta]
        );

        return $pdf->stream('camiseta-relatorio.pdf');
    }
}
