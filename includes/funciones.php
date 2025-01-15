<?php

use Model\Estado;
use Model\Categoria;
use Model\Usuario;

define('TEMPLATES_URL', __DIR__ . '/templates');
define('FUNCIONES_URL', __DIR__ . '/funciones.php');
define('CARPETA_IMAGENES', $_SERVER['DOCUMENT_ROOT'] . '/imagenes/');

function incluirTemplate(string $nombre, bool $inicio = false)
{
    include TEMPLATES_URL . "/{$nombre}.php";
}

// Funcion que revisa si el usuario esta autenticado
function estaAutenticado()
{
    // Inicia la sesion
    session_start();

    // Si la sesion esta iniciada
    if (!$_SESSION['login']) {
        header('Location: /');
    }
}

function debugear($variable)
{
    echo '<pre>';
    var_dump($variable);
    echo '</pre>';
    exit;
}

// Escapa / Sanitiza el HTML
function s($html): string
{
    $s = htmlspecialchars($html);
    return $s;
}

// Valida tipo de contenido
function validarTipoContenido($tipo)
{
    $tipos = ['producto'];
    return in_array($tipo, $tipos);
}

// Muestra los resultados
function mostrarNotificacion($codigo)
{
    $mensaje = '';
    switch ($codigo) {
        case 1:
            $mensaje = 'Creado correctamente';
            break;
        case 2:
            $mensaje = 'Actualizado correctamente';
            break;
        case 3:
            $mensaje = 'Eliminado correctamente';
            break;
        default:
            $mensaje = false;
            break;
    }
    return $mensaje;
}

function validarORedireccionar(string $url)
{
    // Validar que sea un ID valido
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if (!$id) {
        header("Location: {$url}");
    }

    return $id;
}

// En caso de que las categorias y los estados no esten en la base de datos, esta función los crea automaticamente
function crearCategoriasyEstados()
{
    $categorias = Categoria::all();
    $res = 0;

    foreach ($categorias as $categoria) {
        $res += 1;
    }

    if ($res === 0) {
        $alfombra = new Categoria();
        $alfombra->nombre = "Alfombra";
        $alfombra->guardar();
        $tapiz = new Categoria();
        $tapiz->nombre = "Tapiz";
        $tapiz->guardar();
    }

    $estados = Estado::all();
    $res = 0;

    foreach ($estados as $estado) {
        $res += 1;
    }

    if ($res === 0) {
        $confirmado = new Estado();
        $confirmado->nombre = "Acreditado";
        $confirmado->guardar();
        $pendiente = new Estado();
        $pendiente->nombre = "Pendiente";
        $pendiente->guardar();
    }
}

// Funcion que revisa si el usuario esta logueado
function isAuth(): void
{
    if (!isset($_SESSION['usuario'])) {
        header('Location: /');
    }
}

// Funcion que revisa si el usuario esta logueado
function isAdmin(): void
{
    if (isAuth()) {
        header('Location: /');
    } else {
        $id = $_SESSION['usuario'];
        $usuario = Usuario::find($id);

        if ($usuario->admin !== "1") {
            header("Location: /");
        }
    }
}