
@extends('layouts.app')

<!-- ======= Header ======= -->
@section('header')
  <header id="header" class="d-flex align-items-center">
    <div class="container d-flex flex-column align-items-center">

      <h1>TraktFlix</h1>

      <div class="social-links text-center">
        <a href="/login" class="">Iniciar sesión</a>
        <a href="/registro" class="">Regístrate</a>
      </div>

    </div>
  </header>
  @endsection

@section('main')
<main>
<section id="login" class="login" style="background-color: transparent;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card" style="background-color: rgba(255, 255, 255, 0.8);">
                    <div class="card-body">
                        <h2 class="card-title">Iniciar sesión</h2>
                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Nombre de usuario / Correo electrónico</label>
                                <input type="text" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="remember">Recuérdame</label>
                            </div>
                            <div class="mb-3">
                                <a href="#" class="forgot-password">¿Olvidaste tu contraseña?</a>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Iniciar sesión</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection