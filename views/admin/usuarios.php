<!-- Incluye la barra lateral del admin -->
<?php require __DIR__ . '../../../includes/templates/admin.php'; ?>

<section class="contenido-principal">
    <h2>Usuarios</h2>
    <!-- Tabla de Usuarios -->
    <?php
$resultado = $_GET['resultado'] ?? null; // Recoge el parámetro 'resultado' de la URL
$mensaje = mostrarNotificacion(intval($resultado));
if($mensaje) { ?>
    <p class="alerta error"><?php echo s($mensaje); ?></p>
<?php } ?>
    <div class="table-responsive">
        <table class="usuarios-admin">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Correo</th>
                    <th>Admin</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody> <!--Mostrar los resultados para cada usuario-->
                <?php foreach($usuarios as $usuario): ?>
                    <tr>
                        <td data-label="Id"><?php echo $usuario->id; ?></td>
                        <td data-label="Nombre"><?php echo $usuario->nombre; ?></td>
                        <td data-label="Apellido"><?php echo $usuario->apellido; ?></td>
                        <td data-label="Correo"><?php echo $usuario->email; ?></td>
                        <td data-label="Admin">
                            <!-- Formulario que sirve para cambiar si un usuario es admin o no, y se guarda automaticamente en la base de datos -->
                            <form method="POST" class="form-admin-yn" action="/admin/usuarios-act">
                                <input type="hidden" name="id" value="<?php echo $usuario->id; ?>">
                                <!-- Este if es para que el usuario actual que inicio sesión no pueda sacarse el admin, y siempre haya al menos 1 admin -->
                                <?php if($usuario->id === $_SESSION['usuario']): ?>
                                    <select name="admin" id="admin" onchange="this.form.submit()" disabled>
                                        <option value="1" <?php if($usuario->admin == 1) echo 'selected'; ?>>Sí</option>
                                    </select>
                                <?php else: ?>
                                <!-- Si no es el usuario actual, entonces se puede cambiar si es admin o no -->
                                    <select name="admin" id="admin" onchange="this.form.submit()">
                                        <option value="1" <?php if($usuario->admin == 1) echo 'selected'; ?>>Sí</option>
                                        <option value="0" <?php if($usuario->admin == 0) echo 'selected'; ?>>No</option>
                                    </select>
                                <?php endif; ?>
                            </form>
                        </td>
                        <td data-label="Acciones" class="acciones-formulario">
                            <!-- Este if es para que el usuario actual que inicio sesión no pueda eliminarse a si mismo, y siempre haya al menos 1 admin -->
                            <?php if($usuario->id === $_SESSION['usuario']): ?>
                                <p>Sin Acciones</p>
                            <?php else: ?>
                            <!-- Si no es el usuario actual, entonces se puede eliminar otros usuarios -->
                            <!-- Formulario para eliminar un usuario -->
                            <form method="POST" class="w-100" action="/admin/usuarios-el">
                                <input type="hidden" name="id" value="<?php echo $usuario->id; ?>">
                                <input type="submit" value="Eliminar" class="boton-rojo-block">
                            </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>
<!-- <?php /*if($resultado): ?>
    <p class="alerta exito"><?php echo $resultado; ?></p>
<?php endif; ?> -->*/