@section('title', 'Tintas')
@section('styles')
    <link rel="stylesheet" href="{{ asset('/css/estoque/tintas.css') }}">
@endsection

<x-app-layout>

    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
        aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">Estoque</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tintas</li>
        </ol>
    </nav>
    
    <x-estoque-card-component tipoTabela="tintas" />

    <div class="table-group">
        <div class="table-header">
            <div class="title">
                Tintas
            </div>
            <div class="button-group">
                <button id="novo" type="button" data-bs-toggle="modal" data-bs-target="#modalNovaTinta">Novo
                    produto</button>
                <button id="exportar">
                    <a href="{{ route('pdf.tintas') }}" target="_blank" style="color: red">
                        Exportar
                    </a>
                </button>
            </div>
        </div>

        <input type="text" id="pesquisar" placeholder="Pesquisar tintas..." class="form-control mb-3">

        <div id="resultado-tintas">
            <x-tables.tintas-table :tintas="$tintas" />
            {{ $tintas->links('pagination::bootstrap-5') }}
        </div>
    </div>

    {{-- Modal --}}
    @include('estoque.tinta.tinta-create')

    <script>
        $(document).ready(function() {
            $('#pesquisar').on('keyup', function() {
                let query = $(this).val();

                $.ajax({
                    url: "{{ route('tinta.search') }}",
                    method: "GET",
                    data: {
                        search: query
                    },
                    success: function(data) {
                        $('#resultado-tintas').html(data);
                    }
                });
            });
        });
    </script>
</x-app-layout>
