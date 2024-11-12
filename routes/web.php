<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\MonitoramentoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\Estoque\CamisetaController;
use App\Http\Controllers\Estoque\TecidoController;
use App\Http\Controllers\Estoque\TintaController;
use App\Http\Controllers\PdfController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', function () {
    return view('auth.login');
})->name('home');

Route::get('/logout', [AuthenticatedSessionController::class, 'logout'])->name('user.logout');
// Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');



Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

Route::middleware(['auth'])
    ->prefix('dashboard/camisetas')->group(function () {
        Route::get('/', [CamisetaController::class, 'index'])->name('camiseta.index');
        Route::post('/', [CamisetaController::class, 'store']);
        Route::get('/edit/{id}', [CamisetaController::class, 'edit'])->name('camiseta.edit');
        Route::delete('/delete/{id}', [CamisetaController::class, 'destroy'])->name('camiseta.delete');
        Route::put('/update/{id}', [CamisetaController::class, 'update'])->name('camiseta.update');
        Route::get('/pesquisar', [SearchController::class, 'camiseta_search'])->name('camiseta.search');
    });

Route::middleware(['auth'])
    ->prefix('dashboard/tintas')->group(function () {
        Route::get('/', [TintaController::class, 'index'])->name('tinta.index');
        Route::post('/', [TintaController::class, 'store']);
        Route::get('/edit/{id}', [TintaController::class, 'edit'])->name('tinta.edit');
        Route::delete('/delete/{id}', [TintaController::class, 'destroy'])->name('tinta.delete');
        Route::put('/update/{id}', [TintaController::class, 'update'])->name('tinta.update');
        Route::get('/pesquisar', [SearchController::class, 'tinta_search'])->name('tinta.search');
    });

Route::middleware(['auth'])
    ->prefix('dashboard/tecidos')->group(function () {
        Route::get('/', [TecidoController::class, 'index'])->name('tecido.index');
        Route::post('/', [TecidoController::class, 'store']);
        Route::get('/edit/{id}', [TecidoController::class, 'edit'])->name('tecido.edit');
        Route::delete('/delete/{id}', [TecidoController::class, 'destroy'])->name('tecido.delete');
        Route::put('/update/{id}', [TecidoController::class, 'update'])->name('tecido.update');
        Route::get('/pesquisar', [SearchController::class, 'tecido_search'])->name('tecido.search');
    });



Route::middleware(['auth'])
    ->prefix('dashboard')->group(function () {
        Route::get('/monitoramento', [MonitoramentoController::class, 'index'])->name('monitoramento.index');
        Route::get('/entradas/pesquisar', [SearchController::class, 'entrada_search'])->name('entrada.search');
        Route::get('/pesquisar/saida', [SearchController::class, 'saida_search'])->name('saida.search');
        Route::get('/show/{id}', [MonitoramentoController::class, 'show'])->name('historico.show');

        Route::get('pouco-estoque', [DashboardController::class, 'pouco_estoque'])->name('pouco_estoque');
        Route::post('solicitacao', [DashboardController::class, 'solicitacao'])->name('fazer.solicitacao');

        Route::get('/funcionarios', [UserController::class, 'index'])->name('funcionarios.index');
        Route::put('/funcionarios/pesquisar', [UserController::class, 'update'])->name('funcionario.search');
        Route::put('/funcionarios/update/{id}', [UserController::class, 'update'])->name('funcionario.update');
        Route::delete('/funcionarios/delete/{id}', [UserController::class, 'destroy'])->name('funcionario.delete');

        Route::get('/fornecedores', [FornecedorController::class, 'index'])->name('fornecedor.index');
        Route::post('/fornecedores', [FornecedorController::class, 'store']);
        Route::get('/fornecedores/pesquisar', [SearchController::class, 'fornecedor_search'])->name('fornecedor.search');
        Route::delete('/fornecedores/delete/{id}', [FornecedorController::class, 'destroy'])->name('fornecedor.delete');
        Route::put('/fornecedores/update/{id}', [FornecedorController::class, 'update'])->name('fornecedor.update');
        Route::get('/contatos/{id}', [FornecedorController::class, 'show'])->name('fornecedor.show');

        Route::post('/enviar', [DashboardController::class, 'enviar'])->name('enviar.produto');
        Route::get('/envios', [DashboardController::class, 'envios'])->name('envio.index');
        Route::get('/envios/pesquisar', [SearchController::class, 'envios_search'])->name('envio.search');
        Route::delete('/historico/{historico}/devolver', [DashboardController::class, 'devolucao'])->name('devolver');

        Route::get('/consultar', [ConsultaController::class, 'index'])->name('consulta.index');
        Route::get('/consultar/produto', [ConsultaController::class, 'consultarProduto'])->name('consultar.produto');
        Route::get('/buscar-codigos', [ConsultaController::class, 'buscarCodigos'])->name('buscar.codigos');
    });

Route::get('/produtos/{categoria}', [DashboardController::class, 'buscarProduto'])->name('produto.buscar');


Route::middleware(['auth'])
    ->prefix('dashboard/pdf')->group(function () {
        Route::get('/recentes', [PdfController::class, 'pdfRecentes'])->name('pdf.recentes');

        Route::get('/camisetas', [PdfController::class, 'camisetaGeral'])->name('pdf.camisetas');
        Route::get('/camisetas/{codigo}', [PdfController::class, 'unicaCamiseta'])->name('pdf.camiseta-unica');

        Route::get('/tecidos', [PdfController::class, 'tecidoGeral'])->name('pdf.tecidos');
        Route::get('/tecidos/{codigo}', [PdfController::class, 'unicoTecido'])->name('pdf.tecido-unico');

        Route::get('/tintas', action: [PdfController::class, 'tintaGeral'])->name('pdf.tintas');
        Route::get('/tintas/{codigo}', [PdfController::class, 'unicaTinta'])->name('pdf.tinta-unica');

        Route::get('/pouco-estoque', action: [PdfController::class, 'estoque'])->name('pdf.estoque');
    });
