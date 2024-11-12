<x-relatorio>

    @section('title', 'Relatorio de tintas em estoque')
    <p>Total de tecidos: {{ $tintas->count() }}</p>
    <p>Pouco estoque: {{ DB::table('tintas')->where('quantidade', '<=', 5)->count() }}</p>
    <p>Sem estoque: {{ DB::table('tintas')->where('quantidade', '<', 1)->count() }}</p>

    <table>
        <thead>
            <tr>
                <th scope="col">Código</th>
                <th scope="col">Marca</th>
                <th scope="col">Cores</th>
                <th scope="col">Quantidade</th>
                <th scope="col">Capacidade</th>
                <th scope="col">Data de entrada</th>
            </tr>
        </thead>
        <tbody>
            @if (count($tintas) > 0)
                @foreach ($tintas as $tinta)
                    <tr>
                        <th scope="row">{{ $tinta->codigo }}</th>
                        <th>{{ $tinta->marca }}</th>
                        <th>{{ $tinta->cor }}</th>
                        <th>{{ $tinta->quantidade }}</th>
                        <th>{{ $tinta->capacidade }}</th>
                        <th>{{ $tinta->created_at->format('d/m/Y') }}</th>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6">Nenhum registro encontrado.</td>
                </tr>
            @endif
        </tbody>
    </table>

</x-relatorio>
