<main class="seccion">
    <h1>Contacto</h1>
    <h3>Llene el formulario de Contacto</h3>

    <img loading="lazy" class="img-contactar" src="/build/img/tapices/4.webp" alt="Imagen Contacto">

    <form class="formulario contenedor" method="POST">

        <fieldset>
            <legend>Información Personal</legend>

            <label for="nombre">Nombre</label>
            <input type="text" placeholder="Tu Nombre" id="nombre" name="contacto[nombre]">

            <label for="nombre">Apellido</label>
            <input type="text" placeholder="Tu Apellido" id="apellido" name="contacto[apellido]">

            <label for="contactar-email">E-mail</label>
            <input name="contacto[email]" type="email" value="" id="contactar-email">

            <label for="mensaje">Mensaje:</label>
            <textarea id="mensaje" name="contacto[mensaje]"></textarea>
        </fieldset>

        <input type="submit" value="Enviar">

    </form>
</main>