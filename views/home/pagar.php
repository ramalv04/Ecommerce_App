<main>

    <div class="contenedor contenedor-pago">
        <h2 class="titulo">Pagar</h2>
        <h3 class="descripcion">Revisa los productos de tu carrito y procede al pago</h3>

        <!-- La variable total calcula el total a pagar en todo el pedido -->
        <?php
        $total = 0;
        if (!empty($pedido)) {
        ?>
            <!-- Si hay objetos en el pedido -->
            <table class="productos">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Imagen</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Para cada producto en el pedido -->
                    <?php foreach ($pedidosProductos as $pp) { ?>
                        <?php if($pp->idPedido === $pedido->id): ?>
                        <tr>
                            <!-- Nombre del producto -->
                            <td data-column="Nombre"><?php 
                                foreach($productos as $producto){
                                    if($producto->id === $pp->idProducto){
                                        echo $producto->nombre;
                                    }
                                }
                            ?></td>
                            <!-- Imagen -->
                            <td data-column="Imagen"><img src="/imagenes/<?php 
                                foreach($productos as $producto){
                                    if($producto->id === $pp->idProducto){
                                        echo $producto->imagen;
                                    }
                                }
                            ?>" class="imagen-tabla"></td>
                            <!-- Cantidad -->
                            <td data-column="Cantidad"><?php echo $pp->cantidad ?></td>
                            <!-- Precio unitario -->
                            <td data-column="Precio"><?php 
                                foreach($productos as $producto){
                                    if($producto->id === $pp->idProducto){
                                        echo "€" . $producto->precio;
                                    }
                                }
                            ?></td>
                            <!-- Precio unitario multiplicado por la cantidad -->
                            <td data-column="Total"><?php
                                foreach($productos as $producto){
                                    if($producto->id === $pp->idProducto){
                                        echo "€" . $producto->precio * $pp->cantidad;
                                        $total += $producto->precio * $pp->cantidad;
                                    }
                                }
                            ?></td>
                        </tr>
                        <?php endif; ?>
                    <?php } ?>
                </tbody>
            </table>
            <!-- Total a pagar -->
            <h3 class="total-precio">Total: <?php echo '€' . $total; ?></h3>
            <div id="paypal-button-container"></div>
        <?php } else { ?>
            <!-- Si no hay productos -->
            <h3 class="off-carrito">No hay productos</h3>
            <section>
                <a href="/tienda" class="btn-volver">Volver a la tienda</a>
            <?php } ?>
      
        <script src="https://www.paypal.com/sdk/js?client-id=AQqDO16FSz81xltlJv6GkibiUTvHwNM9Srs9go3cxibLZ6Ru037seSi-gj51LPwxBfcvtQiVIXe29DIz"></script>

        <script>
        paypal.Buttons({
            style: {
                color: 'blue',
                shape: 'pill',
                label: 'pay',
                layout: 'vertical',
                size: 'responsive'
            },
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '<?php echo $total?>' // Reemplaza esto con el total de la compra
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    // Llama a tu servidor para guardar la transacción en la base de datos
                    fetch('/guardarTransaccion', {
                        method: 'post',
                        headers: {
                            'content-type': 'application/json'
                        },
                        body: JSON.stringify({
                            orderID: data.orderID
                        })
                    });

                    // Muestra una alerta cuando se complete el pago
                    alert('El pago se ha completado con éxito.');
                    // Redirige a otra página después de que se complete el pago, con un retraso de 2 segundos (2000 milisegundos)
                    setTimeout(function() {
                        window.location.href = 'http://localhost:3000/';
                    }, 2000); // 2000 milisegundos = 2 segundos
                });
            }
        }).render('#paypal-button-container');
        </script>

    </div>
</main>
</section>
