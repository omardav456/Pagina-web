<?php
session_start();
include 'funcionalidadFactura.php';


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Angkor&family=Arima:wght@100..700&family=Diplomata&family=Erica+One&family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Rubik+80s+Fade&family=Tilt+Prism&family=Ysabeau+SC:wght@1..1000&display=swap" rel="stylesheet">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Angkor&family=Arima:wght@100..700&family=Diplomata&family=Erica+One&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Paprika&family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Rubik+80s+Fade&family=Rubik:ital,wght@0,300..900;1,300..900&family=Tilt+Prism&family=Ysabeau+SC:wght@1..1000&display=swap" rel="stylesheet"></style>
</head>    
    <style>
     /* Estilos de la barra de navegación */
     .navbar {
            font-family: "Lato", sans-serif;
            font-weight: 100;
            background: black;
            width: 100%;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            padding: 0 20px;
        }

        .navbar {
            font-family: "Rubik", sans-serif;
            font-optical-sizing: auto;
            color: white;
            text-decoration: none;
            font-size: 18px;
        }

        .navbar:hover {
            color: #ddd;
        }

        .navbar .title {
            font-size: 24px;
            text-align: center;
            flex-grow: 1;
        }

    table{
        font-family: "Rubik", sans-serif;
        font-optical-sizing: auto;
        position: relative;
        top: 30px; /* 150px desde la parte superior */
        width: auto; /* Ajusta el tamaño de la tabla según el contenido */
        border-collapse: collapse; /* Eliminar espacios entre las celdas */
        border-collapse: collapse;
        margin: 50px auto; 
        margin-left: 20px;
        margin-bottom: 20px;
        background-color:rgba(255, 255, 255, 0.5); /* Color blanco con 80% de opacidad */;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); /* Añadir una sombra suave */
        border-radius: 0px; /* Bordes redondeados */
    }
    th, td {
        padding: 15px;
        text-align: left;
        border: 1px solid #ddd;
    }
    th {
        text-align:center;
        color: white;
        background: black;
    }
    img {
        max-width: 100px; /* Ajusta el tamaño de la imagen */
        height: auto;
    }

     /* Estilo para el contenedor principal del total */
     .total-container {
            font-family: "Rubik", sans-serif;
            font-optical-sizing: auto;
            width: 25%; /* Ajusta el ancho del total */
            margin-left: auto; /* Empuja el total hacia el lado derecho */
            position: relative;
            top: 0; /* Resetea la posición si no quieres margen desde arriba */
            align-self: flex-start; /* Alinea al inicio de la fila */
            padding: 20px;
            border: 2px solid #ddd; /* Borde alrededor del contenedor */
            border-radius: 10px; /* Bordes redondeados */
            background-color: #f9f9f9; /* Fondo claro */
            text-align: center; /* Centrar el texto */
            margin-bottom: 80px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Sombra suave */
        }



        /* Estilo para el título */
        .total-container h3 {

            font-family: "Rubik", sans-serif;
            font-optical-sizing: auto;
            margin-left: 20px;
            margin-bottom: 20px;
            margin: 0px;
            padding-bottom: 10px;
            font-size: 18px;
            color: #333; /* Color del texto */
        }

        /* Estilo para el valor del total */
        .total-value {
            font-family: "Rubik", sans-serif;
            font-optical-sizing: auto;
            padding: 15px;
            border: 2px solid black; /* Borde rojo alrededor del valor */
            background-color: white; /* Fondo claro en el recuadro del valor */
            color: black; /* Texto rojo */
            font-size: 24px;
            font-weight: bold;
            border-radius: 5px;
        }

        /*mensaje no hay productos*/ 
        .NHP {
            font-family: "Rubik", sans-serif;
            font-optical-sizing: auto;
            position: fixed;  /* Fija el elemento en su posición */
            left: 20px;       /* Posición desde el lado derecho de la pantalla */
            bottom: 250px; /*posicion desde la parte inferior */
            width: 50%;
            margin: 50px; /* Centrar el mensaje */
            padding: 50px;
            border: 2px solid #ddd;
            border-radius: 60px;
            background-color: #f9f9f9;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Sombra suave */
        }

        .NHP h2 {
         color: black; /* Color del texto */
        }

        /* Estilo del botón de pago */
.boton-pagar {
    margin-top: 5px;
    background-color: black;
    color: white;
    padding: 15px 30px;
    border: none;
    border-radius: 8px;
    font-size: 1em;
    cursor: pointer;
    transition: background-color 0.3s ease;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    cursor: pointer; /* Cambia el cursor a una mano cuando se pasa el mouse */
    transition: transform 0.3s ease; /* Suave animación al hacer hover */
}

.boton-pagar:hover {
    transform: scale(1.05); /* Efecto de agrandado al pasar el mouse */
    background-color: green;
}

