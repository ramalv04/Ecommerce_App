<?php

namespace Model;

class Usuario extends ActiveRecord {
    protected static $tabla = 'usuario';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password', 'admin', 'confirmado', 'token'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->admin = $args['admin'] ?? '0';
        $this->confirmado = $args['confirmado'] ?? '0';
        $this->token = $args['token'] ?? '';
    }
    // Mensajes de validacion para la creacion de una cuenta
    public function validarNuevaCuenta() {
        if (!$this->nombre) {
            self::$alertas['error'][] = "El Nombre es Obligatorio";
        }
        if (!$this->apellido) {
            self::$alertas['error'][] = "El Apellido es Obligatorio";
        }
        if (!$this->email) {
            self::$alertas['error'][] = "El Email es Obligatorio";
        }
        if (!$this->password) {
            self::$alertas['error'][] = "El Password es Obligatorio ";
        }
        if (strlen($this->password) < 6) {
            self::$alertas['error'][] = "El Password es debe contener al menos 6 caracteres ";
        }
        return self::$alertas;
    }

    public function validarLogin() {
        if(!$this->email) {
            self::$alertas['error'][] = "El Email es Obligatorio";
        }
        if(!$this->password) {
            self::$alertas['error'][] = "El Password es Obligatorio";
        }

        return self::$alertas;
    }

    public function validarEmail() {
        if(!$this->email) {
            self::$alertas['error'][] = "El Email es Obligatorio";
        }
    
        return self::$alertas;
    }

    public function validarPassword() {
        if(!$this->password) {
            self::$alertas['error'][] = "El Password es Obligatorio";
        }
        if (strlen($this->password) < 6) {
            self::$alertas['error'][] = "El Password es debe contener al menos 6 caracteres ";
        }
    
        return self::$alertas;
    }

    // Revisa si un usuario ya esta registrado
    public function existeUsuario() {  
        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";

        $resultado = self::$db->query($query);

        if($resultado->num_rows){
            self::$alertas['error'][] = "El Usuario ya esta registrado";
        }

        return $resultado;
    }
    // Hashea el password
    public function hashPassword() {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }
    // Crea un token unico
    public function crearToken() {
        $this->token = uniqid();
    }
    // Verifica si un usuario ya confirmo su cuenta
    public function comprobarPasswordAndVerificado($password) {

        $resultado = password_verify($password, $this->password);
        // Verificar si el password es correcto y si la cuenta esta confirmada
        if(!$resultado || !$this->confirmado) {
            self::$alertas['error'][] = "El Password es incorrecto o la cuenta no ha sido confirmada";
        } else {
            return true;
        }
    }
}