<?php

namespace Model;

class Producto extends ActiveRecord{
    protected static $tabla = 'producto';
    protected static $columnasDB = ['id', 'nombre', 'precio', 'fecha', 'imagen', 'descripcion', 'idCategoria'];

    public $id;
    public $nombre;
    public $precio;
    public $fecha;
    public $imagen;
    public $descripcion;
    public $idCategoria;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->fecha = date('Y/m/d');
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->idCategoria = $args['idCategoria'] ?? '';
    }

    public function validar() {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El nombre es obligatorio';
        }

        if(!$this->precio) {
            self::$alertas['error'][] = 'El precio es obligatorio';
        }

        if(!is_numeric($this->precio) || $this->precio <= 0) {
            self::$alertas['error'][] = 'El precio debe ser un numero y mayor a 0';
        }

        if(!$this->imagen) {
            self::$alertas['error'][] = 'La imagen es obligatoria';
        }

        if(!$this->descripcion || strlen($this->descripcion) < 100 || strlen($this->descripcion) > 350) {
            self::$alertas['error'][] = 'La descripcion es obligatoria y debe tener entre 100 y 350 caracteres';
        }

        if(!$this->idCategoria){
            self::$alertas['error'][] = "Elige una categoria";
        }

        return self::$alertas;
    }
}