<?php

/**
 * Controlador para el carrito de compras.
 * 
 * Este controlador maneja las acciones relacionadas con el carrito de compras, como agregar productos, vaciar el carrito, eliminar productos, confirmar la compra, etc.
 * 
 */
namespace Controllers;

use MVC\Router;
use Model\Estado;
use Model\Pedido;
use Model\Producto;
use Model\Categoria;
use Model\Transacciones;
use Model\PedidosProductos;

class CarritoController {

    // Funcion principal del carrito, relacionada con la vista principal
    public static function carrito(Router $router) {
        session_start();

        $productos = Producto::all();
        $categorias = Categoria::all();

        // Obtengo todos los productos y categorias para usarlos en la vista
        $router->render('home/carrito', [
            'productos' => $productos,
            'categorias' => $categorias
        ]);
    }

    // Funcion para agregar un producto al carrito desde la tienda
    public static function getproducto(Router $router) {
        session_start();

        // Obtengo el id del producto que necesito
        $id = validarORedireccionar("/");

        $producto = Producto::find($id);
        $producto_array = '';
        $categorias = Categoria::all();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Logica para agregar un producto al carrito
            $cantidadProducto = $_POST['cantidad-p'];

            // Si la variable de sesión CARRITO no existe, se crea, y dentro se guarda un array con la informacion del producto
            if (!isset($_SESSION['CARRITO'])) {

                $producto_array = array(
                    'ID' => $producto->id,
                    'NOMBRE' => $producto->nombre,
                    'IMAGEN' => $producto->imagen,
                    'PRECIO' => $producto->precio,
                    'CANTIDAD' => $cantidadProducto
                );
                $_SESSION['CARRITO'][0] = $producto_array;
            } else {
                // En caso que la variable de sesión CARRITO ya exista, se guarda un array con la informacion del producto, en la ultima posicion del carrito
                $producto_array = array(
                    'ID' => $producto->id,
                    'NOMBRE' => $producto->nombre,
                    'IMAGEN' => $producto->imagen,
                    'PRECIO' => $producto->precio,
                    'CANTIDAD' => $cantidadProducto
                );

                $_SESSION['CARRITO'][] = $producto_array;
            }

            $tmp = $categorias[0]->id;
            // Se redirige al usuario a la tienda
            header("Location: /tienda?id=" . $tmp);
        }

