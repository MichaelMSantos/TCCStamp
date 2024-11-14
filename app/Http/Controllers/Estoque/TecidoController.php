<?php

namespace App\Http\Controllers\Estoque;

use App\Http\Controllers\Controller;
use App\Models\Fornecedor;
use App\Models\Tecido;
use Illuminate\Http\Request;
use App\Rules\UniqueCodigo;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class TecidoController extends Controller
{
    public function index()
    {
        $fornecedores = Fornecedor::all() ?: collect();
        $tecidos = Tecido::paginate(5);

        return view('estoque.tecido.index', compact('tecidos', 'fornecedores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => ['nullable', new UniqueCodigo],
            'medida_valor' => 'required|numeric',
            'medida_unidade' => 'required|in:cm,m',
            'cor' => 'required',
            'quantidade' => 'required|integer'
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

        $tecidos = new Tecido();

        $tecidos->id = $request->id;
        $tecidos->codigo = $codigo;
        $tecidos->medida = $request->medida_valor;
        $tecidos->unidade = $request->medida_unidade;
        $tecidos->cor = $request->cor;
        $tecidos->quantidade = $request->quantidade;
        $tecidos->fornecedor_id = $request->fornecedor;

        $barcodeUrl = "https://barcode.tec-it.com/barcode.ashx?data={$tecidos->codigo}&code=Code128&translate-esc=on&filetype=png";

        $response = Http::get($barcodeUrl);

        if ($response->successful()) {
            $path = 'barcodes/' . $tecidos->codigo . '.png';

            Storage::disk('public')->put($path, $response->body());


            $tecidos->barcode_image = $path;
            $tecidos->save();
        }

        return back()->with('sucesso', 'Tecido registrado com sucesso');
    }

    public function productCodeExists($number)
    {
        return Tecido::where('codigo', $number)->exists();
    }

    public function edit($id)
    {
        $tecido = Tecido::where('codigo', $id)->firstOrFail();

        return view('modal.estoque.tecido-edit', compact('tecido'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'codigo' => ['required', 'unique:tecidos,codigo,' . $request->id],
            'medida_valor' => 'required|numeric',
            'medida_unidade' => 'required|in:cm,m',
            'cor' => 'required',
            'quantidade' => 'required|integer'
        ]);

        $tecido = Tecido::findOrFail($request->id);


        if ($tecido->codigo !== $request->codigo) {
            $codigoAntigo = $tecido->codigo;
            $tecido->codigo = $request->codigo;

            $oldBarcodePath = public_path('barcodes/' . $codigoAntigo . '.png');
            if (file_exists($oldBarcodePath)) {
                unlink($oldBarcodePath);
            }

            $barcodeUrl = "https://barcode.tec-it.com/barcode.ashx?data={$tecido->codigo}&code=Code128&translate-esc=on&filetype=png";
            $response = Http::get($barcodeUrl);

            if ($response->successful()) {
                $directory = public_path('barcodes');
                $path = $directory . '/' . $tecido->codigo . '.png';

                if (!is_dir($directory)) {
                    mkdir($directory, 0755, true);
                }

                file_put_contents($path, $response->body());
                $tecido->barcode_image = 'barcodes/' . $tecido->codigo . '.png';
            }

            $tecido->codigo = $request->codigo;
            $tecido->medida = $request->medida_valor;
            $tecido->unidade = $request->medida_unidade;
            $tecido->cor = $request->cor;
            $tecido->quantidade = $request->quantidade;
            $tecido->fornecedor_id = $request->fornecedor;
            $tecido->save();

            return back()->with('sucesso', 'Tecido atualizado com sucesso!');
        }
    }


    public function destroy($id)
    {
        $tecido = Tecido::findOrFail($id);

        $tecido->delete();

        return back()->with('sucesso', 'Produto excluido com sucesso');
    }
}
