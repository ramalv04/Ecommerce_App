<main class="contenedor2">
<section>
    <!-- Boton para volver a la tienda -->
    <?php if($producto->idCategoria === $categorias[0]->id): ?>
        <!-- Si estabas viendo una alfombra, te devuelve a la seccion de alfombras -->
        <a href="/tienda?id=<?php echo $categorias[0]->id ?>" class="btn-volver">Volver a la tienda</a>
    <?php elseif($producto->idCategoria === $categorias[1]->id): ?>
        <!-- Si estabas viendo un tapiz, te devuelve a la seccion de tapices -->
        <a href="/tienda?id=<?php echo $categorias[1]->id ?>" class="btn-volver">Volver a la tienda</a>
    <?php endif; ?>
</section>

    <div class="producto-tienda-id">
        <div class="img-producto-id">
            <img loading="lazy" src="/imagenes/<?php echo $producto->imagen ?>" alt="Imagen Producto">
        </div>
        <div class="informacion-producto">
            <h1 class="mensaje-pagina"><?php echo $producto->nombre; ?></h1>
            <p class="precio">€<?php echo $producto->precio;?></p>
            <p class="descripcion-producto"><?php echo $producto->descripcion; ?></p>
            <!-- Si el carrito esta vacio, aparece un boton para añadir al carrito -->
            <?php if (empty($_SESSION['CARRITO'])) { ?>
                <form method="POST" id="form-cant">
                    <label for="cantidad">Cantidad:</label>
                    <input type="number" min="1" value="1" name="cantidad-p" id="cantidad" class="input-cantidad-p">
                    <input class="btn-agregar-producto" type="submit" value="Añadir al Carrito">
                </form>
            <?php } else { 
                // Si el carrito no esta vacio, reviso si el producto actual se encuentra en el carrito
                $productoEnCarrito = false;
                foreach ($_SESSION['CARRITO'] as $key => $prod) {
                    if ($prod['ID'] === $producto->id) {
                        $productoEnCarrito = true;
                        ?>
                        <!-- Si el producto esta en el carrito, aparece el boton de eliminar del carrito y no se puede cambiar la cantidad -->
                        <form method="POST" action="/carrito/eliminar">
                            <label for="cantidad">Cantidad:</label>
                            <input type="number" min="1" value="<?php echo $_SESSION['CARRITO'][$key]['CANTIDAD']; ?>" name="cantidad-p" id="cantidad" class="input-cantidad-p" disabled>
                            <input type="hidden" name="id" value="<?php echo $prod['ID']; ?>">
                            <input type="hidden" name="url" value="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
                            <input class="btn-eliminar" type="submit" value="Eliminar del Carrito">
                        </form>
                        <?php
                    }
                }
                if (!$productoEnCarrito) {
                    ?>
                    <!-- Si el producto no esta en el carrito, aparece el boton de añadir al carrito -->
                    <form method="POST">
                        <label for="cantidad">Cantidad:</label>
                        <input type="number" min="1" value="1" name="cantidad-p" id="cantidad" class="input-cantidad-p">
                        <input class="btn-agregar-producto" type="submit" value="Añadir al Carrito">
                    </form>
                <?php } ?>
            <?php } ?>
        </div>  
    </div>
</main>
