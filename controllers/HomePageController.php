<?php

namespace Controllers;

use MVC\Router;
use Model\Estado;
use Model\Pedido;
use Model\Usuario;
use Model\Producto;
use Model\Categoria;
use Model\ActiveRecord;
use Model\PedidosProductos;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\PHPMailer;

class HomePageController {

    public static function index(Router $router) {
        session_start();

        // crea automaticamente en la base de datos las categorias de alfombra y tapiz, y tambien los estados de confirmado y pendiente
        crearCategoriasyEstados();

        $productos = Producto::get(4);
        $categorias = Categoria::all();

        $router->render('home/index', [
            'productos' => $productos,
            'categorias' => $categorias
        ]);
    }

    public static function tienda(Router $router) {
        session_start();
        $productos = Producto::all();
        $categorias = Categoria::all();

        $id = validarORedireccionar("/");

        $router->render('home/tienda', [
            'productos' => $productos,
            'categorias' => $categorias,
            'id' => $id
        ]);
    }

    public static function contacto(Router $router) {
        session_start();
        $mensaje = null;

        $categorias = Categoria::all();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Configurar SMTP
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Port = 2525;
            $mail->Username = '9dc3f73f27d6d8';
            $mail->Password = '2152d332fb6b93';
            $mail->SMTPAuth = true;

            // Configurar el contenido del mail
            $mail->setFrom('admin@bienesraices.com');
            $mail->addAddress('admin@ecoomerceApp.com', 'ecommerceApp.com');
            $mail->Subject = 'Tienes un nuevo mensaje';

            // Habilitar HTML
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';

            // Definir el contenido del mail
            $contenido = '<html>';
            $contenido .= '<body style="background-color: #f0f0f0; font-family: Arial, sans-serif; text-align: center;">';
            $contenido .= '<div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 20px; border-radius: 5px;">';
            $contenido .= '<h1 style="color: #333333;">Tienes un nuevo mensaje</h1>';
            $contenido .= '<p>Nombre: ' . $_POST['contacto']['nombre'] . " " . $_POST['contacto']['apellido'] . '</p>';

            // El usuario prefiere ser contactado por email
            $contenido .= '<p>Correo: ' . $_POST['contacto']['email'] . '</p>';

            $contenido .= '<p>Mensaje: ' . $_POST['contacto']['mensaje'] . '</p>';
            $contenido .= '</div>';
            $contenido .= '</body>';
            $contenido .= '</html>';

            $mail->Body = $contenido;
            // Enviar el mensaje
            if ($mail->send()) {
                $mensaje = 'Mensaje enviado';
            } else {
                $mensaje = "El mensaje no se pudo enviar";
            }
        }

        $router->render('home/contacto', [
            'mensaje' => $mensaje,
            'categorias' => $categorias
        ]);
    }

    public static function misPedidos(Router $router) {
        session_start();

        isAuth();

        $categorias = Categoria::all();
        $usuarios = Usuario::all();
        $pedidos = Pedido::all();
        $productos = Producto::all();
        $pedidosProductos = PedidosProductos::all();
        $estados = Estado::all();
        $acreditados = 0;
        $pendientes = 0;

        foreach ($pedidos as $pedido) {
            if ($pedido->idUsuario === $_SESSION['usuario']) {
                if ($pedido->idEstado === $estados[0]->id) {
                    $acreditados++;
                } else if ($pedido->idEstado === $estados[1]->id) {
                    $pendientes++;
                }
            }
        }

        $router->render('home/pedidos', [
            'pedidos' => $pedidos,
            'usuarios' => $usuarios,
            'productos' => $productos,
            'pedidosProductos' => $pedidosProductos,
            'estados' => $estados,
            'acreditados' => $acreditados,
            'pendientes' => $pendientes,
            'categorias' => $categorias
        ]);
    }

    public static function verPedido(Router $router) {
        session_start();

        isAuth();

        $id = validarORedireccionar("/");

        $categorias = Categoria::all();
        $pedido = Pedido::find($id);
        $productos = Producto::all();
        $pedidosProductos = PedidosProductos::all();
        $estados = Estado::all();

        $router->render('home/ver-pedidos', [
            'pedido' => $pedido,
            'productos' => $productos,
            'pedidosProductos' => $pedidosProductos,
            'estados' => $estados,
            'categorias' => $categorias
        ]);
    }

    public static function eliminarPedido() {
        session_start();

        isAuth();

        $users = Usuario::all();
        $idPedido = $_POST['id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $pedido = Pedido::find($idPedido);
            $pedido->eliminar();
        }

        foreach ($users as $user) {
            if ($user->id === $_SESSION['usuario']) {
                // debugear(($user->admin === 1));
                if ($user->admin === '1') {
                    header('Location: /admin/ordenes?resultado=3');
                } else {
                    header("Location: /pedidos");
                }
            }
        }
    }
}