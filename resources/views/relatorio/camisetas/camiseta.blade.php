<x-relatorio>

    @section('title', 'Relatorio de estoque da camiseta ' . $camiseta->codigo)
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Modelo</th>
                <th>Tamanho</th>
                <th>Cor</th>
                <th>Quantidade</th>
                <th>Categoria</th>
                <th>Fornecedor</th>
                <th>Data de entrada</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">{{ $camiseta->codigo }}</th>
                <th>{{ $camiseta->modelo }}</th>
                <th>{{ $camiseta->tamanho }}</th>
                <th>{{ $camiseta->cor }}</th>
                <th>{{ $camiseta->quantidade }}</th>
                <th>{{ $camiseta->categoria }}</th>
                <th>
                    @if ($camiseta->fornecedor)
                        {{ $camiseta->fornecedor->nome }}
                    @else
                        N/A
                    @endif
                </th>
                <th>{{ $camiseta->created_at->format('d/m/Y') }}</th>
            </tr>
        </tbody>
    </table>

</x-relatorio>
