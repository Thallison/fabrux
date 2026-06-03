<div id="modal_default" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('cadastros::setores.update', ['setor' => $dados->set_id]) }}" name='editSetor' method="POST" class="form-validate-jquery">
                @csrf
                @method('PUT')
                <input type="hidden" name="_dataType" value="json" />
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Editar Setor') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col">
                            <div class='form-group'>
                                <label class="form-label">{{ $model->getAttributeLabel('set_nome') }} <span class="text-danger">*</span></label>
                                <input class="form-control @error('set_nome') is-invalid @enderror" type="text" name="set_nome" required placeholder="{{ $model->getAttributeLabel('set_nome') }}" value="{{ $dados->set_nome }}" />
                                @error('set_nome')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col">
                            <div class='form-group'>
                                <label class="form-label">{{ $model->getAttributeLabel('set_codigo') }} <span class="text-danger">*</span></label>
                                <input class="form-control @error('set_codigo') is-invalid @enderror" type="text" name="set_codigo" required placeholder="{{ $model->getAttributeLabel('set_codigo') }}" value="{{ $dados->set_codigo }}" />
                                @error('set_codigo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col">
                            <div class='form-group'>
                                <label class="form-label">{{ $model->getAttributeLabel('set_ativo') }} <span class="text-danger">*</span></label>
                                <select name="set_ativo" id="set_ativo_edit" class="form-select" data-tom-select="true" data-tom-select-placeholder="Selecione um status" required @error('set_ativo') is-invalid @enderror>
                                    <option value="">{{ __('Selecione...') }}</option>
                                    <option value="1" {{ $dados->set_ativo == 1 ? 'selected' : '' }}>
                                        {{ __('Ativo') }}
                                    </option>
                                    <option value="0" {{ $dados->set_ativo === 0 ? 'selected' : '' }}>
                                        {{ __('Inativo') }}
                                    </option>
                                </select>
                                @error('set_ativo')
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
                    <button type="button" data-action="editar-setor" class="btn btn-primary">{{ __('Editar') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
