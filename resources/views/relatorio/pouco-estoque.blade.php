<x-relatorio>

@section('title', 'Relatorio de produtos com pouco estoque')
    <table>
        <thead>
            <tr>
                <th scope="col">Seção</th>
                <th scope="col">Cor</th>
                <th scope="col">Quantidade</th>
                <th scope="col">Código</th>
                <th scope="col">Fornecedor</th>
                <th scope="col">Detalhes</th>
            </tr>
        </thead>
        <tbody>
            @if (count($poucoestoque) > 0)
                @foreach ($poucoestoque as $item)
                    <tr>
                        <th scope="row" style="text-transform:capitalize;">
                            {{ $item->origem }}
                        </th>
                        <td>{{ $item->especifico2 }}</td>
                        <td>{{ $item->quantidade }}</td>
                        <td>{{ $item->codigo }}</td>
                        <td>{{ $item->fornecedor }}</td>
                        <td>
                            @if ($item->origem === 'tintas')
                                <strong>Marca:</strong> {{ $item->especifico1 }} | <strong>Capacidade:</strong>
                                {{ $item->especifico3 }}
                            @elseif ($item->origem === 'camisetas')
                                <strong>Modelo:</strong> {{ $item->especifico1 }} |
                                <strong>Tamanho:</strong> {{ $item->especifico3 }}
                            @elseif ($item->origem === 'tecidos')
                                <strong>Medida:</strong> {{ $item->especifico1 }}
                            @endif
                        </td>
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
