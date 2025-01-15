<!-- Incluye la barra lateral del admin -->
<?php require __DIR__ . '../../../includes/templates/admin.php'; ?>

<section class="contenedor-productos contenido-principal">
    <div class="header-productos">
        <h2 class="titulo_productos">Productos</h2>
    </div>  
    <!-- Enlace hacia el formulario para crear un nuevo producto -->
    <?php
    $mensaje = mostrarNotificacion(intval($resultado));
    if($mensaje) { ?>
        <p class="alerta exito"><?php echo s($mensaje); ?></p>
    <?php } ?>
    <a href="/admin/crear" class="boton-verde">Nuevo Producto</a>
    <!-- Tabla de productos  -->
    <table class="productos-conteiner-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>
                    <!-- Listar los productos segun precio -->
                    Precio
                    <a href="?orden=precio_asc" id="ord-precio-asc">▲</a>
                    <a href="?orden=precio_desc" id="ord-precio-desc">▼</a>
                </th>
                <th>Categoria</th>
                <th>
                    <!-- Listar los productos segun fecha de creacion -->
                    Fecha
                    <a href="?orden=fecha_asc" id="ord-fecha-asc">▲</a>
                    <a href="?orden=fecha_desc" id="ord-fecha-desc">▼</a>
                </th>
                <th>Acciones</th>
            </tr>
        </thead>
        

        <tbody>  <!--Mostrar los resultados para cada producto-->
            <?php foreach($producto as $product): ?>
            <tr>
                <td data-label="ID"><?php echo $product->id; ?></td>
                <td data-label="Imagen"><img src="/imagenes/<?php echo $product->imagen; ?>" class="imagen-tabla"></td>
                <td data-label="Nombre"><?php echo $product->nombre; ?></td>
                <td data-label="Precio">€<?php echo $product->precio; ?></td>
                <td data-label="Categoria">
                    <!-- Categoria a la que pertenece un producto -->
                    <?php foreach($categorias as $categoria){
                        if($categoria->id === $product->idCategoria){ 
                            echo $categoria->nombre;
                        } 
                    }?>
                </td>
                <!-- Fecha de creacion del producto -->
                <td data-label="Fecha"><?php echo date('j / m / Y', strtotime($product->fecha)); ?></td>
                <!-- Formulario para eliminar un producto -->
                <td data-label="Acciones" class="acciones-formulario">
                    <form method="POST"  action="/admin/eliminar">
                        <input type="hidden" name="id" value="<?php echo $product->id?>">
                        <input type="hidden" name="tipo" value="producto">
                        <input type="submit" class="boton-rojo-block" value="Eliminar">
                    </form>
                    <!-- Enlace hacia el formulario para actualizar un producto -->
                    <a href="/admin/actualizar?id=<?php echo $product->id; ?>" class="boton-amarillo-block">Actualizar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>