        // Esta funcion esta relacionada con la vista del producto
        $router->render('home/producto', [
            'producto' => $producto,
            'producto_array' => $producto_array,
            'categorias' => $categorias
        ]);
    }

    // Funcion para vaciar el carrito, recorre el array del carrito y borra todo lo que haya
    public static function vaciarCarrito() {
        session_start();

        foreach ($_SESSION['CARRITO'] as $key => $prod) {
            unset($_SESSION['CARRITO'][$key]);
        }

        // Redirige al usuario al carrito
        header('Location: /carrito');
    }

    // Funcion para eliminar un solo producto del carrito
    public static function eliminar() {
        session_start();

        // Obtiene el id del producto a eliminar
        $idProductoAEliminar = $_POST['id'];

        if (isset($_POST['url'])) {
            $url = $_POST['url'];
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Elimina del carrito el producto seleccionado
            foreach ($_SESSION['CARRITO'] as $key => $prod) {
                if ($prod['ID'] === $idProductoAEliminar) {
                    unset($_SESSION['CARRITO'][$key]);
                }
            }
        }

        // Obtener la URL anterior si está disponible
        $url_anterior = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';

        // Obtener solo la parte de la ruta de la URL anterior
        $componentes_url = parse_url($url_anterior);
        $url_final = isset($componentes_url['path']) ? $componentes_url['path'] : '';

        if ($url_final == '/carrito') {
            // Si el producto se elimina del carrito desde la pagina del carrito, redirige al usuario al carrito
            header('Location: /carrito');
        } else {
            // Si el producto se elimina del carrito desde la vista del producto, se redirige al usuario a la misma vista del producto
            header('Location: ' . $url);
        }
    }

    // Funcion para cambiar y confirmar la cantidad a pedir de cada producto
    public static function conf_cantidad() {
        session_start();

        // Lee y guarda lo que hay en la variable $_POST
        $cantidad = $_POST['cantidad'];
        $idProd = $_POST['id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Para cada producto se actualiza la cantidad a pedir, se guarda, y se muestra en el carrito
            foreach ($_SESSION['CARRITO'] as $key => $prod) {
                if ($prod['ID'] === $idProd) {
                    $_SESSION['CARRITO'][$key]['CANTIDAD'] = $cantidad;
                }
            }
        }

        // Redirige al usuario al carrito
        header('Location: /carrito');
    }

    // Esta funcion es para confirmar el pedido e ir a pagar
    public static function confirmar() {
        session_start();

        // Verificar si el usuario ha iniciado sesión
        if (!isset($_SESSION['usuario'])) {
            // Redirigir al usuario a la página de inicio de sesión
            header('Location: /login');
            return;
        }

        $estado = Estado::findLast();
        $pedido = new Pedido();
        $pedidosProductos = new PedidosProductos();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Se guardan los datos del pedido
            $infoPedido = array();
            $pedido->idUsuario = $_SESSION['usuario'];
            $pedido->referencia = uniqid();
            $pedido->idEstado = $estado->id;
            // Se guarda el pedido en la base de datos
            $pedido->guardar();

            // Se busca en la base de datos el pedido que se guardo recién
            $p = Pedido::findLast();
            $pedido->id = $p->id;

            foreach ($_SESSION['CARRITO'] as $key => $prod) {
                // Se guardan los productos del pedido y la cantidad a pedir
                $producto = [
                    'id' => $prod['ID'],
                    'cantidad' => $prod['CANTIDAD']
                ];
                $infoPedido[] = $producto;
            }

            foreach ($infoPedido as $key => $prod) {
                // Para cada producto en el pedido
                $pedidosProductos->idPedido = $pedido->id;
                $pedidosProductos->idProducto = $infoPedido[$key]['id'];
                $pedidosProductos->cantidad = $infoPedido[$key]['cantidad'];
                // Se termina de guardar toda la informacion del pedido en la base de datos
                $pedidosProductos->guardar();
            }
        }

        // Se redirige al usuario a la pagina para pagar el pedido que acaba de realizar
        header('Location: /pagar?id=' . $pedido->id);
    }

    // Funcion que se encarga de guardar los datos de la transaccion una vez realizada
    public static function guardarTransaccion() {
        // Recibe los datos de la transacción   
        $data = json_decode(file_get_contents('php://input'), true);
        if ($data !== null) {
            $orderID = $data['orderID'];
        } else {
            $orderID = '';
        }

        session_start();

        // Lee lo que hay en la variable de sesión y lo guarda en la variable $id, para luego buscar el pedido por el id
        $id = $_SESSION['Transaccion'][0];
        $pedido = Pedido::find($id);

        // Crea una nueva transacción y la guarda en la base de datos
        $transaccion = new Transacciones();
        $transaccion->orderID = $orderID;
        $transaccion->pedidoID = $pedido->id;
        if ($orderID != '') {
            $transaccion->guardar();
            self::vaciarCarrito();
            $pedido->idEstado = '1';
            $pedido->guardar();
        }
    }

    // Funcion que se encarga de poder hacer el pago del pedido
    public static function pagar(Router $router) {
        session_start();

        // Para pagar, el usuario necesita estar logueado
        isAuth();

        $id = validarORedireccionar("/");

        // Se guarda el id del pedido en una variable de sesión
        $_SESSION['Transaccion'][0] = $id;

        $categorias = Categoria::all();
        $pedido = Pedido::find($id);
        $productos = Producto::all();
        $pedidosProductos = PedidosProductos::all();

        // Variables que se mandan a la vista de pagar
        $router->render('home/pagar', [
            'pedido' => $pedido,
            'productos' => $productos,
            'pedidosProductos' => $pedidosProductos,
            'categorias' => $categorias
        ]);
    }
}
