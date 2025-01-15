<div class="contenedor">
<h1 class="titulo-pagina">Bienvenidos a nuestra tienda</h1>
<div id="seccion-elegir">
    
    <?php if($id === 1 || $id === 0): ?>
        <h3 id="enlace-alfombras" class="activo">Alfombras</h3>
        <h3 id="enlace-tapices">Tapices</h3>
    <?php elseif($id === 2): ?>
        <h3 id="enlace-alfombras">Alfombras</h3>
        <h3 id="enlace-tapices" class="activo">Tapices</h3>
    <?php endif; ?>
</div>
</div>
<div class="img-background-2">
<section class="contenedor-alfombras" id="seccion-alfombras" >
    <h2>ALFOMBRAS</h2>
    <div class="contenedor-productos contenedor">
        <?php include 'listado-alfombras.php'; ?>
    </div>
</section>
</div>
<div class="img-background-3">
<section class="contenedor-tapices inactivo" id="seccion-tapices" >
    <h2>tapices</h2>
    <div class="contenedor-productos contenedor">
        <?php include 'listado-tapices.php'; ?>
    </div>
</section>
</div>
