<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
    crossorigin="anonymous">
    
    <title>Document</title>
    
</head>
<body>
<?php
// Datos de conexión
$servername = "sql10.freemysqlhosting.net";  // Cambia esto si usas otro servidor
$username = "sql10736060";         // Tu usuario de MySQL
$password = "v3naSQAq5W";             // Tu contraseña de MySQL
$dbname = "sql10736060";      // Nombre de tu base de datos

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
  die("Conexión fallida: " . $conn->connect_error);
}

// Consulta para obtener los productos
$sql = "SELECT Nombre_Producto, Descripcion_Producto, Cantidad_Producto, Precio_Producto, URL_Producto FROM Producto";
$result = $conn->query($sql);

// Verificar si hay resultados
echo "<div class='container'>";
if ($result->num_rows > 0) {
    // Inicializamos un contador para controlar las filas
    $contador = 0;
    // Comenzamos la fila principal
    echo "<div class='row'>";
    // Generar una tarjeta Bootstrap por cada producto
    while ($row = $result->fetch_assoc()) {
        // Cada tarjeta ocupará espacio en la fila
        echo "
        <div class='col-12 col-sm-6 col-md-3 col-lg-3'>
            <div class='card w-95 h-95' style='margin-top: 20px;'>
                <img src='" . $row["URL_Producto"] . "' class='card-img-top' alt='Imagen de producto'>
                <div class='card-body'>
                <h5 class='card-title'>" . $row["Nombre_Producto"] . "</h5>
                <p class='card-text'>Cantidad disponible: " . $row["Cantidad_Producto"] . "</p>
                <p class='card-text'><strong>Precio: $" . $row["Precio_Producto"] . "</strong></p>
                <a href='#' class='btn btn-primary' onclick='agregarcarrito(\"" . htmlspecialchars($row["Nombre_Producto"], ENT_QUOTES) . "\", \"" . htmlspecialchars($row["Cantidad_Producto"], ENT_QUOTES) . "\", \"" . htmlspecialchars($row["Precio_Producto"], ENT_QUOTES) . "\", \"" . htmlspecialchars($row["URL_Producto"], ENT_QUOTES) . "\");'>Comprar</a>

                <!-- Formulario para enviar datos a otra página -->
                <form action='detallesProducto.php' method='POST'>
                    <input type='hidden' name='nombre' value='" . htmlspecialchars($row["Nombre_Producto"], ENT_QUOTES) . "'>
                    <input type='hidden' name='descripcion' value='" . htmlspecialchars($row["Descripcion_Producto"], ENT_QUOTES) . "'>
                    <input type='hidden' name='cantidad' value='" . htmlspecialchars($row["Cantidad_Producto"], ENT_QUOTES) . "'>
                    <input type='hidden' name='precio' value='" . htmlspecialchars($row["Precio_Producto"], ENT_QUOTES) . "'>
                    <input type='hidden' name='url' value='" . htmlspecialchars($row["URL_Producto"], ENT_QUOTES) . "'>
                    <button type='submit' class='btn btn-secondary mt-2'>Ver detalles</button>
                </form>
                </div>
            </div>
        </div>";

        // Incrementamos el contador
        $contador++;

        // Cada vez que llegamos a 4 productos, cerramos la fila y comenzamos una nueva
        if ($contador % 20 == 0) {
            //echo "</div><div class='row'>";
        }
    }

    // Cerramos la última fila si hay productos que mostrar
    echo "</div>";

} else {
    echo "<p>No se encontraron productos.</p>";
}
echo "</div>";

// Cerrar la conexión   
$conn->close();
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    var carrito=[]
    function agregarcarrito(nombre, cantidad ,precio,urlproducto) {
        
        Swal.fire({
            icon: "question",
            title: "Ingresa la cantidad de "+nombre,
            input: "number",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Confirmar"
            }).then((result) => {
            if (result.isConfirmed) {
                if (parseFloat(result.value)<=0 || parseFloat(result.value)>cantidad || (result.value.trim())===""){
                    Swal.fire({
                    title: "Cantidad no valida",
                    text: "Cantidad maxima:"+cantidad,
                    icon: "error"
                });
                }else{
                    carrito.push([nombre, result.value,precio,urlproducto]);
                    console.log("Nice bro");
                    Swal.fire({
                    title: nombre+ " añadido al carrito",
                    text: "Puedes acceder al carrito en la parte superior",
                    icon: "success"
                });

                }
                
            }else{
                Swal.fire("Keep calm, otra persona se quedara con "+nombre);

            }
        });
        
        
        
    }
</script>
</body>
</html>
