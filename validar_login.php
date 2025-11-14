<?php
session_start();
require 'db.php';

$usuario = $_POST['usuario'];
$password = $_POST['contrasena'];

$sql = "SELECT u.*, c.nombre_cargo 
        FROM usuarios u 
        JOIN cargos c ON u.id_cargo = c.id_cargo 
        WHERE u.user_usuario = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$usuario]);
$usuarioDB = $stmt->fetch(PDO::FETCH_ASSOC);

if ($usuarioDB && $password === $usuarioDB['pass_usuario']) {
    $_SESSION['id_usuario'] = $usuarioDB['id_usuario'];
    $_SESSION['nombre_usuario'] = $usuarioDB['nombre_usuario'];
    $_SESSION['cargo_usuario'] = $usuarioDB['nombre_cargo'];

    header("Location: usuarios.php");
    exit();
} else {
    $_SESSION['error'] = "Usuario o contraseña incorrectos.";
    header("Location: login.php");
    exit();
}
?>
