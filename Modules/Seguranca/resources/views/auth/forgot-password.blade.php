@extends('layouts.auth')

@section('content')
<div class="login-box fabrux-auth-box">
    <div class="login-logo mb-3">
        <span class="fabrux-auth-title">Fabrux</span>
        <p class="fabrux-auth-subtitle mb-0">Recuperar senha</p>
    </div>

    <div class="card fabrux-auth-card">
        <div class="card-body login-card-body p-4 p-md-5">
            <p class="login-box-msg mb-4">Informe seu e-mail para receber o link de redefinição</p>

            @error('error_login')
                <div class="alert alert-danger" role="alert">{{ $message }}</div>
            @enderror

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form action="{{ route('password.email') }}" method="post">
                @csrf

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

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-primary">Enviar link de redefinição</button>
                </div>
            </form>

            <div class="mt-4 text-center">
                <p class="mb-1"><a href="{{ route('login') }}">Voltar ao login</a></p>
            </div>
        </div>
    </div>
</div>
@endsection