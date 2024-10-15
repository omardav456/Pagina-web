window.onscroll = function() {
    const navbar = document.querySelector('.navbar');
    
    if (document.body.scrollTop > 10 || document.documentElement.scrollTop > 10) {
      navbar.classList.add('bg-light'); // Agregar clase al hacer scroll
      //navbar.classList.add('bg-body-tertiary'); // Agregar clase al hacer scroll
    } else {
      navbar.classList.remove('navbar-dark'); // Remover clase cuando vuelve al top
      navbar.classList.remove('bg-black'); // Remover clase cuando vuelve al top
    }
  };

  //Agregar al carri
  var carrito=[]
  var cantidadIngresada;
  function agregarcarrito(nombre, cantidad ,precio,urlproducto) {
      
    Swal.fire({
      icon: "question",
      title: "Ingresa la cantidad de " + nombre,
      input: "number",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Confirmar"
  }).then((result) => {
      if (result.isConfirmed) {
          cantidadIngresada = result.value;

          // Validar si la cantidad ingresada es válida
          if (parseFloat(cantidadIngresada) <= 0 || parseFloat(cantidadIngresada) > cantidad || (cantidadIngresada.trim()) === "") {
              Swal.fire({
                  title: "Cantidad no válida",
                  text: "Cantidad máxima: " + cantidad,
                  icon: "error"
              });
          } else {
              var encontrado = false;

              // Buscar si el producto ya está en el carrito
              for (let index = 0; index < carrito.length; index++) {
                  var element = carrito[index][0];

                  // Si el producto ya está en el carrito
                  if (element === nombre) {
                      encontrado = true;
                      // Validar si se supera la cantidad disponible
                      if ((parseFloat(carrito[index][1]) + parseFloat(cantidadIngresada)) > cantidad) {
                          Swal.fire("Superas la cantidad máxima del producto: " + nombre);
                      } else {
                          // Actualizar la cantidad del producto en el carrito
                          carrito[index][1] = parseFloat(carrito[index][1]) + parseFloat(cantidadIngresada);
                          Swal.fire({
                              title: nombre + " añadido al carrito",
                              text: "Puedes acceder al carrito en la parte superior",
                              icon: "success"
                          });
                          enviarDatos();
                      }
                      break; // Salir del bucle una vez encontrado
                  }
              }

              // Si no se encontró el producto en el carrito, lo añadimos
              if (!encontrado) {
                  carrito.push([nombre, parseFloat(cantidadIngresada), precio, urlproducto]);
                  Swal.fire({
                      title: nombre + " añadido al carrito",
                      text: "Puedes acceder al carrito en la parte superior",
                      icon: "success"
                  });
                  enviarDatos();
              }
          }
      } else {
          Swal.fire("Keep calm, otra persona se quedará con " + nombre);
      }
  });
        
  }
  


// Calcular precio automaticamente
  function calcular(cantidad, multiplicador) {
        
    const resultado = document.getElementById("subtotal");
    resultado.textContent = "$"+ (multiplicador*cantidad);
}
// Enviar datos del carrito a PHP
function enviarDatos() {
  if (carrito.length > 0) {
      fetch('carrito.php', {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json'
          },
          body: JSON.stringify({ lista: carrito }) // Convertir la lista a JSON
      })
      .then(response => response.text())
      .then(data => {
          console.log("Respuesta del servidor:", data);
          alert("Lista enviada con éxito");
      })
      .catch(error => {
          console.error("Error al enviar la lista:", error);
      });
  }
}
