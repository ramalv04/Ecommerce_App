<?php
/**
 * Controlador para la administración del sitio.
 * 
 * Este controlador contiene métodos para administrar diferentes aspectos del sitio, como la visualización y creación de productos, gestión de usuarios y pedidos, y generación de informes.
 * 
 */
namespace Controllers;

use MVC\Router;
use Model\Usuario;
use Model\Producto;
use Vonage\Meetings\Room;
use Intervention\Image\ImageManagerStatic as Image;
use Model\Categoria;
use Model\Estado;
use Model\Pedido;
use Model\PedidosProductos;

    class AdminController {
        public static function admin(Router $router) {
            session_start();

            isAdmin();

            // Captura el parámetro de ordenamiento desde la URL
            $orden = $_GET['orden'] ?? null;

            // Ordena los productos en base al parámetro de ordenamiento
            switch ($orden) {
                case 'precio_asc':
                    $producto = Producto::orderBy('precio', 'desc');
                    break;
                case 'precio_desc':
                    $producto = Producto::orderBy('precio', 'asc');
                    break;
                case 'fecha_asc':
                    $producto = Producto::orderBy('fecha', 'desc');
                    break;
                case 'fecha_desc':
                    $producto = Producto::orderBy('fecha', 'asc');
                    break;
                default:
                    $producto = Producto::all();
                    break;
            }

            $alertas = Producto::getAlertas();
            $categorias = Categoria::all();

            //muestra mensaje condicional
            $resultado = $_GET['resultado'] ?? null;

            $router->render('admin/productos',[
                'producto' => $producto,
                'resultado'=> $resultado,
                'categorias' => $categorias,
                'alertas' => $alertas,
                'showHeaderFooter' => false
            ]);
        }

        public static function crear(Router $router) {
            session_start();

            isAdmin();

            $producto = new Producto();
            $categorias = Categoria::all();
            $alertas = Producto::getAlertas();
    
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
    
                //Crear una nueva instancia
                $producto = new Producto($_POST['producto']);
                
                //Generar un nombre unico
                $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";

                //Realiza un resize a la imagen con intervention
                if($_FILES['producto']['tmp_name']['imagen']) {
                $image = Image::make($_FILES['producto']['tmp_name']['imagen'])->fit(800,600);
                $producto->setImagen($nombreImagen);
            }
    
                //validar
                $alertas = $producto->validar();

                if(empty($alertas)) {
    
                    //Crear carpeta
                    if(!is_dir(CARPETA_IMAGENES)) {
                        mkdir(CARPETA_IMAGENES);
                    }
        
                    //Guarda la imagen en el servidor
                    $image->save(CARPETA_IMAGENES . $nombreImagen);
            
                    //Guardar en la base de datos
                    $producto->guardar();

                    header('Location: /admin/productos?resultado=1');
                }
            }


            $router->render('admin/crear',[
                'producto' => $producto,
                'categorias' => $categorias,
                'alertas' => $alertas,
                'showHeaderFooter' => false
            ]);
        }

        public static function actualizar(Router $router) {
            session_start();

            isAdmin();

            $id = validarORedireccionar('/admin');
            $producto = Producto::find($id);
            $categorias = Categoria::all();
            $alertas = Producto::getAlertas();

            //Metodo post para actualizar
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                //Asignar los atributos
                $args = $_POST['producto'];

                $producto->sincronizar($args);

                //Validacion
                $alertas = $producto->validar();

                //Subida de archivos
                //Generar un nombre unico
                $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

                //realiza un resize a la imagen con intervention
                if ($_FILES['producto']['tmp_name']['imagen']) {
                    $image = Image::make($_FILES['producto']['tmp_name']['imagen'])->fit(800, 600);
                    $producto->setImagen($nombreImagen);
                }

                //Revisar que el arreglo de errores este vacio
                if (empty($alertas)) {
                    if ($_FILES['producto']['tmp_name']['imagen']) {
                        //almacenar la imagen
                        $image->save(CARPETA_IMAGENES . $nombreImagen);
                    }

                    $producto->guardar();
                    header('Location: /admin/productos?resultado=2');
                }
            }

            $router->render('admin/actualizar', [
                'producto' => $producto,
                'categorias' => $categorias,
                'alertas' => $alertas,
                'showHeaderFooter' => false
            ]);
        }

        //Funcion para eliminar un producto
        public static function eliminar()
        {
            session_start();

            isAdmin();

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                //Validar ID
                $id = $_POST['id'];
                $id = filter_var($id, FILTER_VALIDATE_INT);

                if ($id) {
                    $tipo = $_POST['tipo'];
                    if (validarTipoContenido($tipo)) {
                        $producto = Producto::find($id);
                        $producto->eliminar();
                        $producto->borrarImagen();
                    }
                }
            }

            header('Location: /admin/productos?resultado=3');
        }

        //Funcion para mostrar el dashboard
        public static function dashboard(Router $router)
        {
            session_start();

            isAdmin();

            $usuarios = Usuario::all();
            $productos = Producto::all();
            $categorias = Categoria::all();
            $pedidos = Pedido::all();
            $pedidosProductos = PedidosProductos::all();
            $estados = Estado::all();
            $totalRecaudado = 0;
            $acreditados = 0;
            $pendientes = 0;
            $alfombras = 0;
            $tapices = 0;

            $alertas = Usuario::getAlertas();

            foreach($pedidos as $pedido){
                foreach($pedidosProductos as $pp){
                    if($pedido->id === $pp->idPedido && $pedido->idEstado === $estados[0]->id){
                        foreach($productos as $producto){
                            if($producto->id === $pp->idProducto){
                                $totalRecaudado += ($producto->precio * $pp->cantidad);
                            }
                        }
                    }
                }
            }

            foreach($pedidos as $pedido){
                if($pedido->idUsuario === $_SESSION['usuario']){
                    if($pedido->idEstado === $estados[0]->id){
                        $acreditados++; 
                    } else if($pedido->idEstado === $estados[1]->id){
                        $pendientes++;
                    }
                }
            }

            foreach($productos as $producto){
                if($producto->idCategoria === $categorias[0]->id){
                    $alfombras++; 
                } else if($producto->idCategoria === $categorias[1]->id){
                    $tapices++;
                }
            }

            $router->render('admin/dashboard',[
                'usuarios' => $usuarios,
                'alertas' => $alertas,
                'productos' => $productos,
                'categorias' => $categorias,
                'totalRecaudado' => $totalRecaudado,
                'pendientes' => $pendientes,
                'acreditados' => $acreditados,
                'alfombras' => $alfombras,
                'tapices' => $tapices,
                'showHeaderFooter' => false
            ]);
        }

        //Funcion para mostrar los usuarios
        public static function usuarios(Router $router) {
            session_start();

            isAdmin();

            $usuarios = Usuario::all();

            $router->render('admin/usuarios',[
                'usuarios' => $usuarios,
                'showHeaderFooter' => false
            ]);
        }

        //Funcion para actualizar el estado de un usuario
        public static function usuariosAct(){
            session_start();

            isAdmin();

            $userID = $_POST['id'];
            $estadoAdmin = $_POST['admin'];
            $usuario = Usuario::find($userID);

            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                $usuario->admin = $estadoAdmin;
                $usuario->guardar();
            }

            header('Location: /admin/usuarios');
        }

        //Funcion para eliminar un usuario
        public static function usuariosEliminar(){
            session_start();
            isAdmin();

            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                $id = $_POST['id'];
                $id = filter_var($id, FILTER_VALIDATE_INT);
                if($id) {
                    $usuario = Usuario::find($id);
                    $usuario->eliminar();
                }
            }
            header('Location: /admin/usuarios?resultado=3');
        }

        //Funcion para mostrar los pedidos
        public static function ordenes(Router $router) {
            session_start();

            isAdmin();

            $usuarios = Usuario::all();
            $pedidos = Pedido::all();
            $productos = Producto::all();
            $pedidosProductos = PedidosProductos::all();
            $estados = Estado::all();

            $router->render('admin/ordenes',[
                'pedidos' => $pedidos,
                'usuarios' => $usuarios,
                'productos' => $productos,
                'pedidosProductos' => $pedidosProductos,
                'estados' => $estados,
                'showHeaderFooter' => false
            ]);
        }
    }
