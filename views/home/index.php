<main>
    <div class="contenedor-principal">
        <div class="txt">
            <h1>Decoración de interiores</h1>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi nihil, perferendis veniam voluptates atque suscipit quidem vel voluptate odit nostrum, error enim reprehenderit officiis aspernatur placeat, debitis obcaecati non quibusdam.</p>
        </div>
    </div>
</main>

<section class="categorias">
    <h2>Categorias</h2>
    <h4>Lorem ipsum dolor sit amet consectetur adipisicing elit.</h3>

        <div class="contenedor-categorias">
            <!-- Boton que te dirige hacia la tienda a la sección de alfombras -->
            <a href="/tienda?id=<?php echo $categorias[0]->id ?>">
                <div class="categoria alfombra">
                    <p>Alfombras</p>
                </div>
            </a>
            <!-- Boton que te dirige hacia la tienda a la sección de tapices -->
            <a href="/tienda?id=<?php echo $categorias[1]->id ?>" id="boton-tapices-index">
                <div class="categoria tapiz">
                    <p>Tapices</p>
                </div>
            </a>
        </div>
</section>

<section class="nuevos-productos">
    <h2>Nuevos Productos</h2>
    <div class="contenedor-productos contenedor">
        <!-- Se listan 4 productos en la pagina principal, 2 alfombras y 2 tapices -->
        <?php include 'listado-alfombras.php'; ?>
        <?php include 'listado-tapices.php'; ?>
    </div>
    <!-- Boton para ver todos los productos en la tienda -->
    <a href="/tienda?id=<?php echo $categorias[0]->id ?>" class="btn-producto">Ver todos los productos</a>
            
</section>
