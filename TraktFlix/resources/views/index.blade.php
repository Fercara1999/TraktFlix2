@extends('layouts.app')

  <!-- ======= Header ======= -->
  @section('header')
  <header id="header" class="d-flex align-items-center">
    <div class="container d-flex flex-column align-items-center">

      <h1>TraktFlix</h1>
      <h2>Haz un seguimiento de las películas que ves. Descubre cuales son las tendencias</h2>
      <h2>Comparte comentarios, recomendaciones, calificaciones</h2>

      <div class="social-links text-center">
        <a href="/login" class="">Iniciar sesión</a>
        <a href="/registro" class="">Regístrate</a>
      </div>

    </div>
  </header>
  @endsection

  @section('main')
  <main>

  <div id="resultadoTendencias"></div>

    <!-- ======= About Us Section ======= -->
    <section id="about" class="about">
      <div class="container">

        <div class="section-title">
          <h2>¿Qué puedes hacer con TraktFlix?</h2>
        </div>

        <div class="row mt-2">
          <div class="col-lg-4 col-md-6 icon-box">
            <div class="icon"><i class="bi bi-heart-fill"></i></div>
            <h4 class="title"><a href="#">Almacena tus películas favoritas</a></h4>
            <p class="description">Guarda todas tus películas favoritas en un solo lugar para acceder a ellas fácilmente cuando quieras</p>
          </div>
          <div class="col-lg-4 col-md-6 icon-box">
            <div class="icon"><i class="bi bi-list-check"></i></div>
            <h4 class="title"><a href="#">Haz listas de películas</a></h4>
            <p class="description">Crea listas personalizadas de películas para organizar tus preferencias y descubrir nuevas joyas cinematográficas fácilmente</p>
          </div>
          <div class="col-lg-4 col-md-6 icon-box">
            <div class="icon"><i class="bi bi-chat-text-fill"></i></div>
            <h4 class="title"><a href="#">Comenta con otros usuarios</a></h4>
            <p class="description">Interactúa y comparte opiniones sobre películas con otros usuarios, enriqueciendo tu experiencia</p>
          </div>
        </div>

      </div>
    </section><!-- End About Us Section -->

    <!-- ======= Contact Us Section ======= -->
    <section id="contact" class="contact">
      <div class="container">

        <div class="section-title">
          <h2>Contacta con nosotros</h2>
        </div>

        <div class="row">

          <div class="col-lg-5 d-flex align-items-stretch">
            <div class="info">
              <div class="address">
                <i class="bi bi-geo-alt"></i>
                <h4>Localización:</h4>
                <p>Av. de Requejo, 4, 49012, Zamora</p>
              </div>

              <div class="email">
                <i class="bi bi-envelope"></i>
                <h4>Email:</h4>
                <p>info@traktflix.com</p>
              </div>

              <div class="phone">
                <i class="bi bi-phone"></i>
                <h4>Número de teléfono:</h4>
                <p>980 52 04 00</p>
              </div>

              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2987.7674881224625!2d-5.7373175!3d41.5093132!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd391e257455913f%3A0x7b48b9bffe8cd4c7!2sIES%20Claudio%20Moyano!5e0!3m2!1ses!2ses!4v1710671253915!5m2!1ses!2ses" frameborder="0" style="border:0; width: 100%; height: 290px;" allowfullscreen></iframe>
            </div>

          </div>

          <div class="col-lg-7 mt-5 mt-lg-0 d-flex align-items-stretch">
            <form action="forms/contact.php" method="post" role="form" class="php-email-form">
              <div class="row">
                <div class="form-group col-md-6">
                  <label for="name">Introduce tu nombre</label>
                  <input type="text" name="name" class="form-control" id="name" required>
                </div>
                <div class="form-group col-md-6 mt-3 mt-md-0">
                  <label for="name">Introduce tú correo electrónico</label>
                  <input type="email" class="form-control" name="email" id="email" required>
                </div>
              </div>
              <div class="form-group mt-3">
                <label for="name">Asunto</label>
                <input type="text" class="form-control" name="subject" id="subject" required>
              </div>
              <div class="form-group mt-3">
                <label for="name">Mensaje</label>
                <textarea class="form-control" name="message" rows="10" required></textarea>
              </div>
              <div class="my-3">
                <div class="loading">Loading</div>
                <div class="error-message"></div>
                <div class="sent-message">El mensaje ha sido enviado. Muchas gracias!</div>
              </div>
              <div class="text-center"><button type="submit">Enviar mensaje</button></div>
            </form>
          </div>

        </div>

      </div>
    </section><!-- End Contact Us Section -->

  </main>
  @endsection