@extends('layouts.auth')

@section('content')
<div class="login-box fabrux-auth-box">
    <div class="login-logo mb-3">
        <span class="fabrux-auth-title">Fabrux</span>
        <p class="fabrux-auth-subtitle mb-0">Criar nova senha</p>
    </div>

    <div class="card fabrux-auth-card">
        <div class="card-body login-card-body p-4 p-md-5">
            <p class="login-box-msg mb-4">Defina uma nova senha para sua conta</p>

            @error('error_login')
                <div class="alert alert-danger" role="alert">{{ $message }}</div>
            @enderror

            <form action="{{ route('password.update') }}" method="post">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}" />

                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="seuemail@empresa.com" value="{{ old('email') }}" autocomplete="username" />
                    </div>
                    @error('email')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Nova senha</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                        <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Digite a nova senha" autocomplete="new-password" />
                    </div>
                    @error('password')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirmar senha</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                        <input id="password_confirmation" type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Repita a nova senha" autocomplete="new-password" />
                    </div>
                    @error('password_confirmation')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-primary">Atualizar senha</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection