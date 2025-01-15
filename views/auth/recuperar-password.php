


<div class="img-background">
    <h1 class="nombres-pagina">Recuperar Password</h1>

    <section class="container-login contenedor">
    <?php 
    // Incluye las alertas para el formulario
    include_once __DIR__ . '../../templates/alertas.php';
?>
        <div>
            <!-- Formulario para reestablecer la contrseña -->
            <form method="post">
            
                <label for="password">Password</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    placeholder="Tu Password"
                />
            
                <input type="submit" value="Restablecer Password">
            </form>
            
            <div class="acciones">
                <a href="crear-cuenta">Crear cuenta</a><br>
                <a href="olvide">Iniciar Sesion</a>
            </div>
        </div>
    </section>
</div>