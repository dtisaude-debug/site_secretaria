<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Secretaria de Saúde</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1a6fc4, #1a3f7a);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        .login-header {
            background: linear-gradient(135deg, #1a6fc4, #1a3f7a);
            border-radius: 16px 16px 0 0;
            padding: 2rem;
            text-align: center;
            color: white;
        }
        .login-header img {
            width: 70px;
            margin-bottom: 1rem;
        }
        .btn-login {
            background: linear-gradient(135deg, #1a6fc4, #1a3f7a);
            border: none;
            color: white;
            padding: 0.75rem;
            font-weight: 600;
            border-radius: 8px;
            transition: opacity 0.2s;
        }
        .btn-login:hover { opacity: 0.9; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                <div class="card login-card">

                    <div class="login-header">
                        <i class="fas fa-shield-heart fa-3x mb-2"></i>
                        <h5 class="mb-0">Secretaria de Saúde</h5>
                        <small class="opacity-75">Guarapuava — Painel Administrativo</small>
                    </div>

                    <div class="card-body p-4">

                        {{-- Erros --}}
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                {{ $errors->first() }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-envelope me-1 text-primary"></i> E-mail
                                </label>
                                <input
                                    type="email"
                                    name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}"
                                    placeholder="seu@email.com"
                                    required autofocus
                                >
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-lock me-1 text-primary"></i> Senha
                                </label>
                                <input
                                    type="password"
                                    name="password"
                                    class="form-control"
                                    placeholder="••••••••"
                                    required
                                >
                            </div>

                            <div class="mb-4 form-check">
                                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                                <label class="form-check-label" for="remember">Lembrar-me</label>
                            </div>

                            <button type="submit" class="btn btn-login w-100">
                                <i class="fas fa-sign-in-alt me-2"></i> Entrar
                            </button>
                        </form>

                    </div>
                </div>

                <p class="text-center text-white mt-3 opacity-75 small">
                    © {{ date('Y') }} Secretaria de Saúde de Guarapuava
                </p>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>