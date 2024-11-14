<?php

namespace App\View\Components\Tables;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TintasTable extends Component
{
    public $tintas;
    public $fornecedores;
    public function __construct($tintas, $fornecedores)
    {
        $this->tintas = $tintas;
        $this->fornecedores = $fornecedores;
    }

    public function render(): View|Closure|string
    {
        return view('components.tables.tintas-table');
    }
}