.boton-pagar:active {
    background-color: #00408d;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    transform: translateY(2px);
}

        body {
            height: 100%; /* Asegura que el contenido ocupe toda la ventana si es necesario */
            margin: 0;
            padding: 0;
            background-color: #f5f5dc; /* Gris claro */
            background-size: cover; /* Asegura que la imagen cubra toda la pantalla */
            background-position: center; /* Centra la imagen en la pantalla */
            background-repeat: no-repeat; /* Evita que la imagen se repita */
            background-attachment: fixed; /* Mantiene la imagen fija cuando se desplaza */
            height: 100vh; /* Asegura que cubra toda la altura de la pantalla */
        }

       
.wrapper { 
    min-height: 100vh; /* Hace que el contenedor principal ocupe al menos el 100% de la altura de la pantalla */
    display: flex;
    flex-direction: column;
}

.content {
    flex: 1; /* Esto permite que el contenido principal ocupe el espacio disponible */
}

.footer {
    position: absolute;
    top: 600px;
    bottom: 0;
    left: 0;
    width: 100%;  /* Para que el footer ocupe todo el ancho de la pantalla */
    height: 100%;
    background: linear-gradient(to right, #87CEFA ,#6A5ACD, #191970); /* Color fondo del footer */ /* Cambia por el color que quieras usar */
    padding: 20px;
    text-align: center;
    z-index: 1000; /* Asegúrate de que el footer esté siempre visible encima de otros elementos */
}

.container {
    font-family: "Rubik", sans-serif;
    font-optical-sizing: auto;
  max-width: 1200px;
  margin: 0 auto;
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
}

.footer-section {
  flex: 1 1 200px; /* Cada columna ocupa espacio proporcional */
  margin: 10px;
}

.footer-section h3 {
  color:black;
  font-size: 16px;
  margin-bottom: 15px;
  font-weight: bold;
}

.footer-section ul {
  color:black;
  list-style: none;
}

.footer-section ul li {
  margin-bottom: 10px;
}

.footer-section ul li a {
  color:black;
  text-decoration: none;
  font-size: 14px;
}

.footer-section ul li a:hover {
  text-decoration: underline;
}

.footer-section.logo {
  display: flex;
  align-items: center;
  flex-direction: column;
}

.footer-section.logo img {
  font-family: "Erica One", sans-serif;
  font-weight: 400;
  width: 50px;
  margin-bottom: 10px;
}

.footer-bottom {
  font-family: "Erica One", sans-serif;
  font-weight: 400;
  color:black;
  text-align: center;
  margin-top: 30px;
  font-size: 14px;
  border-top: 1px solid #ffffff33; /* Línea de separación ligera */
  padding-top: 20px;
}

.footer-bottom p {
    color:black;
}

</style>

<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
</head>



<body>
    <?php
            $array=[1,2,3,4];
            if (!empty($array)) {   
            echo "<table border='1'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>#</th>";
            //echo "<th>Fecha</th>";
            echo "<th>Descripcion</th>";
            echo "<th>Metodo de pago</th>";
            echo "<th>Estado</th>";
            echo "<th>Total</th>";
            echo "<th>Imprimir Factura </th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
           $i=0;
           $array=consultarFacturas(intval( $_SESSION['id']));
            foreach ($array as $factura) {
                $i++;
                echo "<tr>";
                echo "<td>" . ($i) . "</td>";
                echo "<td>";

                // Dividir la cadena en productos, separando por "ID:"
                $productos = preg_split('/(?=ID:)/', $factura['Productos_Factura']);

                // Iterar sobre los productos, comenzando desde el segundo elemento si el primero es vacío
                foreach ($productos as $producto) {
                    $producto = trim($producto); // Limpiar los posibles espacios en blanco
                    if (!empty($producto)) { // Ignorar elementos vacíos
                        echo "<p>--" . htmlspecialchars($producto) . "</p>";
                    }
                }

                echo "</td>";
                
                echo "<td>".htmlspecialchars($factura['Metodo_Pago'])."</td>";
                echo "<td>".htmlspecialchars($factura['Estado_Factura'])."</td>";
                echo "<td>".htmlspecialchars($factura['Total_Factura'])."</td>";
                echo "<td>";
                echo'<form action="generar_pdf.php" method="post" style="display:inline;">
                        <input type="hidden" name="Id_Factura" value='.$factura['Id_Factura'].'">
                        <button type="submit">Ver Factura</button>';
                echo"</form>";
                echo "</td>";/*
                echo "<td id='price-" . $producto['Id_Producto'] . "'>" . number_format($producto['Precio_Producto'], 2, ',', '.') . " COP</td>"; // Precio formateado
                echo "<td id='total-" . $producto['Id_Producto'] . "'>" . number_format($producto['Precio_Producto'] * $producto['Cantidad_Carrito'], 2, ',', '.') . " COP</td>"; // Total por producto
                echo "</tr>";*/
          }
            // Botones de agregar y quitar
            echo "</tbody>";
            echo "</table>";
            } else {
                echo "<div class='NHP'>";
                echo "<h2>Todavía no hay productos</h2>";
                 echo "</div>";
            }
            
          
        ?>
        
    </div>    
</body>
</html>