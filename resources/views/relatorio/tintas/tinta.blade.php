<x-relatorio>

    @section('title', 'Relatorio de estoque da tinta ' . $tinta->codigo)

    <table>
        <thead>
            <tr>
                <th scope="col">Código</th>
                <th scope="col">Marca</th>
                <th scope="col">Cores</th>
                <th scope="col">Quantidade</th>
                <th scope="col">Capacidade</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">{{ $tinta->codigo }}</th>
                <th>{{ $tinta->marca }}</th>
                <th>{{ $tinta->cor }}</th>
                <th>{{ $tinta->quantidade }}</th>
                <th>{{ $tinta->capacidade }}</th>
            </tr>
        </tbody>
    </table>

</x-relatorio>
