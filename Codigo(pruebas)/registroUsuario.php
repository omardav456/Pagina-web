<?php
        session_start();
        $servidor="sql10.freemysqlhosting.net";
        $nombre="sql10736060";
        $password="v3naSQAq5W";
        $db="sql10736060";
        // Si la consulta es exitosa
        $mensaje ;//Mensaje que se va a mostrar en el sweetalert
        $tipo ; // Puede ser 'success', 'error', 'warning', etc.
        $conexion = new mysqli($servidor,$nombre, $password, $db);
        if ($conexion->connect_error) {
            # code...
            echo "Error";
            die("Conexion fallida".$conexion->connect_error);

        }
            
        if (isset($_POST['nombrenewUser']) && isset($_POST['correonewUser']) && isset($_POST['contranewPassword'])) {
            $nombre = $_POST['nombrenewUser'];
            $correo = $_POST['correonewUser'];
            $pass = $_POST['contranewPassword'];
            if (!empty($nombre) && !empty($correo) && !empty($pass)) {
                // Preparar la declaración
                    $stmt = $conexion->prepare("SELECT * FROM Cliente WHERE Correo_Cliente = ?");
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
                            echo '
                                    <script>
                                    alert("Ya existe un cliente registrado con ese correo electrónico. Inicia Sesion");
                                    window.location = "indexlogin.php";
                                    </script>
                                ';
                            // Redirigir al archivo principal
                            

                        } else {
                            $sql = $conexion->prepare("INSERT INTO Cliente (Nombre_Cliente, Hash_Cliente, Correo_Cliente) VALUES (?, ?, ?)");
                            $sql->bind_param("sss", $nombre, $pass, $correo);
                            if ($sql->execute()) {
                                
                                $mensaje="Bienvenido a Alkostico, inicia sesión";
                                $tipo="sucess";
                                echo "
                                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                                <script>
                                Swal.fire({
                                    title: 'Notificación',
                                    text: '$mensaje',
                                    icon: '$tipo'
                                }).then(function() {
                                    window.location = 'index.php';
                                });
                                </script>";
                                exit;

                            } else {
                                echo "Error: " . $sql->error;
                            }
                        }
                    }  
                } else {
                    $mensaje="Todos los campos son obligatorios.";
                    $tipo="warning";
                    header('Location: ' . $_SERVER['HTTP_REFERER']);
                    echo "
                        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                            <script>
                                Swal.fire({
                                title: 'Notificación',
                                text: '$mensaje',
                                icon: '$tipo'
                            });
                        </script>";
                    
                    
                    
                }
            } else {
                
                //header('Location: ' . $_SERVER['HTTP_REFERER']);
                echo '
                         <script>
                            alert("Faltan datos del formulario.");
                            window.location = "indexlogin.php";
                        </script>
                    ';
                
                
                
            }
        
        
    
        $conexion->close();
        ?>