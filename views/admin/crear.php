<!-- Incluye la barra lateral del admin -->
<?php require __DIR__ . '../../../includes/templates/admin.php'; ?>

    <main class="contenido-principal">
        <h1>Crear</h1>

        <!-- Incluye las alertas para el formulario -->
        <?php include_once __DIR__ . '../../templates/alertas.php'; ?>

        <a href="/admin/productos" class="btn-volver">Volver</a>

        <!-- Formulario para crear productos -->
        <form method="POST" enctype="multipart/form-data">
    
            <!-- Incluye el template del formulario -->
            <?php include __DIR__ . '/formulario.php'; ?>

            <input class="btn-submit" type="submit" value="Crear Producto">
        </form>
    </main>

