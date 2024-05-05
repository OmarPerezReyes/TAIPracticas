<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"> <!-- Font Awesome para íconos -->
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .login-container {
            margin-top: 50px;
        }

        .login-form {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
        }

        .login-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .login-header h2 {
            color: #007bff;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .login-logo {
            width: 120px;
            height: auto;
            margin-bottom: 20px;
        }

        .form-group {
            position: relative;
            margin-bottom: 30px;
        }

        .form-group input {
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 10px;
            width: 100%;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: none;
        }

        .form-group i {
            position: absolute;
            top: 50%;
            right: 20px;
            transform: translateY(-50%);
            color: #ccc;
        }

        .btn-login {
            background-color: #007bff;
            border-color: #007bff;
            color: #fff;
            border-radius: 10px;
            padding: 15px 0;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }

        .btn-login:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container login-container">
        <div class="row justify-content-center">
            <div class="col-md-6 login-form">
                <div class="login-header">
                    <img src="../assets/img/png-transparent-computer-icons-registered-user-login-user-profile-others-blue-logo-registered-user-thumbnail.png"  alt="Logo" class="login-logo">
                    <h2>Registro de Usuario</h2>
                </div>


                <form action="../controllers/registro_controller.php" method="post">
                    <div class="form-group">
                        <label for="matricula">Matrícula:</label><br>
                        <input type="text" id="matricula" name="matricula" min="0" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="nombre">Nombre:</label><br>
                        <input type="text" id="nombre" name="nombre" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="apellido">Apellido:</label><br>
                        <input type="text" id="apellido" name="apellido" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="correo">Correo:</label><br>
                        <input type="email" id="correo" name="correo" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="contrasena">Contraseña:</label><br>
                        <input type="password" id="contrasena" name="contrasena" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono:</label><br>
                        <input type="text" id="telefono" name="telefono" class="form-control" required>
                    </div>
                    <button type="submit" name="registro" class="btn btn-login btn-block">Registrar</button>
                </form>
            </div>
        </div>
    </div>
    <br><br>
</body>

</html>