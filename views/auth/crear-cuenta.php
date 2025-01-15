<div class="img-background">
<h1 class="nombres-pagina">Crear Cuenta</h1>

<section class="container-login contenedor">
    <!-- Incluye las alertas para el formulario -->
<?php include_once __DIR__ . '../../templates/alertas.php'; ?>
    <div>
        <!-- Formulario para registrarse en la página -->
        <form class="" action="" method="POST">
            <label for="nombre">Nombre:</label><br>
            <input 
            type="text" 
            id="nombre" 
            name="nombre"
            placeholder="Tu Nombre"
            /><br>

            <label for="apellido">Apellido:</label><br>
            <input 
            type="text" 
            id="apellido" 
            name="apellido"
            placeholder="Tu Apellido"
            /><br>

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
            placeholder="Tu Contraseña"
            /><br>
            
            <input type="submit" value="Crear Cuenta">
        </form>
        <div class="acciones">
        <a href="login">Ya tienes una cuenta? Inicia Sesion</a><br>
        <a href="olvide">Olvidaste tu contraseña</a>
        </div>
    </div>
</section>
</div>