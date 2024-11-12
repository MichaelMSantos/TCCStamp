@section('title', 'Funcionarios')
@section('styles')
    <link rel="stylesheet" href="{{ asset('/css/dashboard/func.css') }}">
@endsection

<x-app-layout>

    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
        aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Funcionarios</li>
        </ol>
    </nav>
    <div class="table-group">
        <div class="table-header">
            <div class="table-desc">
                <div class="title">
                    Funcionarios
                </div>
            </div>
            <div class="action">
                <div class="search-box">
                    <span class="icon">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" name="search" id="search" placeholder="Buscar">
                </div>
                <button id="novo" data-bs-toggle="modal" data-bs-target="#novoFuncionario">Novo
                    Funcionario</button>
            </div>
        </div>

        <div id="resultado-func">
            <x-tables.funcionarios :funcionarios="$funcionarios" />
        </div>
    </div>

    @include('pages.funcionarios.funcionario-create')

    <script>
        $(document).ready(function() {
            $('#search').on('keyup', function() {
                let query = $(this).val();

                $.ajax({
                    url: "{{ route('funcionario.search') }}",
                    method: "GET",
                    data: {
                        search: query
                    },
                    success: function(data) {
                        $('#resultado-func').html(data);
                    }
                });
            });
        });
    </script>
</x-app-layout>
