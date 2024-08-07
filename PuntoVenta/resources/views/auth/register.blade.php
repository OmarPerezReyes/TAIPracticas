@extends('auth.body.main')

@section('container')
<div class="container">
    <div class="row align-items-center justify-content-center height-self-center">
        <div class="col-lg-8">
            <div class="card auth-card" style="border-radius: 1rem; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); background-color: #ffffff;">
                <div class="card-body p-0">
                    <div class="text-center mb-4">
                        <!-- Logo -->
                        <a href="{{ url('/') }}" style="color: #18aaa8; text-decoration: none;"><img src="{{ asset('assets/images/logo.png') }}" alt="Logo" style="max-width: 150px;">
                        </a>
                    </div>
                    <div class="d-flex align-items-center auth-content">
                        <div class="col-lg-12 align-self-center">
                            <div class="p-3">
                                <h2 class="mb-2" style="font-size: 1.5rem; color: #374151;">Registrarse</h2>
                                <p style="color: #6b7280;">Crea tu cuenta.</p>

                                <form method="POST" action="{{ route('register') }}">
                                    @csrf
                                    <div class="form-group mb-3">
                                        <input class="form-control @error('name') is-invalid @enderror" type="text" placeholder="Nombre completo" name="name" autocomplete="off" value="{{ old('name') }}" required style="border-radius: 0.375rem; border: 1px solid #d1d5db; padding: 0.75rem 1rem;">
                                        @error('name')
                                        <div class="text-danger small mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <input class="form-control @error('username') is-invalid @enderror" type="text" placeholder="Nombre de usuario" name="username" autocomplete="off" value="{{ old('username') }}" required style="border-radius: 0.375rem; border: 1px solid #d1d5db; padding: 0.75rem 1rem;">
                                        @error('username')
                                        <div class="text-danger small mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <input class="form-control @error('email') is-invalid @enderror" type="email" placeholder="Correo" name="email" autocomplete="off" value="{{ old('email') }}" required style="border-radius: 0.375rem; border: 1px solid #d1d5db; padding: 0.75rem 1rem;">
                                        @error('email')
                                        <div class="text-danger small mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-3">
                                        <input class="form-control @error('password') is-invalid @enderror" type="password" placeholder="Contraseña" name="password" autocomplete="off" required style="border-radius: 0.375rem; border: 1px solid #d1d5db; padding: 0.75rem 1rem;">
                                        @error('password')
                                        <div class="text-danger small mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-4">
                                        <input class="form-control" type="password" placeholder="Confirma tu contraseña" name="password_confirmation" autocomplete="off" required style="border-radius: 0.375rem; border: 1px solid #d1d5db; padding: 0.75rem 1rem;">
                                    </div>

                                    <button type="submit" class="btn" style="background-color: #18aaa8; color: #ffffff; padding: 0.75rem 1.5rem; border-radius: 0.375rem; border: none; font-weight: 600; transition: background-color 0.2s ease;">Registrar</button>
                                    <p class="mt-3">
                                        ¿Ya tienes una cuenta? <a href="{{ route('login') }}" style="color: #18aaa8;">Inicia sesión</a>
                                    </p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
