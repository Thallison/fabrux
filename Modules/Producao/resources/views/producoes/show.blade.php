<div id="modal_default" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('producao.update', ['producao' => $dados->producao_id ]) }}" name="editProducao" method="POST" class="form-validate-jquery">
                @csrf
                @method('PUT')
                <input type="hidden" name="_dataType" value="json" />

                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Editar Produção') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">{{ $model->getAttributeLabel('fun_id') }} <span class="text-danger">*</span></label>
                                <select name="fun_id" class="form-select" required>
                                    <option value="">{{ __('Selecione...') }}</option>
                                    @foreach($funcionarios as $funcionario)
                                        <option value="{{ $funcionario->fun_id }}" {{ $dados->fun_id == $funcionario->fun_id ? 'selected' : '' }}>
                                            {{ $funcionario->fun_nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group position-relative">
                                <label class="form-label">{{ $model->getAttributeLabel('prod_id') }} <span class="text-danger">*</span></label>
                                <input type="hidden" name="prod_id" id="prod_id" value="{{ old('prod_id', $dados->prod_id) }}" />
                                <input
                                    type="text"
                                    name="produto_search"
                                    id="produto_search"
                                    class="form-control"
                                    placeholder="{{ __('Digite para buscar o produto...') }}"
                                    autocomplete="off"
                                    required
                                    value="{{ old('produto_search', optional($dados->produto)->prod_nome) }}"
                                />
                                <div id="produto_search_list" class="list-group position-absolute w-100 z-3 d-none" style="max-height: 250px; overflow-y: auto;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mt-3">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">{{ $model->getAttributeLabel('quantidade') }} <span class="text-danger">*</span></label>
                                <input class="form-control" type="number" min="1" name="quantidade" required value="{{ $dados->quantidade }}" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">{{ $model->getAttributeLabel('data') }} <span class="text-danger">*</span></label>
                                <input class="form-control" type="date" name="data" required value="{{ $dados->data->format('Y-m-d') }}" />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">{{ $model->getAttributeLabel('hora') }}</label>
                                <input class="form-control" type="time" name="hora" value="{{ $dados->hora }}" />
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mt-3">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">{{ $model->getAttributeLabel('tempo_gasto') }}</label>
                                @php
                                    $tempoGasto = '';
                                    if ($dados->tempo_gasto !== null) {
                                        $tempoGasto = sprintf('%02d:%02d', floor($dados->tempo_gasto / 3600), floor(($dados->tempo_gasto % 3600) / 60));
                                    }
                                @endphp
                                <input class="form-control" type="time" name="tempo_gasto" value="{{ $tempoGasto }}" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Fechar') }}</button>
                    <button type="button" data-action="editar-producao" class="btn btn-primary">{{ __('Salvar alterações') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
