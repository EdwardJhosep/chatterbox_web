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
            <div class="contacts">
                <div class="header">Contactos</div>
                <div id="contactList"></div>
            </div>
        </div>
        <div class="chat col-md-8 p-0">
            <div class="header">Agregar Contacto</div>
            <div class="text-center my-4">
                <button class="btn btn-primary" onclick="showForm()">Agregar Contacto</button>
            </div>
            <div class="container hidden" id="contactFormContainer">
                <form id="contactForm" class="p-4">
                    <input type="hidden" id="userNumber" value="{{ $mobileNumber }}">
                    <div class="form-group">
                        <label for="contactNumber">Número de Teléfono del Contacto</label>
                        <input type="text" class="form-control" id="contactNumber" placeholder="Número de teléfono del contacto" pattern="[0-9]{9}" title="Debe ser un número de 9 dígitos">
                        <small id="contactNumberError" class="text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label for="contactName">Nombre del Contacto</label>
                        <input type="text" class="form-control" id="contactName" placeholder="Nombre del contacto">
                        <small id="contactNameError" class="text-danger"></small>
                    </div>
                    <button type="button" class="btn btn-success" onclick="addContact()">Guardar Contacto</button>
                </form>
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

        function showForm() {
            document.getElementById('contactForm').reset(); // Reset form fields
            document.getElementById('contactFormContainer').classList.toggle('hidden');
            if (!document.getElementById('contactFormContainer').classList.contains('hidden')) {
                fetchContacts(); // Fetch contacts when the form is shown
            }
        }
        
        function addContact() {
            const userNumber = document.getElementById('userNumber').value;
            const contactNumber = document.getElementById('contactNumber').value;
            const contactName = document.getElementById('contactName').value;

            // Reset previous error messages
            document.getElementById('contactNumberError').textContent = '';
            document.getElementById('contactNameError').textContent = '';

            // Validar el número de teléfono
            if (!contactNumber.match(/^\d{9}$/)) {
                document.getElementById('contactNumberError').textContent = 'El número de teléfono debe ser exactamente 9 dígitos.';
                return;
            }

            // Validar el nombre del contacto
            if (!contactName.trim()) {
                document.getElementById('contactNameError').textContent = 'El nombre del contacto no puede estar vacío.';
                return;
            }

            // Call the API to add contact
            fetch('https://cirjoco.nyc.dom.my.id/api/agregarcontacto', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    numeroactual: userNumber,
                    numeroagregado: contactNumber,
                    nombre: contactName, // Incluir el nombre del contacto en la solicitud
                }),
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al agregar contacto');
                }
                return response.json();
            })
            .then(data => {
                alert(data.message); // Show success message
                fetchContacts(); // Refresh contacts list
                document.getElementById('contactForm').reset(); // Reset form fields
                document.getElementById('contactFormContainer').classList.add('hidden'); // Hide form container
            })
            .catch(error => {
                alert('Error al agregar contacto: ' + error.message);
            });
        }

        function fetchContacts() {
            const userNumber = document.getElementById('userNumber').value;

            // Call the API to fetch contacts
            fetch(`https://cirjoco.nyc.dom.my.id/api/mostarcontacto?numeroactual=${encodeURIComponent(userNumber)}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al obtener contactos');
                }
                return response.json();
            })
            .then(data => {
                displayContacts(data.contactos);
            })
            .catch(error => {
                alert('Error al obtener contactos: ' + error.message);
            });
        }

        function displayContacts(contacts) {
            const contactList = document.getElementById('contactList');
            contactList.innerHTML = '';
            contacts.forEach(contact => {
                const contactItem = document.createElement('div');
                contactItem.classList.add('contact-item');
                contactItem.innerHTML = `
                    <span>${contact.nombre}</span>
                    <span>${contact.numeroagregado}</span>
                    <button class="btn btn-sm btn-danger ml-2" onclick="eliminarContacto('${contact.numeroagregado}')">Eliminar</button>
                `;
                contactList.appendChild(contactItem);
            });
        }

        function eliminarContacto(numeroagregado) {
            const userNumber = document.getElementById('userNumber').value;

            if (confirm('¿Estás seguro de eliminar este contacto?')) {
                // Call the API to delete contact
                fetch('https://cirjoco.nyc.dom.my.id/api/eliminarcontacto', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        numeroactual: userNumber,
                        numeroagregado: numeroagregado,
                    }),
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error al eliminar contacto');
                    }
                    return response.json();
                })
                .then(data => {
                    alert(data.message); // Show success message
                    fetchContacts(); // Refresh contacts list
                })
                .catch(error => {
                    alert('Error al eliminar contacto: ' + error.message);
                });
            }
        }

        // Fetch contacts initially
        fetchContacts();
    </script>
</body>
</html>

