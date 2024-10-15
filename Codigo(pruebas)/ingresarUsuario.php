
<?php

$servidor="sql10.freemysqlhosting.net"; 
$nombre="sql10736060";  
$password="v3naSQAq5W"; 
$db="sql10736060";
$conexion = new mysqli($servidor,$nombre, $password, $db);

if (!$conexion) {
    echo 'Error al conectar con la base de datos: ' . mysqli_connect_error();
    exit;
}

$email = $_POST['correoUsuario']; // Get user-entered email

///IMPLEMENTAR EL ALGORITMO HASH

$contrasena = $_POST['passwordUsuario']; // Get user-entered password

$consulta_verificacion = $conexion->prepare("SELECT * FROM Cliente WHERE Correo_Cliente = ? AND Hash_Cliente = ?");
$consulta_verificacion->bind_param("ss", $email, $contrasena);
$consulta_verificacion->execute();
$resultado_verificacion = $consulta_verificacion->get_result();

if ($resultado_verificacion->num_rows == 0) {
    // Correo electrónico o contraseña incorrectos
    
    echo "<script>
        alert('Correo electrónico o contraseña incorrectos');
        window.location = 'indexlogin.php';
            
              
        </script>";
    
    
    
   exit;
}


// Inicio de sesión exitoso
$_SESSION['Nombre'] = $row['Nombre_Cliente'];


mysqli_close($conexion);
header('Location: Index.php');
echo '
    <script>
        alert("Inicio de sesión exitoso."); 
        
    </script>
';
exit;

?>
