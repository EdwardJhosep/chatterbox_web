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
        .sidebar .search {
            padding: 10px;
            background-color: #fff;
            border-bottom: 1px solid #ddd;
        }
        .sidebar .search input {
            width: 100%;
            padding: 10px;
            border-radius: 20px;
            border: 1px solid #ddd;
        }
        .sidebar .contacts {
            flex: 1;
            overflow-y: auto;
        }
        .sidebar .contact {
            display: flex;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #ddd;
            cursor: pointer;
        }
        .sidebar .contact:hover {
            background-color: #f9f9f9;
        }
        .sidebar .contact img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
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
        .chat .header .contact-info {
            font-size: 16px;
        }
        .chat .messages {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            background-color: #e5ddd5;
        }
        .chat .messages .message {
            margin-bottom: 15px;
        }
        .chat .messages .message .content {
            max-width: 70%;
            padding: 10px;
            border-radius: 5px;
            background-color: #fff;
            position: relative;
        }
        .chat .messages .message.sent .content {
            background-color: #dcf8c6;
            margin-left: auto;
        }
        .chat .messages .message .content::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            border-width: 5px;
            border-style: solid;
            border-color: #fff transparent transparent #fff;
        }
        .chat .messages .message.sent .content::after {
            right: auto;
            left: 0;
            border-color: #dcf8c6 transparent transparent #dcf8c6;
        }
        .chat .input {
            padding: 10px;
            background-color: #f0f0f0;
            display: flex;
        }
        .chat .input input[type="text"] {
            flex: 1;
            padding: 10px;
            border-radius: 20px;
            border: 1px solid #ddd;
            margin-right: 10px;
        }
        .chat .input input[type="file"] {
            margin-right: 10px;
        }
        .chat .input button {
            padding: 10px 20px;
            border: none;
            border-radius: 20px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar col-md-4 p-0">
            <div class="header">Chatterbox</div>
            <div class="text-center">
                <h6 class="text-3xl font-bold mb-4">Número de origen: {{ $mobileNumber }}</h6>
            </div>
            <div class="search">
                <input type="text" placeholder="Buscar contacto">
            </div>
            <div class="contacts" id="contactList">
                <!-- Aquí se insertarán dinámicamente los contactos -->
            </div>
            <div class="menu">
                <div class="menu-item" onclick="navigateTo('perfil', '{{ $mobileNumber }}')">Ver perfil</div>
                <div class="menu-item" onclick="navigateTo('contactos', '{{ $mobileNumber }}')">Ver contactos</div>
                <div class="menu-item" onclick="navigateTo('estados', '{{ $mobileNumber }}')">Estados</div>
                <div class="menu-item" onclick="navigateTo('welcome')">Cerrar sesión</div>
            </div>
        </div>
        <div class="chat col-md-8 p-0">
            <div class="header">
                Chat
                <div class="contact-info"></div>
            </div>
            <div class="messages">
                <!-- Aquí se insertarán dinámicamente los mensajes -->
            </div>
            <div class="input">
                <input type="text" id="messageInput" placeholder="Escribe un mensaje">
                <input type="file" id="fileInput" accept="image/jpeg">
                <button onclick="sendMessage()">Enviar</button>
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

        // Función para obtener y mostrar los contactos
        function fetchContacts() {
            const userNumber = '{{ $mobileNumber }}'; // Obtener el número de teléfono del usuario

            fetch(`http://gigrowi.blr.dom.my.id/api/mostarcontacto?numeroactual=${encodeURIComponent(userNumber)}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al obtener contactos');
                }
                return response.json();
            })
            .then(data => {
                displayContacts(data.contactos); // Mostrar los contactos en la barra lateral
            })
            .catch(error => {
                console.error('Error al obtener contactos:', error);
                alert('Error al obtener contactos: ' + error.message);
            });
        }

        function displayContacts(contacts) {
            const contactList = document.getElementById('contactList');
            contactList.innerHTML = ''; // Limpiar la lista de contactos

            contacts.forEach(contact => {
                const contactDiv = document.createElement('div');
                contactDiv.classList.add('contact');

                // Incluir imagen del avatar y detalles del contacto
                contactDiv.innerHTML = `
                    <img src="${contact.user.avatar}" alt="${contact.nombre}">
                    <div>
                        <strong>${contact.nombre}</strong><br>
                        ${contact.numeroagregado}
                    </div>
                `;
                
                // Agregar evento click para cargar el chat del contacto
                contactDiv.addEventListener('click', () => {
                    loadChat(contact);
                });

                contactList.appendChild(contactDiv);
            });
        }

        function loadChat(contact) {
            // Actualizar el encabezado del chat con el nombre y número del contacto
            const contactInfoDiv = document.querySelector('.chat .header .contact-info');
            contactInfoDiv.textContent = `${contact.nombre} - ${contact.numeroagregado}`;

            // Limpiar el campo de entrada de mensaje
            const messageInput = document.getElementById('messageInput');
            messageInput.value = '';

            // Limpiar los mensajes del chat
            const messagesDiv = document.querySelector('.chat .messages');
            messagesDiv.innerHTML = '';

            // Aquí podrías añadir lógica para cargar mensajes reales del chat con este contacto
        }

        // Función para enviar un mensaje
        function sendMessage() {
            const messageInput = document.getElementById('messageInput');
            const fileInput = document.getElementById('fileInput');
            const userNumber = '{{ $mobileNumber }}';
            const contactNumber = document.querySelector('.chat .header .contact-info').textContent.split(' - ')[1];

            const formData = new FormData();
            formData.append('numero_origen', userNumber);
            formData.append('numero_destino', contactNumber);
            formData.append('mensaje', messageInput.value);

            // Verificar si se ha seleccionado un archivo y agregarlo al FormData
            if (fileInput.files.length > 0) {
                const file = fileInput.files[0];
                
                if (file.type === 'image/jpeg') {
                    formData.append('foto', file); // Ajustar el nombre del campo según el backend
                } else {
                    alert('Tipo de archivo no compatible. Por favor, seleccione una imagen JPEG.');
                    return;
                }
            }

            fetch('http://gigrowi.blr.dom.my.id/api/enviar-mensaje', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al enviar el mensaje');
                }
                return response.json();
            })
            .then(data => {
                // Actualizar la interfaz de usuario con el nuevo mensaje enviado
                const messagesDiv = document.querySelector('.chat .messages');
                const messageDiv = document.createElement('div');
                messageDiv.classList.add('message', 'sent');
                const contentDiv = document.createElement('div');
                contentDiv.classList.add('content');
                contentDiv.textContent = messageInput.value;
                messageDiv.appendChild(contentDiv);
                messagesDiv.appendChild(messageDiv);

                // Limpiar el campo de entrada
                messageInput.value = '';
                fileInput.value = '';
            })
            .catch(error => {
                console.error('Error al enviar el mensaje:', error);
                alert('Error al enviar el mensaje: ' + error.message);
            });
        }

        fetchContacts();
    </script>
</body>
</html>
