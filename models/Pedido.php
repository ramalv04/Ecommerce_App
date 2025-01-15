<?php

namespace Model;

class Pedido extends ActiveRecord {
    //bd
    protected static $tabla = 'pedido';
    protected static $columnasDB = ['id', 'idUsuario', 'referencia', 'fecha', 'idEstado'];

    public $id;
    public $idUsuario;
    public $referencia;
    public $fecha;
    public $idEstado;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->idUsuario = $args['idUsuario'] ?? '';
        $this->referencia = $args['referencia'] ?? '';
        $this->fecha = date('Y/m/d');
        $this->idEstado = $args['idEstado'] ?? '';
    }
}