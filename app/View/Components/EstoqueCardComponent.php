<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\DB;

class EstoqueCardComponent extends Component
{
    public $tipoTabela;

    public function __construct($tipoTabela)
    {
        $this->tipoTabela = $tipoTabela;
    }

    public function render()
    {
        return view('components.estoque-card-component', [
            'totalEstoque' => DB::table($this->tipoTabela)->count(),
            'poucoEstoque' => DB::table($this->tipoTabela)->where('quantidade', '<=', 5)->count(),
            'semEstoque' => DB::table($this->tipoTabela)->where('quantidade', '<', 1)->count(),
        ]);
    }
}
