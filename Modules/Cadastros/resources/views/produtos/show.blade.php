<div id="modal_default" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('cadastros::produtos.update',  ['produto' => $dados->prod_id] )}}" name='editProduto' method="POST" class="form-validate-jquery">
                @csrf
                @method('PUT')
                <input type="hidden" name="_dataType" value="json" />
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Editar Produto') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col">
                            <div class='form-group'>
                                <label class="form-label">{{ $model->getAttributeLabel('prod_nome') }} <span class="text-danger">*</span></label>
                                <input class="form-control @error('prod_nome') is-invalid @enderror" type="text" name="prod_nome" required placeholder="{{ $model->getAttributeLabel('prod_nome') }}" value="{{ $dados->prod_nome }}" />
                                @error('prod_nome')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col">
                            <div class='form-group'>
                                <label class="form-label">{{ $model->getAttributeLabel('prod_codigo') }} <span class="text-danger">*</span></label>
                                <input class="form-control @error('prod_codigo') is-invalid @enderror" type="text" name="prod_codigo" required placeholder="{{ $model->getAttributeLabel('prod_codigo') }}" value="{{ $dados->prod_codigo }}" />
                                @error('prod_codigo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <div class='form-group'>
                                <label class="form-label">{{ $model->getAttributeLabel('prod_tempo_estimado') }} <span class="text-danger">*</span></label>
                                <input class="form-control @error('prod_tempo_estimado') is-invalid @enderror" type="time" name="prod_tempo_estimado" required placeholder="{{ $model->getAttributeLabel('prod_tempo_estimado') }}" value="{{ $e->segundosParaTime($dados->prod_tempo_estimado) }}" />
                                @error('prod_tempo_estimado')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col">
                            <div class='form-group'>
                                <label class="form-label">{{ $model->getAttributeLabel('prod_ativo') }} <span class="text-danger">*</span></label>
                                <select name="prod_ativo" class="form-select @error('prod_ativo') is-invalid @enderror" required>
                                    <option value="">{{ __('Selecione...') }}</option>
                                    <option value="1" {{ $dados->prod_ativo == 1 ? 'selected' : '' }}>{{ __('Ativo') }}</option>
                                    <option value="0" {{ $dados->prod_ativo === 0 ? 'selected' : '' }}>{{ __('Inativo') }}</option>
                                </select>
                                @error('prod_ativo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Fechar') }}</button>
                    <button type="button" data-action="editar-produto" class="btn btn-primary">{{ __('Editar') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
