<?php 

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\AdminController;
use Controllers\LoginController;
use Controllers\CarritoController;
use Controllers\HomePageController;
$router = new Router();

//Proteger Rutas

//Home Page
$router->get('/', [HomePageController::class, 'index']);
$router->get('/tienda', [HomePageController::class, 'tienda']);
$router->get('/contacto', [HomePageController::class, 'contacto']);
$router->post('/contacto', [HomePageController::class, 'contacto']);
$router->get('/pedidos', [HomePageController::class, 'misPedidos']);
$router->post('/pedidos', [HomePageController::class, 'misPedidos']);
$router->get('/ver-pedido', [HomePageController::class, 'verPedido']);
$router->post('/ver-pedido', [HomePageController::class, 'verPedido']);
$router->post('/eliminar-pedido', [HomePageController::class, 'eliminarPedido']);

//Iniciar Sesion
$router->get('/login', [LoginController::class, 'index']);
$router->post('/login', [LoginController::class, 'index']);
$router->get('/logout', [LoginController::class, 'logout']);

//Recuperar Password
$router->get('/olvide', [LoginController::class, 'olvide']);
$router->post('/olvide', [LoginController::class, 'olvide']);
$router->get('/recuperar', [LoginController::class, 'recuperar']);
$router->post('/recuperar', [LoginController::class, 'recuperar']);

//Crear Cuenta
$router->get('/crear-cuenta', [LoginController::class, 'crear']);
$router->post('/crear-cuenta', [LoginController::class, 'crear']);

//Confirmar Cuenta
$router->get('/confirmar-cuenta', [LoginController::class, 'confirmar']);
$router->get('/mensaje', [LoginController::class, 'mensaje']);

//Carrito
$router->get('/carrito', [CarritoController::class, 'carrito']);
$router->post('/carrito', [CarritoController::class, 'carrito']);
$router->get('/producto', [CarritoController::class, 'getproducto']);
$router->post('/producto', [CarritoController::class, 'getproducto']);
$router->post('/vaciar-carrito', [CarritoController::class, 'vaciarCarrito']);
$router->post('/carrito/eliminar', [CarritoController::class, 'eliminar']);
$router->post('/carrito/cantidad', [CarritoController::class, 'conf_cantidad']);
$router->post('/carrito/confirmar', [CarritoController::class, 'confirmar']);
$router->post('/carrito/eliminar-pedido-carrito', [CarritoController::class, 'eliminarPedidoCarrito']);

//Pago
$router->get('/pagar', [CarritoController::class, 'pagar']);
$router->post('/pagar', [CarritoController::class, 'pagar']);
$router->post('/guardarTransaccion', [CarritoController::class, 'guardarTransaccion']);


//Admin Dashboard
$router->get('/admin', [AdminController::class, 'dashboard']);
$router->post('/admin', [AdminController::class, 'dashboard']);

//admin crud
$router->get('/admin/productos', [AdminController::class, 'admin']);
$router->post('/admin/productos', [AdminController::class, 'admin']);
$router->get('/admin/crear', [AdminController::class, 'crear']);
$router->post('/admin/crear', [AdminController::class, 'crear']);
$router->get('/admin/actualizar', [AdminController::class, 'actualizar']);
$router->post('/admin/actualizar', [AdminController::class, 'actualizar']);
$router->post('/admin/eliminar', [AdminController::class, 'eliminar']);

//Admin Uusuarios
$router->get('/admin/usuarios', [AdminController::class, 'usuarios']);
$router->post('/admin/usuarios', [AdminController::class, 'usuarios']);
$router->post('/admin/usuarios-act', [AdminController::class, 'usuariosAct']);
$router->post('/admin/usuarios-el', [AdminController::class, 'usuariosEliminar']);

//Admin Ordenes
$router->get('/admin/ordenes', [AdminController::class, 'ordenes']);
$router->post('/admin/ordenes', [AdminController::class, 'ordenes']);

// //AREA PRIVADA
//     $router->get('/cita', [CitaController::class, 'index'] );
//     $router->get('/admin', [AdminController::class, 'index'] );



// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();