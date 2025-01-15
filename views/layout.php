<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecommerce App</title>
    <!--CSS -->
    <link rel="stylesheet" href="/build/css/base/normalize.css">
    <link rel="stylesheet" href="/build/css/base/headerYfooter.css">
    <link rel="stylesheet" href="/build/css/base/variables.css">
    <link rel="stylesheet" href="/build/css/base/globales.css">
    <link rel="stylesheet" href="/build/css/layout/homepage.css">
    <link rel="stylesheet" href="/build/css/layout/tienda.css">
    <link rel="stylesheet" href="/build/css/layout/carrito.css">
    <link rel="stylesheet" href="/build/css/layout/contacto.css">
    <link rel="stylesheet" href="/build/css/layout/login.css">
    <link rel="stylesheet" href="/build/css/layout/admin.css">
    <link rel="stylesheet" href="/build/css/layout/perfil.css">
    <link rel="stylesheet" href="/build/css/layout/pedidos.css">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;700;900&display=swap" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&family=Rubik+Scribble&family=Workbench:BLED@0..100&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Muestra el header siempre, al menos que se cambie a false -->
    <?php 
    if (!isset($showHeaderFooter) || $showHeaderFooter !== false) {
        require __DIR__ . '../../includes/templates/header.php'; 
    }
    ?>

    <div class="">
        <div class="app">
            <?php echo $contenido; ?>
        </div>
    </div>

    <!-- Muestra el footer siempre, al menos que se cambie a false -->
    <?php 
    if (!isset($showHeaderFooter) || $showHeaderFooter !== false) {
        require __DIR__ . '../../includes/templates/footer.php'; 
    }
    ?>

    <script src="/build/js/app.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/eb496ab1a0.js" crossorigin="anonymous"></script>
</body>
</html>