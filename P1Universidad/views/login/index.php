<form action="index.php?m=iniciar_sesion" method="post">
    <div class="form-group">
        <input type="email" name="correo" class="form-control" placeholder="Correo electrónico" required>
        <i class="fas fa-envelope"></i>
    </div>
    <div class="form-group">
        <input type="password" name="contrasena" class="form-control" placeholder="Contraseña" required>
        <i class="fas fa-lock"></i>
    </div>
    <div class="text-center">
        ¿No tienes una cuenta? <a href="index.php?m=registro">Registrarse</a>
    </div>
    <br>
    <div class="form-group">
        <button type="submit" class="btn btn-login btn-block">Iniciar sesión</button>
    </div>
</form>
