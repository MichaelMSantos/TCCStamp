<x-relatorio>

    @section('title', 'Relatorio de estoque do tecido ' . $tecido->codigo)

    <table>
        <thead>
            <tr>
                <th scope="col">Código</th>
                <th scope="col">Medidas</th>
                <th scope="col">Cores</th>
                <th scope="col">Quantidade</th>
                <th scope="col">Data de entrada</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">{{ $tecido->codigo }}</th>
                <th>{{ $tecido->medida }}</th>
                <th>{{ $tecido->cor }}</th>
                <th>{{ $tecido->quantidade }}</th>
                <th>{{ $tecido->created_at->format('d/m/Y   ') }}</th>
            </tr>
        </tbody>
    </table>

</x-relatorio>
