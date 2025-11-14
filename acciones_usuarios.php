<?php
session_start();
require 'db.php';

if (!isset($_SESSION['id_usuario'])) {
    exit(json_encode(['error' => 'Acceso denegado']));
}

$cargo_actual = $_SESSION['cargo_usuario'];
$accion = $_GET['accion'] ?? '';

if ($accion === 'listar_cargos') {
    $cargos = $pdo->query("SELECT * FROM cargos ORDER BY nombre_cargo ASC")->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($cargos);
    exit();
}

if ($accion === 'obtener') {
    $id = $_GET['id'] ?? 0;
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id_usuario=?");
    $stmt->execute([$id]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($usuario);
    exit();
}

if ($accion === 'agregar') {
    if (!in_array($cargo_actual, ['Administrador', 'Instructor'])) {
        exit(json_encode(['error' => 'No tienes permiso']));
    }

    $nombre = $_POST['nombre_usuario'] ?? '';
    $user = $_POST['user_usuario'] ?? '';
    $pass = $_POST['pass_usuario'] ?? '';
    $id_cargo = $_POST['id_cargo'] ?? '';

    $sql = "INSERT INTO usuarios (nombre_usuario, user_usuario, pass_usuario, id_cargo) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nombre, $user, $pass, $id_cargo]);

    echo json_encode(['success' => true]);
    exit();
}

if ($accion === 'editar') {
    if (!in_array($cargo_actual, ['Administrador', 'Instructor'])) {
        exit(json_encode(['error' => 'No tienes permiso']));
    }

    $id = $_POST['id_usuario'] ?? 0;
    $nombre = $_POST['nombre_usuario'] ?? '';
    $user = $_POST['user_usuario'] ?? '';
    $pass = $_POST['pass_usuario'] ?? '';
    $id_cargo = $_POST['id_cargo'] ?? '';

    $sql = "UPDATE usuarios SET nombre_usuario=?, user_usuario=?, pass_usuario=?, id_cargo=? WHERE id_usuario=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nombre, $user, $pass, $id_cargo, $id]);

    echo json_encode(['success' => true]);
    exit();
}

if ($accion === 'eliminar') {
    if ($cargo_actual !== 'Administrador') {
        exit(json_encode(['error' => 'No tienes permiso']));
    }

    $id = $_POST['id'] ?? 0;
    $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id_usuario=?");
    $stmt->execute([$id]);

    echo json_encode(['success' => true]);
    exit();
}

