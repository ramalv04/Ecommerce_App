
<div class="img-background">
<h1 class="nombres-pagina">Restablecer Password</h1>
<section class="container-login contenedor">
<!-- Incluye las alertas para el formulario -->
<?php include_once __DIR__ . '../../templates/alertas.php'; ?>
    <div>
        <!-- Formulario para reestablecer la contraseña en caso de olvidarla -->
        <form class="" action="olvide" method="post">

            <label for="email">Email:</label><br>
            <input 
            type="email" 
            id="email" 
            name="email"
            placeholder="Tu Email"
            /><br>
            
            <input type="submit" value="Restablecer Password">
        </form>
        <div class="acciones">
            <a href="login">Inicia Sesión</a><br>
            <a href="crear-cuenta">Regístrate</a>
        </div>
    </div>
</section>
</div>
