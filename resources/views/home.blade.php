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
            padding: 10px;
            border-bottom: 1px solid #ddd;
            cursor: pointer;
        }
        .sidebar .contact:hover {
            background-color: #f9f9f9;
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
        .chat .input input {
            flex: 1;
            padding: 10px;
            border-radius: 20px;
            border: 1px solid #ddd;
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
                <h6 class="text-3xl font-bold mb-4">USUARIO: {{ $mobileNumber }}</h6>
            </div>
            <div class="search">
                <input type="text" placeholder="Buscar contacto">
            </div>
            <div class="contacts">
                <div class="contact">chats 1</div>
                <div class="contact">chats 2</div>
                <div class="contact">chats 3</div>
            </div>
            <div class="menu">
                <div class="menu-item" onclick="navigateTo('perfil', '{{ $mobileNumber }}')">Ver perfil</div>
                <div class="menu-item" onclick="navigateTo('contactos', '{{ $mobileNumber }}')">Ver contactos</div>
                <div class="menu-item" onclick="navigateTo('estados', '{{ $mobileNumber }}')">Estados</div>
                <div class="menu-item" onclick="navigateTo('welcome')">Cerrar sesión</div>
            </div>
        </div>
        <div class="chat col-md-8 p-0">
            <div class="header">Chat</div>
            <div class="messages">
                <div class="message sent">
                    <div class="content">Hola, ¿cómo estás?</div>
                </div>
                <div class="message received">
                    <div class="content">Bien, ¿y tú?</div>
                </div>
            </div>
            <div class="input">
                <input type="text" placeholder="Escribe un mensaje">
                <button>Enviar</button>
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
    
        function isMobileDevice() {
            return (typeof window.orientation !== "undefined") || (navigator.userAgent.indexOf('IEMobile') !== -1);
        }
    
        if (isMobileDevice()) {
            window.location.href = `{{ route('download') }}`;
        }
    </script>
</body>
</html>
