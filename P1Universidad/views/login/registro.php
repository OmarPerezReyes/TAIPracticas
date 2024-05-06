<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"> <!-- Font Awesome para íconos -->
    <link rel="stylesheet" href="assets/css/style_header.css">

</head>

<body>
    <div class="container login-container">
        <div class="row justify-content-center">
            <div class="col-md-6 login-form">
                <div class="login-header">
                    <img src="assets/img/png-transparent-computer-icons-registered-user-login-user-profile-others-blue-logo-registered-user-thumbnail.png" alt="Logo" class="login-logo">
                    <h2>Registro de Administrador</h2>
                </div>

<form action="index.php?m=registro" method="post">
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
