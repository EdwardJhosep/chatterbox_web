<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome to Chatterbox</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ededed;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 40px;
            width: 90%;
            max-width: 400px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-control {
            border-radius: 25px;
            padding: 15px;
            height: 50px;
            font-size: 16px;
        }
        .btn-primary {
            background-color: #25D366;
            border-color: #25D366;
            border-radius: 25px;
            padding: 12px 20px;
            font-size: 16px;
            width: 100%;
        }
        .btn-primary:hover {
            background-color: #128C7E;
            border-color: #128C7E;
        }
        .signup-link {
            text-align: center;
            margin-top: 15px;
        }
        .signup-link a {
            color: #25D366;
            cursor: pointer;
        }
        .signup-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-4">Chatterbox</h2>
        <div id="login-form">
            <form id="loginForm" action="https://cirjoco.nyc.dom.my.id/api/login" method="post">
                <div class="form-group">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Correo electrónico" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
                </div>
                <button type="submit" class="btn btn-primary">Iniciar sesión</button>
                <div class="signup-link mt-3">
                    <p>¿No tienes cuenta? <a id="signup-link" onclick="toggleForms()">Crear una cuenta</a></p>
                </div>
            </form>
        </div>
        <div id="signup-form" style="display: none;">
            <form id="registerForm" action="https://cirjoco.nyc.dom.my.id/api/register" method="post">
                <div class="form-group">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Nombre completo" required>
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" id="new_email" name="email" placeholder="Correo electrónico" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="new_password" name="password" placeholder="Contraseña" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirmar contraseña" required>
                </div>
                <button type="submit" class="btn btn-primary">Crear cuenta</button>
                <div class="signup-link mt-3">
                    <p>¿Ya tienes cuenta? <a id="signin-link" onclick="toggleForms()">Iniciar sesión</a></p>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS y dependencias -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        function toggleForms() {
            var loginForm = document.getElementById('login-form');
            var signupForm = document.getElementById('signup-form');
            if (loginForm.style.display === 'block') {
                loginForm.style.display = 'none';
                signupForm.style.display = 'block';
            } else {
                loginForm.style.display = 'block';
                signupForm.style.display = 'none';
            }
        }

        document.getElementById('loginForm').addEventListener('submit', function(event) {
            event.preventDefault();
            var form = event.target;
            var formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Success:', data);
                alert('Sesión iniciada correctamente');
                
                // Redirigir al usuario a la página de contacto
                var mobileNumber = data.user.mobile_number;
                window.location.href = 'contacto/' + mobileNumber; // Ajusta esto según tu ruta en Laravel
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Credenciales inválidas');
            });
        });

        document.getElementById('registerForm').addEventListener('submit', function(event) {
            event.preventDefault();
            var form = event.target;
            var formData = new FormData(form);

            // Validación de contraseñas
            var newPassword = formData.get('password');
            var confirmNewPassword = formData.get('confirm_password');
            if (newPassword !== confirmNewPassword) {
                alert('Las contraseñas no coinciden');
                return;
            }

            fetch(form.action, {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Success:', data);
                alert('Usuario registrado correctamente');
                toggleForms(); // Cambiar al formulario de inicio de sesión
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al registrar usuario');
            });
        });
    </script>
</body>
</html>
