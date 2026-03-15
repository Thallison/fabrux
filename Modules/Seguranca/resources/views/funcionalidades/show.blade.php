<div id="modal_default" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('seguranca::modulos.update',  ['modulo' => $dados->mod_id] )}}" name='editModulo' method="POST" class="form-validate-jquery">
                @csrf
                @method('PUT')
                <input type="hidden" name="_dataType" value="json" />
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Editar Módulo') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>    
                </div>

                <div class="modal-body">
                    <div class="bootstrap-duallistbox-container row moveonselect">
                        <div class="box1 col-md-4">
                            <label>{{ __('Nome do módulo:') }} <span class="text-danger">*</span></label>
                            <input class="filter form-control @error('mod_nome') is-invalid @enderror" type="text" name="mod_nome" id="mod_nome" required  placeholder="{{ __('Nome do módulo:') }}" value="{{ $dados->mod_nome }}" />
                            @error('mod_nome')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="box1 col-md-4">
                            <label>{{ __('Nome do Sistema:') }} <span class="text-danger">*</span></label>
                            <x-seguranca::select-sistemas
                                :sistemas="$sistemas"
                                :selected="$dados->sis_id ?? null"
                                class="filter"
                                required
                            />
                        </div>
                        <div class="box2 col-md-4">
                            <label>{{ __('Nome do icone:') }}</label>
                            <input class="filter form-control @error('mod_icone') is-invalid @enderror type="text" name="mod_icone" placeholder="{{ __('Nome do icone:') }}" value="{{ $dados->mod_icone }}" />
                            @error('mod_icone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Fechar') }}</button>
                    <button type="button" data-action="editar-modulo" class="btn btn-primary">{{ __('Editar') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>