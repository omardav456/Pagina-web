
<?php
session_start();
  include 'funcionalidadCupones.php';

    echo "<script>
        alert('Hola ".intval( $_SESSION['id'])."');
            
              
        </script>";
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['AgregarCupon'])) {
          if(intval( $_SESSION['id'])===0){
            $_SESSION['fake']=true;
          }else{
            agregarCupon(intval( $_SESSION['id']), 1);
            echo "<script>
            alert('Hola ".intval( $_SESSION['id'])."');
            
              
            </script>";

          }
          
      }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h1>Evento xd</h1>
<form action="" method="post">
    <input type='hidden' name='AgregarCupon' value="1">
    <button>Ganar descuento</button>    
</form>
</body>
</html>
