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
            $directory = public_path('barcodes');
            $path = $directory . '/' . $camiseta->codigo . '.png';

            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
            }

            file_put_contents($path, $response->body());
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

        $camiseta = Camiseta::findOrFail($request->id);

        if ($camiseta->codigo !== $request->codigo) {
            $codigoAntigo = $camiseta->codigo;

            $camiseta->codigo = $request->codigo;
            $oldBarcodePath = public_path('barcodes/' . $codigoAntigo . '.png');
            if (file_exists($oldBarcodePath)) {
                unlink($oldBarcodePath);
            }

            $barcodeUrl = "https://barcode.tec-it.com/barcode.ashx?data={$camiseta->codigo}&code=Code128&translate-esc=on&filetype=png";
            $response = Http::get($barcodeUrl);

            if ($response->successful()) {
                $directory = public_path('barcodes');
                $path = $directory . '/' . $camiseta->codigo . '.png';
                if (!is_dir($directory)) {
                    mkdir($directory, 0755, true);
                }

                file_put_contents($path, $response->body());
                $camiseta->barcode_image = 'barcodes/' . $camiseta->codigo . '.png';
            }
        }

        $camiseta->modelo = $request->modelo;
        $camiseta->tamanho = $request->tamanho;
        $camiseta->cor = $request->cor;
        $camiseta->quantidade = $request->quantidade;
        $camiseta->categoria = $request->categoria;
        $camiseta->fornecedor_id = $request->fornecedor;

        $camiseta->save();

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
}
