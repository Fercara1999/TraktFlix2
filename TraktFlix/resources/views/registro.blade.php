
@extends('layouts.app')
  
  @section('header')
  <!-- ======= Header ======= -->
  <header id="header" class="d-flex align-items-center">
    <div class="container d-flex flex-column align-items-center">

      <h1>TraktFlix</h1>

      <div class="social-links text-center">
        <a href="/login" class="">Iniciar sesión</a>
        <a href="/registro" class="">Regístrate</a>
      </div>


    </div>
  </header><!-- End #header -->
  @endsection

  @section('main')

  <main id="main">

    <section id="login" class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section-title">
                        <h2>Regístrate</h2>
                    </div>
                    <form action="{{ route('registro') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" required>
                            <span id="nombre-error" class="error-message"></span>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                            <span id="email-error" class="error-message"></span>
                        </div>
                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                            <span id="password-error" class="error-message"></span>
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Confirmar contraseña</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                            <span id="password-confirmation-error" class="error-message"></span>
                        </div>
                        <div class="form-group">
                            <label for="fecha_nacimiento">Fecha de nacimiento</label>
                            <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control" required>
                            <span id="fecha-nacimiento-error" class="error-message"></span>
                        </div>
                        <div class="form-group">
                            <label for="usuario">Nombre de usuario</label>
                            <input type="text" name="usuario" id="usuario" class="form-control" required>
                            <span id="usuario-error" class="error-message"></span>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Regístrate</button>
                        </div>
                    </form>

                    <script>
                        // Valida los campos al enviar el formulario
                        document.querySelector('form').addEventListener('submit', function(event) {
                            var nombre = document.getElementById('nombre');
                            var email = document.getElementById('email');
                            var password = document.getElementById('password');
                            var passwordConfirmation = document.getElementById('password_confirmation');
                            var fechaNacimiento = document.getElementById('fecha_nacimiento');
                            var usuario = document.getElementById('usuario');
                            var errorMessages = document.getElementsByClassName('error-message');

                            // Limpia los mensajes de error
                            for (var i = 0; i < errorMessages.length; i++) {
                                errorMessages[i].textContent = '';
                            }

                            // Valida cada campo y muestra el mensaje de error correspondiente
                            if (nombre.value.trim() === '') {
                                event.preventDefault();
                                document.getElementById('nombre-error').textContent = 'El campo Nombre es obligatorio.';
                            }

                            if (email.value.trim() === '') {
                                event.preventDefault();
                                document.getElementById('email-error').textContent = 'El campo Email es obligatorio.';
                            }

                        });
                    </script>
                </div>
            </div>
        </div>
    </section>
    @endsection