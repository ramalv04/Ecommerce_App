<main>
    <div class="contenedor contenedor-carrito">
        <div>
            <h2 class="titulo">Tu Carrito</h2>
            <h3 class="descripcion">Aqui tienes un listado con los productos de tu carrito</h3>
        </div>

        <div>
            <!-- la variable total es para contar el total a pagar en todo el carrito, y la variable i es un indice -->
            <?php
            $total = 0;
            $i = 0;
            if(!empty($_SESSION['CARRITO'])) { ?>
            <!-- Si hay algun producto en el carrito se muestra lo siguiente -->
            <table class="productos">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Imagen</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Total</th>
                        <th>...</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Para cada producto en el carrito se listan sus propiedades -->
                    <?php foreach($_SESSION['CARRITO'] as $key=>$prod){ ?>
                    <tr>
                        <td><?php echo $i+=1; ?></td>
                        <td data-column="Nombre"> <?php echo $prod['NOMBRE']; ?> </td>
                        <td data-column="Imagen"> <img src="/imagenes/<?php echo $prod['IMAGEN']; ?>" class="imagen-tabla"> </td>
                        <td data-column="Cantidad">
                            <!-- Formulario para cambiar la cantidad a pedir para cada producto, y que se actualice automaticamente el total a pagar -->
                            <form method="POST" action="/carrito/cantidad" class="form-cantidad">
                                <input type="number" min="1" name="cantidad" value="<?php echo $prod['CANTIDAD']; ?>" id="cant-carrito" class="input-cantidad">
                                <input type="hidden" name="id" value="<?php echo $prod['ID']; ?>">
                            </form>
                        </td>
                        <!-- Precio unitario de cada producto -->
                        <td data-column="Precio">€ <?php echo $prod['PRECIO']; ?> </td>
                        <!-- Precio unitario multiplicado por la cantidad pedida de un determinado producto -->
                        <td data-column="Total">€ <?php echo $prod['PRECIO'] * $prod['CANTIDAD']; ?> </td>
                        <td data-column="...">
                            <!-- Formulario para eliminar un producto del carrito -->
                            <form method="POST" action="/carrito/eliminar">
                                <input type="hidden" name="id" value="<?php echo $prod['ID']; ?>">
                                <input type="hidden" name="tipo" value="producto">
                                <input class="btn-eliminar" type="submit" value="Eliminar">
                            </form>
                        </td>
                        <!-- Total a pagar teniendo en cuenta todos los productos y la cantidad de cada uno -->
                        <?php $total+= $prod['PRECIO'] * $prod['CANTIDAD']; } ?>
                    </tr>
                </tbody>
            </table>
            </table>
            <!-- Muestra el total a pagar -->
            <h3 class="total-precio">Total: <?php echo '€'.$total; ?></h3>
            <div class="carrito-acciones">
                <!-- Formulario para vaciar el carrito entero -->
                <form class="form" method="POST" action="/vaciar-carrito">
                    <input type="submit" class="boton-rojo-block" value="Vaciar Carrito">
                </form>

                <div class="ir-pagar">
                    <!-- Formulario que confirma el pedido, lo guarda en la bd como pendiente, y redirige al usuario hacia la pagina para pagar el pedido -->
                    <form method="POST" action="/carrito/confirmar">
                        <input class="btn-submit" type="submit" id="con" value="Confirmar Pedido">
                    </form>
                </div>
            </div>
            <!-- En caso de que no hay producto en el carrito -->
            <?php }else { ?>
                <h3 class="off-carrito">No hay productos en el carrito</h3>
                <section>
                    <a href="/tienda?id=<?php echo $categorias[0]->id; ?>" class="btn-volver">Volver a la tienda</a>
                </section>
            <?php } ?>
        </div>
    </div>
</main>