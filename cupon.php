<?php

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 20px;
        }
        /* Checkbox personalizado */
        .checkbox-wrapper-46 input[type="checkbox"] {
            display: none;
            visibility: hidden;
        }

        .checkbox-wrapper-46 .cbx {
            display: flex;
            align-items: center;
            cursor: pointer;
            margin: 10px 0;
        }
        .checkbox-wrapper-46 .cbx span {
            display: flex;
            align-items: center;
            margin-right: 10px;
        }
        .checkbox-wrapper-46 .cbx span:first-child {
            width: 18px;
            height: 18px;
            border: 1px solid #9098a9;
            border-radius: 3px;
            position: relative;
            transition: all 0.2s ease;
        }
        .checkbox-wrapper-46 .cbx span:first-child svg {
            position: absolute;
            top: 3px;
            left: 2px;
            fill: none;
            stroke: #ffffff;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
            stroke-dasharray: 16px;
            stroke-dashoffset: 16px;
            transition: all 0.3s ease;
            transition-delay: 0.1s;
        }
        .checkbox-wrapper-46 .inp-cbx:checked + .cbx span:first-child {
            background: #506eec;
            border-color: #506eec;
        }
        .checkbox-wrapper-46 .inp-cbx:checked + .cbx span:first-child svg {
            stroke-dashoffset: 0;
        }

        /* Estilo de la tarjeta */
        .card {
            box-sizing: border-box;
            width: 90%; /* Ancho completo */
            max-width: 600px;
            height: 60px;
            background: rgba(63, 255, 5, 0.58);
            border: 1px solid white;
            box-shadow: 12px 17px 51px rgba(0, 0, 0, 0.22);
            backdrop-filter: blur(6px);
            border-radius: 17px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.2em;
            color: black;
            transition: all 0.5s;
            padding: 10px; /* Padding para que no se vea pegado */
        }

        .card:hover {
            border: 1px solid black;
            transform: scale(1.05);
        }

        .card:active {
            transform: scale(0.95) rotateZ(1.7deg);
        }
        
        /* Estilo del texto adicional */
        .validity {
            font-size: 0.8em; /* Tamaño más pequeño */
            color: #ff0000; /* Color rojo para destacar */
            margin-top: 40px; /* Espacio superior */
            margin-left: 10px;
        }
        hr {
            width: 100%; /* Ancho completo */
            max-width: 650px;
            border: 0;
            height: 2px;
            background: #ccc; /* Color de la línea */
            margin: 30px 0; /* Espacio arriba y abajo de la línea */
        }
    </style>
<body>
<div class="container">
        <div class="row">
            <h2 style="width: 90%; /* Ancho completo */
            max-width: 600px;">Lista de cupones</h2>
            <hr>
        </div>
        <div class="row">
            <div class="col">
                <div class="checkbox-wrapper-46">
                    <input type="checkbox" name="options" id="cbx-46" class="inp-cbx" />
                    <label for="cbx-46" class="cbx">
                        <span>
                            <svg viewBox="0 0 12 10" height="10px" width="12px">
                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                            </svg>
                        </span>
                        <span class="card">
                            Cupon: $2000 valido 
                            <p class="validity">Válido hasta: 12/08/2001</p>
                            
                        </span>
                    </label>
                </div>
            </div>
        </div>
    </div>
    
    <script src="scriptcupon.js"></script>
    <script>
        const checkboxes = document.querySelectorAll('.inp-cbx');

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    checkboxes.forEach(other => {
                        if (other !== this) {
                            other.checked = false;
                        }
                    });
                }
            });
        });
    </script>

</body>
</html>