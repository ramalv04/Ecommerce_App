<!-- Incluye la barra lateral del admin -->
<?php require __DIR__ . '../../../includes/templates/admin.php'; ?>

<section>
    <section class="contenedor-productos contenido-principal">
        <div class="header-productos">
            <h2 class="titulo_productos">Ordenes</h2>
        </div> 
    <?php
$resultado = $_GET['resultado'] ?? null; // Recoge el parámetro 'resultado' de la URL
$mensaje = mostrarNotificacion(intval($resultado));
if($mensaje) { ?>
    <p class="alerta error"><?php echo s($mensaje); ?></p>
<?php } ?>
        <!-- Tabla de ordenes/pedidos  -->
        <table class="ordenes-conteiner-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    <th>
                        Fecha
                        <a href="?orden=fecha_asc" id="ord-fecha-asc">▲</a>
                        <a href="?orden=fecha_desc" id="ord-fecha-desc">▼</a>
                    </th>
                    <th>N° Referencia</th>
                    <th>Estado</th>
                    <th>Acciones</th>   
                </tr>
            </thead>
            
    
            <tbody>  <!--Mostrar los resultados de cada pedido -->
                <?php foreach($pedidos as $pedido): ?>
                <tr>
                    <td data-ordenes="ID"><?php echo $pedido->id; ?></td>
                    <td data-ordenes="Usuario">
                        <!-- Nombre y Apellido del usuario que realizo el pedido -->
                        <?php foreach($usuarios as $usuario){
                            if($usuario->id === $pedido->idUsuario){ 
                                echo $usuario->nombre . " " . $usuario->apellido;
                            } 
                        }?>
                    </td>
                    <td data-ordenes="Producto">
                        <!-- Productos requeridos en el pedido -->
                        <?php foreach($pedidosProductos as $pp){
                            foreach($productos as $producto) {
                                if($producto->id === $pp->idProducto && $pp->idPedido === $pedido->id){ ?>
                                    <div><?php echo $producto->nombre; ?></div>
                                <?php }
                            }
                        }?>
                    </td>
                    <td data-ordenes="Cantidad">
                        <!-- Cantidad que se pidio para cada producto en un mismo pedido -->
                        <?php foreach($pedidosProductos as $pp){
                            if($pp->idPedido === $pedido->id){ ?>
                                <div><?php echo $pp->cantidad; ?></div>
                            <?php }
                        }?>
                    </td>
                    <td data-ordenes="Total"> 
                        <!-- Precio total del pedido -->
                        <?php $total = 0; foreach($pedidosProductos as $pp){
                            foreach($productos as $producto) {
                                if($producto->id === $pp->idProducto && $pp->idPedido === $pedido->id){
                                    $total += floatval($producto->precio) * floatval($pp->cantidad);
                                }
                            }
                        }?>
                        <?php echo "€" . $total; ?>
                    </td>
                    <!-- Fecha en que se realizo el pedido -->
                    <td data-ordenes="Fecha"><?php echo date('j / m / Y', strtotime($pedido->fecha)); ?></td>
                    <!-- Numero de referencia del pedido -->
                    <td data-ordenes="N° Referencia"><?php echo "#" . $pedido->referencia; ?></td>
                    <!-- Estado del pedido: Acreditado o Pendiente -->
                    <td data-ordenes="Estado"><?php foreach($estados as $estado) {
                        if($estado->id === $pedido->idEstado){
                            echo $estado->nombre;
                        }
                    } ?></td>
                    <!-- Formulario para eliminar un pedido -->
                    <td class="acciones-formulario" data-ordenes="Acciones">
                        <form method="POST"  action="/eliminar-pedido">
                            <input type="hidden" name="id" value="<?php echo $pedido->id?>">
                            <input type="hidden" name="tipo" value="pedido">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</section>