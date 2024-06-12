<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chatterbox</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ededed;
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            display: flex;
            flex-direction: column;
            height: 90vh;
            width: 90%;
            max-width: 1200px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 10px;
            overflow: hidden;
        }
        @media (min-width: 768px) {
            .container {
                flex-direction: row;
            }
        }
        .sidebar {
            background-color: #f0f0f0;
            border-right: 1px solid #ddd;
            display: flex;
            flex-direction: column;
        }
        .sidebar .header {
            padding: 20px;
            background-color: #007bff;
            color: white;
            text-align: center;
            font-size: 20px;
        }
        .sidebar .menu {
            padding: 10px;
            background-color: #f0f0f0;
            border-top: 1px solid #ddd;
        }
        .sidebar .menu .menu-item {
            padding: 10px;
            cursor: pointer;
        }
        .sidebar .contacts {
            padding: 10px;
            overflow-y: auto;
        }
        .sidebar .contact-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        .sidebar .contact-item:hover {
            background-color: #f9f9f9;
        }
        .chat {
            display: flex;
            flex-direction: column;
            flex: 1;
        }
        .chat .header {
            padding: 20px;
            background-color: #ff7f00;
            color: white;
            font-size: 20px;
        }
        .chat .estados {
            padding: 20px;
            overflow-y: auto;
        }
        .chat .estado {
            display: flex;
            margin-bottom: 20px;
        }
        .chat .estado .estado-info {
            flex: 1;
        }
        .chat .estado .estado-image {
            width: 100px; /* Ajusta el tamaño de la imagen */
            height: 100px; /* Ajusta el tamaño de la imagen */
            margin-left: 20px;
            border-radius: 50%;
            overflow: hidden;
        }
        .chat .estado .estado-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .chat .subir-estado {
            margin-top: auto;
            padding: 20px;
            background-color: #f0f0f0;
            text-align: center;
        }
        .chat .subir-estado input[type=file] {
            display: none;
        }
        .chat .subir-estado label {
            display: inline-block;
            cursor: pointer;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
        }
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar col-md-4 p-0">
            <div class="header">Chatterbox</div>
            <div class="text-center">
                <h6 class="text-3xl font-bold mb-4">{{ $mobileNumber }}</h6>
            </div>
            <div class="menu">
                <div class="menu-item" onclick="navigateTo('home', '{{ $mobileNumber }}')">Mensajes</div>
                <div class="menu-item" onclick="navigateTo('perfil', '{{ $mobileNumber }}')">Ver perfil</div>
                <div class="menu-item" onclick="navigateTo('estados', '{{ $mobileNumber }}')">Estados</div>
                <div class="menu-item" onclick="navigateTo('welcome')">Cerrar sesión</div>
            </div>
        </div>
        <div class="chat col-md-8 p-0">
            <div class="header">ESTADOS</div>
            <div class="estados">
                <div class="estado">
                    <div class="estado-info">
                        <h5>Nombre del contacto</h5>
                        <p>Última vez hoy</p>
                    </div>
                    <div class="estado-image">
                        <img src="https://via.placeholder.com/100" alt="Estado">
                    </div>
                </div>
                <div class="estado">
                    <div class="estado-info">
                        <h5>Otro contacto</h5>
                        <p>Última vez ayer</p>
                    </div>
                    <div class="estado-image">
                        <img src="https://via.placeholder.com/100" alt="Estado">
                    </div>
                </div>
                <!-- Repite este bloque para cada estado -->
            </div>
            <div class="subir-estado">
                <input type="file" id="estadoFile" accept="image/*">
                <label for="estadoFile">Subir Estado</label>
            </div>
        </div>
    </div>
    <script>
        function navigateTo(page, mobileNumber = '') {
            let url = '';
            switch(page) {
                case 'perfil':
                    url = `{{ route('perfil', ['mobileNumber' => 'MOBILE_NUMBER']) }}`;
                    break;
                case 'contactos':
                    url = `{{ route('contactos', ['mobileNumber' => 'MOBILE_NUMBER']) }}`;
                    break;
                case 'home':
                    url = `{{ route('home', ['mobileNumber' => 'MOBILE_NUMBER']) }}`;
                    break;
                case 'estados':
                    url = `{{ route('estados', ['mobileNumber' => 'MOBILE_NUMBER']) }}`;
                    break;
                case 'welcome':
                    url = `{{ route('welcome') }}`;
                    break;
                case 'download':
                    url = `{{ route('download') }}`;
                    break;
                default:
                    break;
            }
            if (mobileNumber) {
                url = url.replace('MOBILE_NUMBER', mobileNumber);
            }
            window.location.href = url;
        }
        function fetchContacts() {
            // Función para cargar los contactos (si es necesario)
        }
        document.getElementById('estadoFile').addEventListener('change', function() {
            // Aquí puedes agregar la lógica para subir el estado
            const file = this.files[0];
            if (file) {
                // Aquí puedes manejar la subida del estado
                console.log('Subiendo archivo:', file);
                // Por ejemplo, podrías usar fetch para subir la imagen al servidor
            }
        });
    </script>
</body>
</html>
