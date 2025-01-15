<!-- Incluye la barra lateral del admin -->
<?php require __DIR__ . '../../../includes/templates/admin.php'; ?>

<section class="contenido-principal dashboard ">
    <h1>Dashboard</h1>
    <div class="data-cards">
        <div class="data-card">
            <!-- Muestra la cantidad de usuarios registrados -->
            <h2>Usuarios</h2>
            <p><?php echo count($usuarios); ?></p>
        </div>
        <div class="data-card">
            <!-- Muestra la cantidad de productos activos en la tienda -->
            <h2>Productos</h2>
            <p><?php echo count($productos); ?></p>
        </div>
        <div class="data-card">
            <!-- Muestra la cantidad de categorías -->
            <h2>Categorias</h2>
            <p><?php echo count($categorias); ?></p>
        </div>
        <div class="data-card">
            <h2>Recaudado</h2>
            <p>€<?php echo $totalRecaudado ?></p>
        </div>
        <div class="data-card">
            <h2>Alfombras</h2>
            <p><?php echo $alfombras; ?></p>
        </div>
        <div class="data-card">
            <h2>Tapices</h2>
            <p><?php echo $tapices; ?></p>
        </div>
         <div class="data-card">
            <h2>Pedidos Totales</h2>
            <p><?php echo $pendientes + $acreditados; ?></p>
        </div>
        <div class="data-card">
            <h2>Pedidos Acreditados</h2>
            <p><?php echo $acreditados; ?></p>
        </div>
        <div class="data-card">
            <h2>Pedidos Pendientes</h2>
            <p><?php echo $pendientes; ?></p>
        </div>
    </div>
</section>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
$(document).ready(function() {
  $('.data-card').hover(
    function() {
      $(this).animate({marginTop: "-=1%"}, 200);
    },
    function() {
      $(this).animate({marginTop: "+=1%"}, 200);
    }
  );
});
</script>