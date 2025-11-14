<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">

<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-lg p-4" style="width: 400px; border-radius: 15px;">
        <div class="card-body">
            <h2 class="card-title text-center mb-4">Registro de Usuario</h2>

            <?php if (isset($_SESSION['error_registro'])): ?>
                <div class="alert alert-danger"><?= $_SESSION['error_registro'] ?></div>
                <?php unset($_SESSION['error_registro']); ?>
            <?php endif; ?>

            <form action="registrar_user.php" method="POST">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre completo</label>
                    <input type="text" class="form-control" id="nombre" name="nombre_usuario" required>
                </div>
                <div class="mb-3">
                    <label for="usuario" class="form-label">Usuario</label>
                    <input type="text" class="form-control" id="usuario" name="user_usuario" required>
                </div>
                <div class="mb-3">
                    <label for="contrasena" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="contrasena" name="pass_usuario" required>
                </div>
                <div class="mb-3">
                    <label for="confirmar" class="form-label">Confirmar Contraseña</label>
                    <input type="password" class="form-control" id="confirmar" name="confirm_pass" required>
                </div>
                <button type="submit" class="btn btn-dark w-100">Registrarse</button>
            </form>

            <div class="mt-3 text-center">
                <a href="login.php" style="color:black; font-weight:500;">¿Ya tienes cuenta? Inicia sesión</a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
