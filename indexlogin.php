
<?php


    
    function imprimirAlerta($mensaje, $tipo){
        $enviomensaje=true;
        $_SESSION['alerta'] = ['mensaje' => $mensaje, 'tipo' => $tipo];
        
    }
    
    
  // Datos de conexión
  $servername = "sql10.freemysqlhosting.net";  // Cambia esto si usas otro servidor
  $username = "sql10736060";         // Tu usuario de MySQL
  $password = "v3naSQAq5W";             // Tu contraseña de MySQL
  $dbname = "sql10736060";      // Nombre de tu base de datos
  $mensaje="error";
  $tipo="error";
  $loginExitoso=false;
  $enviomensaje=false;
  $id_Cliente=0;
  
  // Crear la conexión
  $conn = new mysqli($servername, $username, $password, $dbname);
  
  // Verificar la conexión
  if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
  }
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['action']) && $_POST['action']==='Login' ) {
            $email = $_POST['correoUsuario']; // Get user-entered email

    ///IMPLEMENTAR EL ALGORITMO HASH

                $contrasena = $_POST['passwordUsuario']; // Get user-entered password
            if (isset($_POST['correoUsuario']) && isset($_POST['passwordUsuario']) && !empty($email) && !empty($contrasena) ) {
                
                

    ///IMPLEMENTAR EL ALGORITMO HASH


                $consulta_verificacion = $conn->prepare("SELECT * FROM Cliente WHERE Correo_Cliente = ? AND Hash_Cliente = ?");
                $consulta_verificacion->bind_param("ss", $email, $contrasena);
                $consulta_verificacion->execute();
                $resultado_verificacion = $consulta_verificacion->get_result();

                if ($resultado_verificacion->num_rows == 0) {
                    // Correo electrónico o contraseña incorrectos
                
                    
                    imprimirAlerta("Correo electrónico o contraseña incorrectos","error");
            
                }else{
                    $cliente = $resultado_verificacion->fetch_assoc(); // Obtiene la fila como un array asociativo
                    $id_Cliente = $cliente['Id_Cliente'];
                    imprimirAlerta('Bienvenido','success');
                    
                    $loginExitoso = true;  
                    
                    
                }
            } else {
                    imprimirAlerta("Todos los campos son obligatorios.","error");
                    
                
            }
            
        }elseif(isset($_POST['action']) && $_POST['action']==='Registro'){
                
        if (isset($_POST['nombrenewUser']) && isset($_POST['correonewUser']) && isset($_POST['contranewPassword'])) {
            $nombre = $_POST['nombrenewUser'];
            $correo = $_POST['correonewUser'];
            $pass = $_POST['contranewPassword'];
            if (!empty($nombre) && !empty($correo) && !empty($pass)) {
                // Preparar la declaración
                    $stmt = $conn->prepare("SELECT * FROM Cliente WHERE Correo_Cliente = ?");
                    // Vincular el parámetro
                    $stmt->bind_param("s", $correo);
                    // Ejecutar la declaración
                    if ($stmt->execute()) {
                        // Obtener el resultado
                        $resultado = $stmt->get_result();
                        // Verificar si ya existe un registro con ese correo
                        if ($resultado->num_rows > 0) {
                            $mensaje="existe un cliente registrado con ese correo electrónico. Inicia Sesion";
                            $tipo="error";
                            imprimirAlerta("existe un cliente registrado con ese correo electrónico. Inicia Sesion","error");
                            
                                
                            // Redirigir al archivo principal
                            

                        } else {
                            $sql = $conn->prepare("INSERT INTO Cliente (Nombre_Cliente, Hash_Cliente, Correo_Cliente) VALUES (?, ?, ?)");
                            $sql->bind_param("sss", $nombre, $pass, $correo);
                            if ($sql->execute()) {
                                
                                
                                imprimirAlerta('Bienvenido a Alkostico, inicia sesión','error');
                                
                                

                            } else {
                                echo "Error: " . $sql->error;
                            }
                        }
                    }  
                } else {
                    
                    
                    imprimirAlerta("Todos los campos son obligatorios.","warning");
                }
            } else {
                imprimirAlerta("Todos los campos son obligatorios.","warning");
            }

        }
  } else {
    
    
  }
  

  if ($loginExitoso){
    session_start();
    $_SESSION['id'] = $id_Cliente;
    header("Location: Index.php");
    exit();

    }else{
        
        }
  ?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Audiowide">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
    crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <!--=============== FAVICON ===============-->
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">

    <!--=============== REMIXICONS ===============-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css">

    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
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
<?php 
    if(isset($_SESSION['alerta']) && !empty($_SESSION['alerta'])) {
        //print "xd";
    echo "<script>
        Swal.fire({
            title: 'Notificación',
            text: '" . $_SESSION['alerta']['mensaje'] . "',
            icon: '".  $_SESSION['alerta']['tipo'] . "',
            timer: 5000
        });
    </script>";
    
    // Eliminar el mensaje después de mostrarlo
    unset($_SESSION['alerta']);
}
    
    
    ?>
    
    <div class="">
        <div class="container contenedor-formulario">
              <div  >
                
                <form id="form-inicio" method="post">
                    <h1>Iniciar Sesión</h1>
                    <div>
                        <label class="form-label">Correo</label>
                        <i class='bx bxs-envelope'></i>
                        <input type="email" class="form-control" name="correoUsuario" id="correoUsuario" placeholder="Ejemplo@gmail.com">
                    </div>
                    <br>
                    <div >
                        <label class="form-label">Contraseña</label>
                        <i class='bx bxs-lock-alt'></i>
                        <input type="password" class="form-control" name="passwordUsuario" id="passwordUsuario" placeholder="*************">
                    </div>
                    <br>
                    <div>
                        <button class="btn btn-light" name="action" value="Login" type="submit" >Iniciar sesión</button>
                    </div>
                    
                    <div class="input-label">
                        <p>¿No tienes cuenta? <a href="" id="cambiarDisplay">Crea una</a></p>
                    </div>

                </form>
              </div>
              <div class="contenedor-formulario">
                
                <form id="form-registro" method="POST">
                <h1>Registrate</h1>
                    <div class="campo-form">
                        <label class="form-label">Nombre:</label>
                        <input type="text" class="form-control" name="nombrenewUser" id="nombrenewUser">
                    </div>
                    
                    <br>
                    <div class="campo-form">
                        <label class="form-label">Correo:</label>
                        <input type="email" class="form-control" name="correonewUser" id="correonewUser" placeholder="ejemplo@gmail.com">
                    </div>
                    <br>
                    <div class="campo-form">
                        <label class="form-label">Contraseña:</label>
                        <input type="password" class="form-control" name="contranewPassword" id="newPassword">
                    </div>
                    <br>
                    <div class="campo-form">
                        <button class="btn btn-light" name="action" value="Registro" type="submit" value="Registrar">Crear usuario</button>
                    </div>
                    
                    <div class="campo-pregunta ">
                        <p>¿Ya tienes una cuenta? <a href="#" id="cambiarDisplay2" >Inicia sesión</a></p>
                    </div>

                </form>


              </div>
        </div>

    

    </div>
    <script>
        var enlace = document.getElementById('cambiarDisplay');
        var forminicio = document.getElementById('form-inicio');   
        var enlace2= document.getElementById('cambiarDisplay2');
        var formcrear = document.getElementById('form-registro'); 
        // Asegúrate de que los valores de display estén definidos desde el principio
        forminicio.style.display = 'block'; // Mostrar el formulario de inicio al cargar la página
        formcrear.style.display = 'none';   // Ocultar el formulario de registro al cargar la página
        enlace.addEventListener('click', function(event) {
            event.preventDefault(); // Evita el comportamiento predeterminado del enlace
             
                if(forminicio.style.display==='block'){
                    forminicio.style.display='none';
                    formcrear.style.display='block';
                    
                }else{
                    formcrear.style.display='none';
                    forminicio.style.display='block';
                }
               
        });
        enlace2.addEventListener('click', function(event) {
            event.preventDefault(); // Evita el comportamiento predeterminado del enlace
             
                if(formcrear.style.display==='block'){
                    formcrear.style.display='none';
                    forminicio.style.display='block';
                    
                }else{
                    forminicio.style.display='none';
                    formcrear.style.display='block';
                }
               
        });
    </script>
    <!--=============== MAIN JS ===============-->
<script src="assets/js/main.js"></script>
    
    
    
    
</body>
</html>






























