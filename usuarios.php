<?php
session_start();
require 'db.php';

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

$cargo = $_SESSION['cargo_usuario'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Gestión de Usuarios</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="css/navbar.css">

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">
<nav class="navbar">
  <div class="navbar-left">
    <a href="#" class="brand">Mi Sitio</a>
  </div>
</nav>
<div class="container py-5">
  <div class="card shadow-lg border-0 rounded-4">
    <div class="card-body p-5">

      <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
          <h2 class="fw-bold text-primary mb-1">Gestión de Usuarios</h2>
          <p class="text-muted mb-0">
            <strong>Usuario actual:</strong> <?= htmlspecialchars($_SESSION['nombre_usuario']) ?>
            <span class="badge bg-info text-dark"><?= htmlspecialchars($cargo) ?></span>
          </p>
        </div>

        <?php if ($cargo == 'Administrador' || $cargo == 'Instructor'): ?>
        <button class="btn btn-success btn-lg shadow-sm" data-bs-toggle="modal" data-bs-target="#modalAgregar">
          <i class="bi bi-person-plus"></i> Nuevo Usuario
        </button>
        <?php endif; ?>
      </div>

      <div id="tablaUsuarios" class="table-responsive border rounded-3 p-3 bg-white shadow-sm">
        <div class="text-center text-muted py-5">
          <div class="spinner-border text-primary mb-3" role="status"></div>
          <p>Cargando usuarios...</p>
        </div>
      </div>

    </div>
  </div>
</div>

<div class="modal fade" id="modalAgregar" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="formAgregar">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title">Agregar Usuario</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre_usuario" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Usuario</label>
            <input type="text" name="user_usuario" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Contraseña</label>
            <input type="password" name="pass_usuario" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Cargo</label>
            <select name="id_cargo" id="selectCargoAgregar" class="form-select" required></select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modalEditar" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="formEditar">
        <div class="modal-header bg-warning">
          <h5 class="modal-title">Editar Usuario</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id_usuario" id="edit_id">
          <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre_usuario" id="edit_nombre" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Usuario</label>
            <input type="text" name="user_usuario" id="edit_user" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Contraseña</label>
            <input type="text" name="pass_usuario" id="edit_pass" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Cargo</label>
            <select name="id_cargo" id="edit_cargo" class="form-select" required></select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-warning text-white">Actualizar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {

  cargarUsuarios();
  cargarCargos();

  function cargarUsuarios() {
    $.get("listar_usuarios.php", function(data) {
      $("#tablaUsuarios").html(data);
    });
  }

  function cargarCargos() {
    $.getJSON("acciones_usuarios.php?accion=listar_cargos", function(cargos) {
      $("#selectCargoAgregar, #edit_cargo").empty();
      $.each(cargos, function(i, c) {
        $("#selectCargoAgregar, #edit_cargo").append(
          `<option value="${c.id_cargo}">${c.nombre_cargo}</option>`
        );
      });
    });
  }

  $("#formAgregar").submit(function(e) {
    e.preventDefault();
    $.post("acciones_usuarios.php?accion=agregar", $(this).serialize(), function() {
      $("#modalAgregar").modal('hide');
      cargarUsuarios();
    });
  });

  $(document).on("click", ".btnEditar", function() {
    let id = $(this).data("id");
    $.getJSON("acciones_usuarios.php?accion=obtener&id=" + id, function(u) {
      $("#edit_id").val(u.id_usuario);
      $("#edit_nombre").val(u.nombre_usuario);
      $("#edit_user").val(u.user_usuario);
      $("#edit_pass").val(u.pass_usuario);
      $("#edit_cargo").val(u.id_cargo);
      $("#modalEditar").modal("show");
    });
  });

  $("#formEditar").submit(function(e) {
    e.preventDefault();
    $.post("acciones_usuarios.php?accion=editar", $(this).serialize(), function() {
      $("#modalEditar").modal('hide');
      cargarUsuarios();
    });
  });

  $(document).on("click", ".btnEliminar", function() {
    if(confirm("¿Seguro que deseas eliminar este usuario?")) {
      $.post("acciones_usuarios.php?accion=eliminar", { id: $(this).data("id") }, function() {
        cargarUsuarios();
      });
    }
  });

});
</script>

</body>
</html>
