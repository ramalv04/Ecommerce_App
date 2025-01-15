<header>
    <div class="contenedor-navegacion">
        <h1><a href="/">Ecommerce</a></h1>
        <button class="hamburgesa-menu">
            <img src="../build/img/iconos/hamburgesaMenu.svg" alt="Menu">
        </button>
        
        <nav class="navegacion">
            <div class="menu-navegacion">
                <a href="/tienda?id=<?php echo $categorias[0]->id ?>">Tienda</a>
                <a href="/contacto">Contacto</a>
                <div class="no-grow">
                    <a href="/carrito">
                        <img src="../build/img/iconos/carrito-de-compra.svg" alt="carrito de compra" class="img-header">(<?php
                        echo (empty($_SESSION['CARRITO'])) ? 0 : count($_SESSION['CARRITO']);
                        ?>)
                    </a>
                    <?php $isAuthenticated = $_SESSION['login'] ?? false; ?>
                    <div class="dropdown">
                        <a href="#">
                            <?php if($isAuthenticated): ?>
                                <img src="../build/img/iconos/profile2.svg" alt="Profile Imagen" class="img-header">
                            <?php else: ?>
                                <img src="../build/img/iconos/profile.svg" alt="Profile Imagen" class="img-header">
                            <?php endif; ?>
                        </a>
                        <div class="dropdown-content">
                            <?php if (!$isAuthenticated): ?>
                                <a href="/login">Iniciar Sesion</a>
                                <a href="/crear-cuenta">Registrarse</a>
                            <?php endif; ?>
                            <?php if ($isAuthenticated): ?>
                                <?php if ($_SESSION['admin'] ?? null === '1'): ?>
                                    <a href="/admin">Ir al panel</a>
                                <?php endif; ?>
                                <a href="/pedidos">Mis pedidos</a>
                                <a href="/logout">Cerrar Sesion</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>