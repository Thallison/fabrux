<div id="modal_default" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('cadastros::funcionarios.update',  ['funcionario' => $dados->fun_id] )}}" name='editFuncionario' method="POST" class="form-validate-jquery">
                @csrf
                @method('PUT')
                <input type="hidden" name="_dataType" value="json" />
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Editar Funcionário') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>    
                </div>

                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col">
                            <div class='form-group'>
                                <label class="form-label">{{ $model->getAttributeLabel('fun_nome') }} <span class="text-danger">*</span></label>
                                <input class="form-control @error('fun_nome') is-invalid @enderror" type="text" name="fun_nome" required  placeholder="{{ $model->getAttributeLabel('fun_nome') }}" value="{{ $dados->fun_nome }}" />
                                @error('fun_nome')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col">
                            <div class='form-group'>
                                <label class="form-label">{{ $model->getAttributeLabel('fun_codigo') }} <span class="text-danger">*</span></label>
                                <input class="form-control @error('fun_codigo') is-invalid @enderror" type="text" name="fun_codigo" required  placeholder="{{ $model->getAttributeLabel('fun_codigo') }}" value="{{ $dados->fun_codigo }}" />
                                @error('fun_codigo')
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
                                <label class="form-label">{{ $model->getAttributeLabel('fun_carga_horaria') }} <span class="text-danger">*</span></label>
                                <input class="form-control @error('fun_carga_horaria') is-invalid @enderror" type="time" name="fun_carga_horaria" required  placeholder="{{ $model->getAttributeLabel('fun_carga_horaria') }}" value="{{ $e->segundosParaTime($dados->fun_carga_horaria) }}" />
                                @error('fun_carga_horaria')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col">
                            <div class='form-group'>
                                <label class="form-label">{{ $model->getAttributeLabel('fun_set_id') }} <span class="text-danger">*</span></label>
                                <select name="fun_set_id" id="fun_set_id_edit" class="form-select" data-tom-select="true" data-tom-select-placeholder="Selecione um setor" required @error('fun_set_id') is-invalid @enderror>
                                    <option value="">{{ __('Selecione...') }}</option>
                                    @foreach ($setores as $setor)
                                        <option value="{{ $setor->set_id }}" {{ (string) $dados->fun_set_id === (string) $setor->set_id ? 'selected' : '' }}>
                                            {{ $setor->set_nome }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('fun_set_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col">
                            <div class='form-group'>
                                <label class="form-label">{{ $model->getAttributeLabel('fun_ativo') }} <span class="text-danger">*</span></label>
                                <select name="fun_ativo" id="fun_ativo_edit" class="form-select" data-tom-select="true" data-tom-select-placeholder="Selecione um status" required  @error('fun_ativo') is-invalid @enderror>
                                    <option value="">{{ __('Selecione...') }}</option>
                                    <option value="1"
                                        {{ $dados->fun_ativo == 1 ? 'selected' : '' }}>
                                        {{ __('Ativo') }}
                                    </option>
                                    <option value="0"
                                        {{ $dados->fun_ativo === 0 ? 'selected' : '' }}>
                                        {{ __('Inativo') }}
                                    </option>
                                </select>
                                @error('fun_ativo')
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
                    <button type="button" data-action="editar-funcionario" class="btn btn-primary">{{ __('Editar') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>