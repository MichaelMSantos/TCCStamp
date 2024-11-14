<form action="{{ route('tinta.update', $tinta->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="modal fade" id="update-{{ $tinta->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Editar tinta {{ $tinta->codigo }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="codigo">Codigo</label>
                    <div class="input-content">
                        <input type="text" name="codigo" id="codigo" value="{{ $tinta->codigo }}">
                    </div>
                    <div class="input-content">
                        <div class="input-group">
                            <label for="marca">Marca</label>
                            <input type="text" name="marca" id="marca" value="{{ $tinta->marca }}">
                        </div>
                        <div class="option-group">
                            <div class="input-group">
                                <label for="cor">Cor</label>
                                <select name="cor" id="cor">
                                    <option value="{{ $tinta->cor }}"> {{ $tinta->cor }}</option>
                                    <option value="Branco">Branco</option>
                                    <option value="Preto">Preto</option>
                                    <option value="Amarelo">Amarelo</option>
                                    <option value="Vermelho">Vermelho</option>
                                </select>
                            </div>
                            <div class="input-group">
                                <label for="quantidade">Quantidade</label>
                                <input name="quantidade" id="quantidade" value="{{ $tinta->quantidade }}">
                            </div>
                        </div>
                    </div>
                    <div class="input-content" style="flex-direction: column; gap: 0">
                        <label for="capacidade">Capacidade</label>
                        <div class="input-group" style="flex-direction: row;">
                            <input type="number" name="capacidade" id="capacidade" min="0" step="any"
                                required style="width: 83%" value="{{ $tinta->capacidade }}">
                            <div class="option-group">
                                <select id="unidade" name="unidade">
                                    <option value="{{ $tinta->unidade_tinta }}">{{ $tinta->unidade_tinta }}</option>
                                    <option value="L">L</option>
                                    <option value="mL">mL</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="input-group">
                        <label for="fornecedor">Fornecedor</label>
                        <select name="fornecedor" id="fornecedor">
                            <option value="{{ $tinta->fornecedor_id }}">
                                {{ $tinta->fornecedor ? $tinta->fornecedor->nome : 'Selecionar fornecedor' }}
                            </option>
                            @foreach ($fornecedores as $fornecedor)
                                <option value="{{ $fornecedor->id }}">
                                    {{ $fornecedor->nome }}
                                </option>
                            @endforeach
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
