<?php
session_start();
require 'db.php';

if (!isset($_SESSION['id_usuario'])) {
    exit("Acceso denegado");
}

$cargo_actual = $_SESSION['cargo_usuario'];

$sql = "SELECT u.id_usuario, u.nombre_usuario, u.user_usuario, u.pass_usuario, c.nombre_cargo
        FROM usuarios u
        JOIN cargos c ON u.id_cargo = c.id_cargo
        ORDER BY u.id_usuario ASC";
$usuarios = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

echo '<table class="table table-striped table-hover align-middle text-center">';
echo '<thead class="table-dark">';
echo '<tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Usuario</th>
        <th>Contraseña</th>
        <th>Cargo</th>
        <th>Acciones</th>
      </tr>';
echo '</thead>';
echo '<tbody>';

foreach ($usuarios as $u) {
    echo '<tr>';
    echo '<td>' . htmlspecialchars($u['id_usuario']) . '</td>';
    echo '<td>' . htmlspecialchars($u['nombre_usuario']) . '</td>';
    echo '<td>' . htmlspecialchars($u['user_usuario']) . '</td>';
    echo '<td>' . htmlspecialchars($u['pass_usuario']) . '</td>';
    echo '<td>' . htmlspecialchars($u['nombre_cargo']) . '</td>';
    
    echo '<td>';
    if (in_array($cargo_actual, ['Administrador', 'Instructor'])) {
        echo '<button class="btn btn-warning btn-sm btnEditar" data-id="' . $u['id_usuario'] . '">
                <i class="bi bi-pencil-square"></i> Editar
              </button> ';
    }
    if ($cargo_actual == 'Administrador') {
        echo '<button class="btn btn-danger btn-sm btnEliminar" data-id="' . $u['id_usuario'] . '">
                <i class="bi bi-trash"></i> Eliminar
              </button>';
    }
    echo '</td>';

    echo '</tr>';
}

echo '</tbody>';
echo '</table>';
