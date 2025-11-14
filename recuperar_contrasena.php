<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Contraseña</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">

<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-lg p-4" style="width: 350px; border-radius: 15px;">
        <div class="card-body">
            <h2 class="card-title text-center mb-4">Recuperar Contraseña</h2>

            <?php if (isset($_SESSION['mensaje_recuperar'])): ?>
                <div class="alert alert-success"><?= $_SESSION['mensaje_recuperar'] ?></div>
                <?php unset($_SESSION['mensaje_recuperar']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error_recuperar'])): ?>
                <div class="alert alert-danger"><?= $_SESSION['error_recuperar'] ?></div>
                <?php unset($_SESSION['error_recuperar']); ?>
            <?php endif; ?>

            <form action="enviar_recuperacion.php" method="POST">
                <div class="mb-3">
                    <label for="usuario" class="form-label">Ingresa tu usuario</label>
                    <input type="text" class="form-control" id="usuario" name="usuario" required>
                </div>
                <button type="submit" class="btn btn-dark w-100">Recuperar Contraseña</button>
            </form>

            <div class="mt-3 text-center">
                <a href="login.php" style="color:black; font-weight:500;">Volver al login</a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
