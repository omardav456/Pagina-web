<?php
session_start();
if($_SESSION['id']===null || $_SESSION['id']===0){
   header('Location: indexlogin.php'); // Redirige a login si no está autenticado
   exit;
 }


?>


<!DOCTYPE html>
   <html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">

      <!--=============== FAVICON ===============-->
      <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">

      <!--=============== REMIXICONS ===============-->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css">

      <!--=============== CSS ===============-->
      <link rel="stylesheet" href="assets/css/styles.css">

      <title> halloween</title>
   </head>
   <body>
      <!--==================== HEADER ====================-->
  <header class="header" id="header">
         <nav class="nav container-nav">
            <a href="Index.php" class="nav__logo">
               Alkostico
            </a>

            <div class="nav__menu" id="nav-menu">
               <ul class="nav__list">
                  <li class="nav__item">
                     <a href="Categorias.php" class="nav__link">Catalogo</a>
                  </li>

                  <li class="nav__item">
                     <a href="carrito.php" class="nav__link">Carrito</a>
                  </li>

                  <li class="nav__item">
                     <a href="evento.php" class="nav__link">Eventos</a>
                  </li>

                  <li class="nav__">
                     <!-- Login button -->
                     <a href="usuario.php" class="ri-user-line nav__login" id="login-btn"></a>
                  </li>
               </ul>
               
               <!-- Close button -->
               <div class="nav__close" id="nav-close">
                  <i class="ri-close-line"></i>
               </div>
            </div>

            <!-- Toggle button -->
            <div class="nav__toggle" id="nav-toggle">
               <i class="ri-apps-2-line"></i>
            </div>
            
         </nav>
</header>

      <!--==================== MAIN ====================-->
      <main class="main">
         <!--==================== HOME ====================-->
         <section class="home">
            <div class="home__container">
               <img src="assets/img/home-point.png" alt="image" class="home__points">
               <img src="assets/img/home-shadow.png" alt="image" class="home__shadow">
               <img src="assets/img/home-moon.png" alt="image" class="home__moon">
               <img src="assets/img/home-trees.png" alt="image" class="home__tree">
               <img src="assets/img/home-pumpkin.png" alt="image" class="home__pumpkin">
               <img src="assets/img/home-stones.png" alt="image" class="home__stone">
               <img src="assets/img/home-grass.png" alt="image" class="home__grass">
   
               <div class="home__titles">
                  <h2 class="home__subtitle">DULCE O TRUCO</h2>
                  <h1 class="home__title">HALLOWEEN</h1>
               </div>
            </div>

            <div class="home__data">
               <p class="home__description">
               ¡Únete a nuestro evento de Halloween y obtén aterradores descuentos!
               </p>

               <a href="juego.php" class="home__button">
                  <img src="assets/img/button.svg" alt="">
                  <span>JUGAR</span>
               </a>
            </div>
         </section>
      </main>

      <!--=============== GSAP ===============-->
      <script src="assets/js/gsap.min.js"></script>

      <!--=============== MAIN JS ===============-->
      <script src="assets/js/main.js"></script>
   </body>
</html>