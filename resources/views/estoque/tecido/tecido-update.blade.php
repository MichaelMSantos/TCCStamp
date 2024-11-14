<form action="{{ route('tecido.update', $tecido->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="modal fade" id="update-{{ $tecido->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Editar Tecido {{ $tecido->codigo }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="codigo">Codigo</label>
                    <div class="input-content">
                        <input type="text" name="codigo" id="codigo" value="{{ $tecido->codigo }}">
                    </div>
                    <div class="input-content" style="flex-direction: column; gap: 0">
                        <label for="medida">Medida</label>
                        <div class="input-group" style="flex-direction: row;">
                            <input type="number" name="medida_valor" id="medida_valor" min="0" step="any"
                                required style="width: 80%" value="{{ $tecido->medida }}">
                            <div class="option-group">
                                <select id="medida_unidade" name="medida_unidade" required>
                                    <option value="{{ $tecido->unidade }}">{{ $tecido->unidade }}</option>
                                    <option value="cm">cm</option>
                                    <option value="m">m</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="input-content">
                        <div class="input-group">
                            <label for="quantidade">Quantidade</label>
                            <input type="text" name="quantidade" id="quantidade" value={{ $tecido->quantidade }}>
                        </div>
                        <div class="option-group">
                            <div class="input-group">
                                <label for="cor">Cor</label>
                                <select name="cor" id="cor">
                                    <option value="{{ $tecido->cor }}">{{ $tecido->cor }}</option>
                                    <option value="Branco">Branco</option>
                                    <option value="Preto">Preto</option>
                                    <option value="Amarelo">Amarelo</option>
                                    <option value="Vermelho">Vermelho</option>
                                    <option value="Vermelho">Azul</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="input-group">
                        <label for="fornecedor">Fornecedor</label>
                        <select name="fornecedor" id="fornecedor">
                            @if ($fornecedores->count() > 0)
                                <option value="">Nenhum</option>
                                @foreach ($fornecedores as $fornecedor)
                                    <option value="{{ $fornecedor->id }}"> {{ $fornecedor->nome }} </option>
                                @endforeach
                            @else
                                <option value="">Nenhum fornecedor encontrado.</option>
                            @endif
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Confirmar</button>
                </div>
            </div>
        </div>
    </div>
</form>
