<!-- Con este foreach obtengo la categoria de alfombras-->
<?php foreach($productos as $producto) { ?>
    <?php foreach($categorias as $categoria) {
        $cat = $categoria;
        break;
    } ?>
    <!-- Si el producto tiene la categoria de alfombra, se lista en esta seccion -->
    <?php if($producto->idCategoria === $cat->id) { ?>
        <div class="producto">
            <img loading="lazy" src="/imagenes/<?php echo $producto->imagen ?>" alt="Imagen Producto">
            <h3><?php echo $producto->nombre; ?></h3>
            <p class="precio">€<?php echo $producto->precio; ?></p>
            <a href="/producto?id=<?php echo $producto->id; ?>" class="btn-agregar-carrito">Ver producto</a>
        </div>
    <?php } ?>
<?php } ?>