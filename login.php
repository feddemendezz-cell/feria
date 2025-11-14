<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">

<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-lg p-4" style="width: 350px; border-radius: 15px;">
        <div class="card-body">
            <h2 class="card-title text-center mb-4">Iniciar Sesión</h2>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['exito_registro'])): ?>
                <div class="alert alert-success"><?= $_SESSION['exito_registro'] ?></div>
                <?php unset($_SESSION['exito_registro']); ?>
            <?php endif; ?>

            <form action="validar_login.php" method="POST">
                <div class="mb-3">
                    <label for="usuario" class="form-label">Usuario</label>
                    <input type="text" class="form-control" id="usuario" name="usuario" required>
                </div>
                <div class="mb-3">
                    <label for="contrasena" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="contrasena" name="contrasena" required>
                </div>
                <button type="submit" class="btn btn-dark w-100">Ingresar</button>
            </form>

            <div class="mt-3 text-center">
                <a href="recuperar_contrasena.php" style="color:black; font-weight:500;">¿Olvidaste tu contraseña?</a><br>
                <a href="registro.php" style="color:black; font-weight:500;">¿No tienes cuenta? Regístrate</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
