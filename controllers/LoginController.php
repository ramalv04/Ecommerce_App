<?php

namespace Controllers;

use MVC\Router;
use Classes\Email;
use Model\Usuario;
use Model\Categoria;

class LoginController
{

    //Funcion para iniciar sesion
    public static function index(Router $router)
    {
        $auth = false;
        $isAuthenticated = false;

        $alertas = Usuario::getAlertas();
        $categorias = Categoria::all();

        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $auth = new Usuario($_POST);

            $alertas = $auth->validarLogin();

            if (empty($alertas)) {
                //verificar si el usuario existe
                $usuario = Usuario::where('email', $auth->email);

                if ($usuario) {
                    //comprobar si el password es correcto
                    if ($usuario->comprobarPasswordAndVerificado($auth->password)) {
                        //autenticar el usuario
                        session_start();

                        $_SESSION['usuario'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        $isAuthenticated = true; // Establecer $isAuthenticated a true

                        //redireccionar
                        if ($usuario->admin === "1") {
                            $_SESSION['admin'] = $usuario->admin ?? null;
                            header('Location: /admin');
                        } else {
                            header('Location: /');
                        }
                    }
                } else {
                    Usuario::setAlerta('error', 'El usuario no existe');
                }
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/index', [
            'alertas' => $alertas,
            'categorias' => $categorias,
            'auth' => $isAuthenticated
        ]);
    }

    //Funcion para cerrar sesion
    public static function logout()
    {
        session_start();
        $_SESSION = [];
        header('Location: /');
    }

    //Funcion para olvidar el password
    public static function olvide(Router $router)
    {

        $categorias = Categoria::all();

        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();

            if (empty($alertas)) {
                $usuario = Usuario::where('email', $auth->email);

                if ($usuario && $usuario->confirmado === "1") {
                    $usuario->crearToken(); //generar un token unico
                    $usuario->guardar(); //guardar el token en la base de datos

                    //enviar el email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();

                    Usuario::setAlerta('exito', 'Se ha enviado un email a tu cuenta para reestablecer tu password');
                } else {
                    Usuario::setAlerta('error', 'El usuario no existe o no esta confirmado');
                }
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/olvide-password', [
            'alertas' => $alertas,
            'categorias' => $categorias
        ]);
    }

    //Funcion para recuperar el password
    public static function recuperar(Router $router)
    {
        $categorias = Categoria::all();

        $alertas = [];
        $error = false;

        $token = s($_GET['token']);

        //buscar el usuario por el token
        $usuario = Usuario::where('token', $token);

        if (empty($usuario)) {
            Usuario::setAlerta('error', 'Token no valido');
            $error = true;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = new Usuario($_POST); //Crear un nuevo objeto de usuario
            $alertas = $password->validarPassword(); //Validar el password


            if (empty($alertas)) {


                $usuario->password = null;    //limpiar el password
                $usuario->password = $password->password; //asignar el nuevo password
                $usuario->hashPassword(); //hashear el password
                $usuario->token = ''; //limpiar el token

                $resultado = $usuario->guardar(); //guardar el nuevo password

                if ($resultado) {
                    Usuario::setAlerta('exito', 'Password Actualizado');
                }
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/recuperar-password', [
            'alertas' => $alertas,
            'error' => $error,
            'categorias' => $categorias
        ]);
    }

    public static function crear(Router $router)
    {

        $categorias = Categoria::all();
        $usuario = new Usuario();

        //alertas vacias
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();

            //revisar que el arreglo de alertas este vacio
            if (empty($alertas)) {

                //verificar si el usuario ya existe
                $resultado = $usuario->existeUsuario();

                if ($resultado->num_rows) {
                    $alertas = Usuario::getAlertas();
                } else {

                    $usuario->hashPassword();

                    //generar un token unico
                    $usuario->crearToken();

                    //enviar el email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarConfirmacion();

                    //crear el usuario
                    $resultado = $usuario->guardar();
                    if ($resultado) {
                        header('Location: /mensaje');
                    }
                }
            }
        }

        $router->render('auth/crear-cuenta', [
            'usuario' => $usuario,
            'alertas' => $alertas,
            'categorias' => $categorias
        ]);
    }

    public static function mensaje(Router $router)
    {

        $categorias = Categoria::all();

        $router->render('auth/mensaje', [
            'categorias' => $categorias
        ]);
    }

    public static function confirmar(Router $router)
    {
        $alertas = [];

        $token = s($_GET['token']);
        $categorias = Categoria::all();

        $usuario = Usuario::where('token', $token);

        //debuguear($usuario);

        if (empty($usuario)) {
            //mostrar mensaje de error
            Usuario::setAlerta('error', 'Token no valido');
        } else {
            //modificar a usuario confirmado
            $usuario->confirmado = "1";
            $usuario->token = '';
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta Confirmada Correctamente');
        }

        //obtener alertas
        $alertas = Usuario::getAlertas();

        //renderizar la vista
        $router->render('auth/confirmar-cuenta', [
            'alertas' => $alertas,
            'categorias' => $categorias
        ]);
    }
}