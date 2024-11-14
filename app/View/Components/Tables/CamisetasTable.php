<?php

namespace App\View\Components\Tables;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CamisetasTable extends Component
{
    public $camisetas;
    public $fornecedores;

    public function __construct($camisetas,  $fornecedores)
    {
        $this->camisetas = $camisetas;
        $this->fornecedores = $fornecedores;
    }

    public function render(): View|Closure|string
    {
        return view('components.tables.camisetas-table');
    }
}
