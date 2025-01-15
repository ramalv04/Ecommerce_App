<div class="img-background">
<h1 class="nombres-pagina">Iniciar Sesión</h1>
<section class="container-login contenedor">
<!-- Incluye las alertas para el formulario -->
<?php include_once __DIR__ . '../../templates/alertas.php'; ?>

    <div>
        <!-- Formulario para iniciar sesión -->
        <form class="" action="login" method="post">

            <label for="email">Email:</label><br>
            <input 
            type="email" 
            id="email" 
            name="email"
            placeholder="Tu Email"
            /><br>

            <label for="password">Contraseña:</label><br>
            <input 
            type="password" 
            id="password" 
            name="password"
            placeholder="Tu Password"
            /><br>
            
            <input type="submit" value="Iniciar sesión">
        </form>
        <div class="acciones">
            <a href="crear-cuenta">Crear cuenta</a><br>
            <a href="olvide">Olvidaste tu contraseña</a>
        </div>
    </div>
</section>
</div>
