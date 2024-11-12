@section('title', 'Pouco Estoque')
@section('styles')
    <link rel="stylesheet" href="{{ asset('/css/dashboard/pouco-estoque.css') }}">
@endsection
<x-app-layout>

    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
        aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Pouco Estoque</li>
        </ol>
    </nav>

    <div class="table-group">
        <div class="table-header">
            <div class="title">
                Pouco Estoque
            </div>
            <div class="action">
                <button id="novo">
                    <a href="{{route('pdf.estoque')}}" target="_blank" rel="noopener noreferrer" style="color: red">
                        Exportar
                    </a>
                </button>
            </div>
        </div>
        <x-tables.pouco-estoque :poucoestoque="$poucoestoque" />
    </div>
</x-app-layout>
