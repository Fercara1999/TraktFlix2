<?php
use Illuminate\Support\Facades\Auth;
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>TraktFlix</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Maundy
  * Updated: Mar 13 2024 with Bootstrap v5.3.3
  * Template URL: https://bootstrapmade.com/maundy-free-coming-soon-bootstrap-theme/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
  <!-- Header -->
  <header id="header" class="p-0">
    <nav class="navbar navbar-expand-lg navbar-light" style="background-image: linear-gradient(to right, #333333, #CCCCCC);">
      <div class="container-fluid">
        <!-- Left side -->
        <div class="d-flex align-items-center">
        <form class="d-flex" action="{{ route('resultadoBusqueda') }}" method="GET">
            <div class="input-group">
                <input class="form-control" type="search" placeholder="Introduce tu búsqueda" aria-label="Search" style="width: 225px;" id="busqueda" name="busqueda">
                <!--<select class="form-select" aria-label="Campo de búsqueda" style="width: 100px;" name="campo">
                    <option value="titulo">Título</option>
                    <option value="actor">Actor</option>
                    <option value="director">Director</option>
                </select>!-->
                <div class="input-group-append">
                    <button class="btn btn-outline-primary" type="submit">Buscar</button>
                </div>
            </div>
        </form>
        </div>

        <!-- Center -->
        <div class="navbar-brand mx-auto">
          <a href="{{ route('index') }}" style="display: inline-block; padding: 0;"><img src="assets/img/TraktFlix.png" alt="Logo" style="width:150px;"></a>
        </div>

        <!-- Right side -->
        <div class="d-flex align-items-center">
          <a class="btn btn-outline-primary me-2" href="{{ route('listas') }}">Mis Listas</a>
          <a class="btn btn-outline-primary me-2" href="#">Favoritas</a>
          <?php
          if(Auth::check()) {
            echo '<a class="btn btn-outline-primary" href="' . route('indexIniciado') . '" style="width: 200px;">Hola, ' . Auth::user()->usuario . '</a>';
          } else {
            echo '<a class="btn btn-outline-primary" href="' . route('registro') . '">Regístrate</a>';
          }
          ?>

        </div>
      </div>
    </nav>
  </header>


</head>
<body>
    @yield('header')
    
    @yield('main')
    
  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong><span>Maundy</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/maundy-free-coming-soon-bootstrap-theme/ -->
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
      </div>
    </div>
  </footer><!-- End #footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

  <script src="{{ asset('js/funcionesObtencion.js') }}"></script>
</body>
</html>