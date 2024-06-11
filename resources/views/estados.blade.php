<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enviar Mensaje</title>
</head>
<body>
    <form id="mensajeForm" enctype="multipart/form-data" method="post">
        <label for="numero_origen">Número de Origen:</label>
        <input type="text" id="numero_origen" name="numero_origen" required><br>

        <label for="numero_destino">Número de Destino:</label>
        <input type="text" id="numero_destino" name="numero_destino" required><br>

        <label for="mensaje">Mensaje:</label>
        <textarea id="mensaje" name="mensaje" required></textarea><br>

        <label for="foto">Foto (opcional):</label>
        <input type="file" id="foto" name="foto" accept="image/jpeg, image/png"><br>

        <label for="video">Video (opcional):</label>
        <input type="file" id="video" name="video" accept="video/mp4"><br>

        <button type="submit">Enviar Mensaje</button>
    </form>

    <script>
        document.getElementById('mensajeForm').addEventListener('submit', async function(event) {
            event.preventDefault();
            const form = event.target;
            const formData = new FormData(form);

            try {
                const response = await fetch('https://yiyzolo.nyc.dom.my.id/api/enviar-mensaje', {
                    method: 'POST',
                    body: formData,
                });

                const result = await response.json();

                if (response.ok) {
                    alert('Mensaje enviado correctamente');
                } else {
                    alert('Error: ' + result.message);
                }
            } catch (error) {
                alert('Error: ' + error.message);
            }
        });
    </script>
</body>
</html>
