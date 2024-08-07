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
                            <h2 class="mb-2" style="font-size: 1.5rem; color: #374151;">Iniciar sesión</h2>
                            <p style="color: #6b7280;">Correo: 2130073@upv.edu.mx</p>
                            <p style="color: #6b7280;">Contraseña: password</p>
                                <form action="{{ route('login') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <input class="form-control @error('email') is-invalid @enderror @error('username') is-invalid @enderror" type="text" name="input_type" placeholder="Correo" value="{{ old('input_type') }}" autocomplete="off" required autofocus style="border-radius: 0.375rem; border: 1px solid #d1d5db; padding: 0.75rem 1rem;">
                                    @error('username')
                                    <div class="text-danger small mt-2">Correo o contraseña incorrecto.</div>
                                    @enderror
                                    @error('email')
                                    <div class="text-danger small mt-2">Correo o contraseña incorrecto.</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input class="form-control @error('email') is-invalid @enderror @error('username') is-invalid @enderror" type="password" name="password" placeholder="Contraseña" required style="border-radius: 0.375rem; border: 1px solid #d1d5db; padding: 0.75rem 1rem;">
                                </div>
                                <div class="form-group d-flex justify-content-between">
                                    <p class="mb-0">
                                        ¿No te has registrado?  <a href="{{ route('register') }}" style="color: #18aaa8;">Registrarse</a>
                                    </p>
                                </div>
                                <button type="submit" class="btn" style="background-color: #18aaa8; color: #ffffff; padding: 0.75rem 1.5rem; border-radius: 0.375rem; border: none; font-weight: 600; transition: background-color 0.2s ease;">Iniciar sesión</button>
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
