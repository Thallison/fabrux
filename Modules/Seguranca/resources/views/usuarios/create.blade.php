@extends('layouts.default')

@section('page-title', 'Usuários')

@section('content')
    
<div class="card card-default mb-5">
    <div class="card-header">
        <h5 class="card-title">{{ __('Cadastrar Usuário') }}</h5>
        <div class="text-end">
            <a href="{{ route('seguranca::usuarios.index') }}" class="btn btn-info"><i class="bi bi-plus"></i> {{ __('Listar Usuários') }}</a>
            <a class="list-icons-item" data-action="collapse"></a>
        </div>
    </div>
    <form action="{{ route('seguranca::usuarios.store') }}" method="POST" name="formUser">
        <div class="card-body ">
            @csrf
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class='form-group'>
                        <label class="form-label">{{ __($model->getAttributeLabel('usr_name')) }} : <span class="text-danger">*</span></label>
                        <input class="form-control @error('usr_name') is-invalid @enderror" type="text" name="usr_name" required  placeholder="{{ __($model->getAttributeLabel('usr_name')) }}" value="{{ old('usr_name') }}" />
                        @error('usr_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class='form-group'>
                        <label class="form-label">{{ $model->getAttributeLabel('usr_login') }} : <span class="text-danger">*</span></label>
                        <input class="form-control @error('usr_login') is-invalid @enderror" type="text" name="usr_login" required placeholder="{{ $model->getAttributeLabel('usr_login') }}" value="{{ old('usr_login') }}" />
                        @error('usr_login')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class='form-group'>
                        <label class="form-label">{{ __($model->getAttributeLabel('email')) }} : <span class="text-danger">*</span></label>
                        <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" required placeholder="{{ __($model->getAttributeLabel('email')) }}" value="{{ old('email') }}" />
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">{{ __($model->getAttributeLabel('usr_status')) }} : <span class="text-danger">*</span> </label>
                    <select name="usr_status" class="form-select" required  @error('usr_status') is-invalid @enderror>
                        <option value="">{{ __('Selecione...') }}</option>
                        <option value="1"
                            {{ old('usr_status') == 1 ? 'selected' : '' }}>
                            {{ __('Ativo') }}
                        </option>
                        <option value="0"
                            {{ old('usr_status') === 0 ? 'selected' : '' }}>
                            {{ __('Inativo') }}
                        </option>
                    </select>
                    @error('usr_status')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>
            </div>

            <div class="row mb-3 align-items-end">
                <div class="col-md-4">
                    <div class='form-group'>
                        <label class="form-label">{{ __($model->getAttributeLabel('password')) }} : <span class="text-danger">*</span></label>
                        <input class="form-control @error('senha') is-invalid @enderror" type="password" name="senha" required  placeholder="{{ __($model->getAttributeLabel('password')) }}" value="{{ old('senha') }}" />
                        @error('senha')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class='form-group'>
                        <label class="form-label">{{ __('Confirmar Senha') }} : <span class="text-danger">*</span></label>
                        <input class="form-control @error('repeat_senha') is-invalid @enderror" type="password" name="repeat_senha" required  placeholder="{{ __('Confirmar Senha') }}" value="{{ old('repeat_senha') }}" />
                        @error('repeat_senha')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <button type="button" class="btn btn-warning gerarPassword">
                            <i class="fa-solid fa-lock"></i>{{ __('Gerar Senha') }}
                        </button>
                    </div>
                </div>
            </div>

            <div class="row mb-3 align-items-end"> 
                <div class="col-md-6">
                    <label class="form-label">{{ __('Perfil acesso') }} : <span class="text-danger">*</span></label>
                    <x-seguranca::select-grupo-usuarios
                        :papeis="$papeis"
                        :selected="old('perfil') ?? null"
                        class="filter"
                        required
                    />
                </div>

                <div class="col-md-4">
                    <a class="btn btn-xs btn-info btn-float" id="adicionar_perfil" href="#">
                        <i class="bi bi-plus"></i> {{ __('Adicionar perfil') }}
                    </a>
                </div>
            </div>

            <span class="d-none fs-6 textoSenha"></span>

            <hr>

            <div class="row mb-3 table-responsive">
                <div class="form-group">
                    <table class="table table-hover" id="div_perfil">
                        <thead>
                            <tr>
                                <th colspan="2" style="text-align: center">Perfil do usuário</th>
                            </tr>
                            <tr>
                                <th>Perfil</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

        </div>
        <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary">{{ __('Cadastrar') }}
                <i class="bi bi-floppy"></i>
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>

    document.querySelectorAll('.gerarPassword').forEach(btn => {
        btn.addEventListener('click', () => {
            
            const pass = generatePassword(10);

            document.querySelector('input[name="senha"]').value = pass;
            document.querySelector('input[name="repeat_senha"]').value = pass;

            const textoSenha = document.querySelector('.textoSenha');
            textoSenha.innerHTML = `
                <strong class="fw-semibold text-uppercase text-primary">
                    Senha gerada:
                </strong> ${pass}
            `;
            textoSenha.classList.remove('d-none');
        });
    });

    function generatePassword(length) {
        const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%';
        return Array.from({ length }, () => chars[Math.floor(Math.random() * chars.length)]).join('');
    }

    document.addEventListener('click', function(e){

        const btn = e.target.closest('[data-action="remove-item"]');
        if(!btn) return;

        const perfil = btn.dataset.perfil;

        arr_perfil = arr_perfil.filter(p => p !== perfil);

    });

    document.addEventListener("DOMContentLoaded", function () {

        const form = document.querySelector('form[name="formUser"]');

        form.addEventListener('submit', (e) => {
            const senha = document.querySelector('input[name="senha"]').value;
            const repetSenha = document.querySelector('input[name="repeat_senha"]').value;

            // valida senha
            if (senha !== repetSenha) {
                e.preventDefault();

                App.message('As senhas não conferem.', 'danger');

                document.querySelector('input[name="senha"]').classList.add('is-invalid');
                document.querySelector('input[name="repeat_senha"]').classList.add('is-invalid');

                return;
            }

            // valida papeis
            const papeis = document.querySelectorAll('input[name^="papeis"]').length;

            if (!papeis) {
                e.preventDefault();

                App.message('Adicione no mínimo um perfil para o usuário', 'danger');

                return;
            }

        });

        let arr_perfil = [];

        App.dynamicFields({
            addButton: '#adicionar_perfil',
            container: '#div_perfil',
            beforeAdd: () => {
                const select = document.querySelector('select[name="perfil"]');

                if (!select.value) {
                    App.message('Selecione um perfil', 'warning');
                    return false;
                }
            },
            template: () => {
                const select = document.querySelector('select[name="perfil"]');
                const valor = select.value;
                const texto = select.options[select.selectedIndex].text;

                const perfil_val = `papel_${valor}`;

                if (arr_perfil.includes(perfil_val)) {
                    App.message('Este perfil já está inserido.', 'warning');
                    return '';
                }

                arr_perfil.push(perfil_val);

                return `
                    <tr class="dynamic-item">
                        <td>${texto}</td>
                        <td>
                            <input type="hidden" name="papeis[]" value="${valor}">
                            <a href="#" data-action="remove-item" data-perfil="${perfil_val}" class="btn btn-danger btn-sm">
                                <i class="bi bi-x"></i>
                            </a>
                        </td>
                    </tr>
                `;
            },
            afterRemove: ({ button }) => {
                const perfil = button.dataset.perfil;
                arr_perfil = arr_perfil.filter(p => p !== perfil);
            }
        });
    });

    const inputLogin = document.querySelector('input[name="usr_login"]');

    inputLogin?.addEventListener('blur', async (e) => {
        
        const login = e.target.value;
        const token = document.querySelector('input[name="_token"]').value;

        // limpa erros anteriores
        document.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
        inputLogin.classList.remove('is-invalid');

        if (!login) return;

        App.fetch({
            url: '{{ route("seguranca::usuarios.validaLogin") }}',
            method: "POST",
            data: {
                login: login,
                _token: token
            },
            success: function(response){
                if (response.type) {
                    App.message(response.message, response.type);
                }

                if (response.login) {
                    inputLogin.insertAdjacentHTML('afterend', `
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>Login não disponível</strong>
                        </span>
                    `);

                    inputLogin.classList.add('is-invalid');
                    inputLogin.value = '';
                }

                if(response.type === "error"){
                    App.message('Erro ao validar login', 'danger');
                }
            }
        });
    });
</script>
@endpush