<x-relatorio>

    @section('title', 'Relatorio de tecidos em estoque')
    <p>Total de tecidos: {{ $tecidos->count() }}</p>
    <p>Pouco estoque: {{ DB::table('tecidos')->where('quantidade', '<=', 5)->count() }}</p>
    <p>Sem estoque: {{ DB::table('tecidos')->where('quantidade', '<', 1)->count() }}</p>


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
            @if (count($tecidos) > 0)
                @foreach ($tecidos as $tecido)
                    <tr>
                        <th scope="row">{{ $tecido->codigo }}</th>
                        <th>{{ $tecido->medida }}</th>
                        <th>{{ $tecido->cor }}</th>
                        <th>{{ $tecido->quantidade }}</th>
                        <th>{{ $tecido->created_at->format('d/m/Y') }}</th>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4">Nenhum registro encontrado.</td>
                </tr>
            @endif
        </tbody>
    </table>

</x-relatorio>
