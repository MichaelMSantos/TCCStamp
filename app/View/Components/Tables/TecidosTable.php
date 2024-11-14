<?php

namespace App\View\Components\Tables;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TecidosTable extends Component
{
    public $tecidos;
    public $fornecedores;
    public function __construct($tecidos, $fornecedores)
    {
        $this->tecidos = $tecidos;
        $this->fornecedores = $fornecedores;
    }

    public function render(): View|Closure|string
    {
        return view('components.tables.tecidos-table');
    }
}
