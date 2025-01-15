<?php 
    function fechaEnEspañol($fecha) {
        $mesesIngles = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $mesesEspañol = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

        $fechaEnIngles = date('j F Y', strtotime($fecha));
        return str_replace($mesesIngles, $mesesEspañol, $fechaEnIngles);
    }
?>
<section class="pedidos-section">
    <h1 class="titulo">Mis Pedidos</h1>
    <?php $lleno=true; //Su funcion es evitar que el primer if del foreach principal se ejecute mas de una vez
        foreach($pedidos as $pedido): ?>
        <!-- Si existen pedidos realizados, el usuario logueado tambien ha realizado al menos un pedido, y la variable $lleno, 
        entonces se listan los pedidos que el usuario actual realizó -->
    <?php if(!empty($pedidos) && ($pedido->idUsuario === $_SESSION['usuario']) && $lleno): ?>
        <h2>Pendientes</h4>
        <!-- Pedido pendientes, es decir que todavia no ha realizado el pago (la varible $pendientes viene del HomePageController) -->
        <?php if($pendientes != 0):?>
        <table class="tabla-pedidos contenedor">
            <thead>
                <tr>
                    <th class="celda">#</th>
                    <th class="celda">Fecha</th>
                    <th class="celda">Total</th>
                    <th class="celda">Estado</th>
                    <th class="celda">...</th>
                </tr>
            </thead>
            <!-- Si no hay pedidos pendientes -->
            <?php else: ?>
                <h3 class="off-carrito">No hay pedidos pendientes</h3> 
            <?php endif?>;
            <tbody>
            <?php $i = 0; //Variable indice
            foreach($pedidos as $pedido): ?>
            <?php if($pedido->idUsuario === $_SESSION['usuario'] && $pedido->idEstado === $estados[1]->id): ?>
                <!-- Se listan los pedidos realizados por el usuario, que aun estén pendientes -->
            <tr class="fila-pedido">
                <td class="celda" data-titulo="#:"><?php echo $i+=1; ?></td>
                <td class="celda" data-titulo="Fecha:">
                <?php echo fechaEnEspañol($pedido->fecha); ?>
</td>
                <td class="celda" data-titulo="Total:">
                    <?php $total = 0; foreach($pedidosProductos as $pp){
                        
                        foreach($productos as $producto) {
                            if($producto->id === $pp->idProducto && $pp->idPedido === $pedido->id){
                                $total += floatval($producto->precio) * floatval($pp->cantidad);
                            }
                        }
                    }?>
                    <?php echo "€" . $total; ?>
                </td>
                <td class="celda" data-titulo="Estado:">
                    <?php foreach($estados as $estado) {
                        if($estado->id === $pedido->idEstado){
                            echo $estado->nombre;
                        }
                    }
                    ?>
                </td>
                <td class="celda" data-titulo="...:">
                    <!-- Boton para ver la informacion del pedido -->
                    <a href="/ver-pedido?id=<?php echo $pedido->id; ?>" class="btn-ver">Ver</a>
                </td>
            </tr>
            <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
    <h2>Acreditados</h4>
    <!-- Pedido acreditados (la varible $acreditados viene del HomePageController) -->
    <?php if($acreditados != 0): ?>
    <table class="tabla-pedidos contenedor">
        <thead>
            <tr>
                <th class="celda">#</th>
                <th class="celda">Fecha</th>
                <th class="celda">Total</th>
                <th class="celda">Estado</th>
                <th class="celda">...</th>
            </tr>
        </thead>
        <?php else: ?>
            <!-- Si no hay pedidos acreditados -->
                <h3 class="off-carrito">No hay pedidos acreditados</h3> 
            <?php endif?>;
        <tbody>
            <?php $i = 0; //Variable indice
            foreach($pedidos as $pedido): ?>
            <?php if($pedido->idUsuario === $_SESSION['usuario'] && $pedido->idEstado === $estados[0]->id): ?>
                <!-- Se listan los pedidos realizados por el usuario, que ya han sido acreditados -->
            <tr class="fila-pedido">
                <td class="celda" data-titulo="Fecha:"><?php echo $i+=1; ?></td>
                <td class="celda" data-titulo="Fecha:"><?php  echo fechaEnEspañol($pedido->fecha); ?></td>

                <td class="celda" data-titulo="Total:">
                    <?php $total = 0; foreach($pedidosProductos as $pp){
                        
                        foreach($productos as $producto) {
                            if($producto->id === $pp->idProducto && $pp->idPedido === $pedido->id){
                                $total += floatval($producto->precio) * floatval($pp->cantidad);
                            }
                        }
                    }?>
                    <?php echo "€" . $total; ?>
                </td>
                <td class="celda" data-titulo="Estado:">
                    <?php foreach($estados as $estado) {
                        if($estado->id === $pedido->idEstado){
                            echo $estado->nombre;
                        }
                    }
                    ?>
                </td>
                <td class="celda" data-titulo="...:">
                    <!-- Boton para ver la informacion del pedido -->
                    <a href="/ver-pedido?id=<?php echo $pedido->id; ?>" class="btn-ver">Ver</a>
                </td>
            </tr>
            <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php $lleno = false; //La variable $lleno cambia a false para que el primer if del foreach principal no vuelva a ejecutarse ?>
    <?php endif; ?>
    <?php endforeach; ?>
    <?php if($pendientes === 0 && $acreditados === 0): ?>
        <!-- En caso de que el usuario aun no haya realizado ningún pedido -->
        <h3 class="off-carrito">No ha realizado ningun pedido</h3> 
        <section>
            <a href="/" class="btn-volver">Inicio</a>
        </section>
    <?php endif; ?>
    
</section>