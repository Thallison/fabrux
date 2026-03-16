<div id="modal_default" class="modal fade modal-lg" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('seguranca::privilegios.update',  ['privilegio' => $dados->priv_id] )}}" name='editPrivilegio' method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="_dataType" value="json" />
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Editar Privilegio') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>    
                </div>

                <div class="modal-body">
                    <div class="bootstrap-duallistbox-container row moveonselect">
                        <div class="box1 col-md-6">
                            <label>{{ $model->getAttributeLabel('priv_label') }} <span class="text-danger">*</span></label>
                            <input class="filter form-control @error('priv_label') is-invalid @enderror" type="text" name="priv_label" id="priv_label" required  placeholder="{{ $model->getAttributeLabel('priv_label') }}" value="{{ $dados->priv_label }}" />
                            @error('priv_label')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="box2 col-md-6">
                            <label>{{ $model->getAttributeLabel('priv_action') }}</label>
                            <input class="filter form-control @error('priv_action') is-invalid @enderror" type="text" name="priv_action" required placeholder="{{ $model->getAttributeLabel('priv_action') }}" value="{{ $dados->priv_action }}" />
                            @error('priv_action')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                    </div>

                    <hr>
                    <div class="row">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th colspan="4" style="text-align: center">Dependências do Privilégio</th>
                                </tr>
                                <tr>
                                    <th>#</th>
                                    <th>Controller</th>
                                    <th>Action</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($privDependencia as $dep)
                                    <tr>
                                        <td>{{ $dep->dep_priv_id }}</td>
                                        <td>{{ $dep->dep_priv_controller }}</td>
                                        <td>{{ $dep->dep_priv_action }}</td>
                                        <td>
                                            <div class="icons-list">
                                                <a class="btn btn-danger btn-sm" data-action="deleteDepPrivilegio" data-url="{{ route('seguranca::privilegios.destroydep', ['dependencia' => $dep->dep_priv_id]) }}"
                                                    data-method="DELETE" href="#" title="{{ __('Excluir dependência do privilégio') }}">
                                                    <i class="bi bi-x"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" style="text-align: center">Nenhuma Dependências cadastrada.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="row mb-3" id="div_dep_privilegios"></div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <a class="btn btn-info" id="adicionar_dep_privilegios"><i class="bi bi-plus"></i> {{ __('Adicionar dependência') }}</a>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Fechar') }}</button>
                    <button type="button" data-action="editar-privilegio" class="btn btn-primary">{{ __('Editar') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
