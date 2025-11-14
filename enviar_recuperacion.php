<?php
session_start();
require 'db.php';

$usuario = $_POST['usuario'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE user_usuario=?");
$stmt->execute([$usuario]);
$usuarioDB = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuarioDB) {
    $_SESSION['error_recuperar'] = "Usuario no encontrado.";
    header("Location: recuperar_contrasena.php");
    exit();
}

$nueva_pass = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8);

$stmt = $pdo->prepare("UPDATE usuarios SET pass_usuario=? WHERE id_usuario=?");
$stmt->execute([$nueva_pass, $usuarioDB['id_usuario']]);

$_SESSION['mensaje_recuperar'] = "Tu nueva contraseña temporal es: <strong>$nueva_pass</strong>. Por favor inicia sesión y cámbiala.";
header("Location: recuperar_contrasena.php");
exit();
