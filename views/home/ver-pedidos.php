<section class="pedido-section">
<a href="/pedidos" class="btn-volver">Volver</a>
    <!-- Numero de referencia del pedido -->
    <h1 class="titulo">Pedido #<?php echo $pedido->referencia ?></h1>
    <table class="tabla-pedido contenedor">
        <thead>
            <tr>
                <th class="celda">Producto</th>
                <th class="celda">Cantidad</th>
                <th class="celda">Precio Unitario</th>
                <th class="celda">Precio Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $total = 0; //Variable total para calcular el total a pagar
            foreach($pedidosProductos as $pp): ?>
                <?php if($pp->idPedido === $pedido->id): ?>
                    <!-- Se listan los productos pertencientes al pedido -->
            <tr class="fila-producto">
                <td class="celda" data-titulo="Producto:">
                    <?php 
                        foreach($productos as $producto){
                            if($producto->id === $pp->idProducto){
                                echo $producto->nombre;
                            }
                        }
                    ?>
                </td>
                <td class="celda" data-titulo="Cantidad:"><?php echo $pp->cantidad ?></td>
                <td class="celda" data-titulo="Precio Unitario:">
                    <?php 
                        foreach($productos as $producto){
                            if($producto->id === $pp->idProducto){
                                echo "€" . $producto->precio;
                            }
                        }
                    ?>
                </td>
                <td class="celda" data-titulo="Precio Total:">
                    <?php
                        foreach($productos as $producto){
                            if($producto->id === $pp->idProducto){
                                echo "€" . $producto->precio * $pp->cantidad;
                                $total += $producto->precio * $pp->cantidad;
                            }
                        }
                    ?>
                </td>
            </tr>
            <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="total-pedido">
        <span class="titulo-total">Total del Pedido:</span>
        <!-- Total a pagar -->
        <span class="monto-total">€ <?php echo $total ?></span>

        <!-- Si el pedido ya está acreditado, entonces el usuario solo puede ver los productos del pedido y el total que pagó -->
        <!-- Si el pedido está pendiente, el usuario puede eliminar el pedido, o puede ir a pagarlo -->
        <?php if($pedido->idEstado === $estados[1]->id): ?>
            <div class="btn-act">
                <!-- Formulario para eliminar pedido -->
            <form method="POST" action="/eliminar-pedido">
                <input type="hidden" name="id" value="<?php echo $pedido->id; ?>">
                <input type="submit" class="boton-rojo-block" value="Eliminar Pedido">              
            </form>
            <!-- Boton que redirecciona al usuario a pagar el pedido -->
            <a href="/pagar?id=<?php echo $pedido->id; ?>" class="btn-pagar">Pagar</a>
            </div>

        <?php endif; ?>
    </div>
</section>