<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Mensajes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
        }
        h2 {
            text-align: center;
            color: #075e54;
            margin-top: 20px;
        }
        #consultaMensajesForm {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            font-weight: bold;
            color: #075e54;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0 15px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button[type="submit"] {
            background-color: #25d366;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            display: inline-block;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        button[type="submit"]:hover {
            background-color: #128c7e;
        }
        #mensajesContainer {
            max-width: 600px;
            margin: 20px auto;
        }
        .mensaje {
            margin: 10px;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            clear: both;
            padding: 10px;
            position: relative;
        }
        .mensaje p {
            margin: 5px 0;
        }
        .mensaje-propio {
            margin-left: 20%; /* Ajuste del margen para los mensajes propios */
            background-color: #dcf8c6; /* Color de fondo para mensajes propios */
        }
        .mensaje-receptor {
            margin-right: 20%; /* Ajuste del margen para los mensajes del receptor */
            background-color: #e2e2e2; /* Color de fondo para mensajes del receptor */
        }
        .mensaje .nombre {
            font-weight: bold;
            color: #128c7e;
            margin-right: 10px;
        }
        .mensaje .fecha {
            font-size: 0.8em;
            color: #888888;
            position: absolute;
            bottom: 5px;
            right: 10px;
        }
        .mensaje .mensaje-texto {
            margin-top: 5px;
        }
        .mensaje .imagen {
            max-width: 100%;
            border-radius: 10px;
            margin-top: 10px;
        }
        .clearfix {
            clear: both;
        }
    </style>
</head>
<body>
    <h2>Consulta de Mensajes</h2>
    <form id="consultaMensajesForm" action="http://gigrowi.blr.dom.my.id/api/mensajes" method="POST">
        <label for="numero_origen">Número de Origen:</label><br>
        <input type="text" id="numero_origen" name="numero_origen" required><br><br>
        
        <label for="numero_destino">Número de Destino:</label><br>
        <input type="text" id="numero_destino" name="numero_destino" required><br><br>
        
        <button type="submit">Consultar Mensajes</button>
    </form>

    <div id="mensajesContainer">
        <!-- Aquí se mostrarán los mensajes consultados -->
    </div>

    <script>
        const form = document.getElementById('consultaMensajesForm');
        const mensajesContainer = document.getElementById('mensajesContainer');

        form.addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData,
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la solicitud: ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                mostrarMensajes(data);
            })
            .catch(error => {
                mensajesContainer.innerHTML = `<p>Error: ${error.message}</p>`;
            });
        });

        function mostrarMensajes(data) {
            mensajesContainer.innerHTML = ''; // Limpiamos el contenedor

            if (data.mensajes && data.mensajes.length > 0) {
                data.mensajes.forEach(mensaje => {
                    const esMensajePropio = mensaje.es_propio; // Asumiendo que tenemos un campo que indica si es el mensaje propio o no
                    const mensajeHTML = `
                        <div class="mensaje ${esMensajePropio ? 'mensaje-propio' : 'mensaje-receptor'}">
                            <p><span class="nombre">${mensaje.nombre_origen}</span><span class="fecha">${mensaje.created_at}</span></p>
                            <p class="mensaje-texto">${mensaje.mensaje}</p>
                            ${mensaje.foto_ruta ? `<img class="imagen" src="${mensaje.foto_ruta}" alt="Foto adjunta">` : ''}
                        </div>
                    `;
                    mensajesContainer.innerHTML += mensajeHTML;
                });
            } else {
                mensajesContainer.innerHTML = `<p>No se encontraron mensajes</p>`;
            }
        }
    </script>
</body>
</html>
