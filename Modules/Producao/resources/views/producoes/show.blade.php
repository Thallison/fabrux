<div id="modal_default" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('producao::producoes.update', ['produco' => $dados->produ_id ]) }}" name="editProducao" method="POST" class="form-validate-jquery">
                @csrf
                @method('PUT')
                <input type="hidden" name="_dataType" value="json" />

                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Editar Produção') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">{{ $model->getAttributeLabel('fun_id') }} <span class="text-danger">*</span></label>
                                <select name="fun_id" class="form-select" required disabled>
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
                                <select name="prod_id" class="form-select @error('prod_id') is-invalid @enderror" required disabled>
                                    <option value="">{{ __('Selecione...') }}</option>
                                    @foreach($produtos as $produto)
                                        <option value="{{ $produto->prod_id }}" {{ $dados->prod_id == $produto->prod_id ? 'selected' : '' }}>
                                            {{ $produto->prod_nome }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('prod_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">{{ $model->getAttributeLabel('produ_quantidade') }} <span class="text-danger">*</span></label>
                                <input class="form-control" type="number" min="1" name="produ_quantidade" required value="{{ $dados->produ_quantidade }}" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">{{ $model->getAttributeLabel('produ_data') }} <span class="text-danger">*</span></label>
                                <input class="form-control" type="date" name="produ_data" required value="{{ $dados->produ_data->format('Y-m-d') }}" />
                            </div>
                        </div>

                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">{{ $model->getAttributeLabel('produ_hora') }}</label>
                                <input class="form-control" type="time" name="produ_hora" value="{{ $dados->produ_hora }}" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">{{ $model->getAttributeLabel('produ_tempo_gasto') }}</label>
                                <input class="form-control" type="time" name="produ_tempo_gasto" value="{{ $e->segundosParaTime($dados->produ_tempo_gasto) }}" />
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
