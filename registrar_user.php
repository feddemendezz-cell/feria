<?php
session_start();
require 'db.php';

$nombre = $_POST['nombre_usuario'] ?? '';
$usuario = $_POST['user_usuario'] ?? '';
$pass = $_POST['pass_usuario'] ?? '';
$confirm_pass = $_POST['confirm_pass'] ?? '';

if ($pass !== $confirm_pass) {
    $_SESSION['error_registro'] = "Las contraseñas no coinciden.";
    header("Location: registro.php");
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE user_usuario=?");
$stmt->execute([$usuario]);
if ($stmt->rowCount() > 0) {
    $_SESSION['error_registro'] = "El usuario ya existe.";
    header("Location: registro.php");
    exit();
}

$id_cargo_default = 3; 

$stmt = $pdo->prepare("INSERT INTO usuarios (nombre_usuario, user_usuario, pass_usuario, id_cargo) VALUES (?, ?, ?, ?)");
$stmt->execute([$nombre, $usuario, $pass, $id_cargo_default]);

$_SESSION['exito_registro'] = "Registro exitoso, ahora puedes iniciar sesión.";
header("Location: login.php");
exit();
