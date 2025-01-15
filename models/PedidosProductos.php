<?php

namespace Model;

use Model\ActiveRecord;

class PedidosProductos extends ActiveRecord{
    protected static $tabla = 'pedidosproductos';
    protected static $columnasDB = ['id', 'idPedido', 'idProducto', 'cantidad'];

    public $id;
    public $idPedido;
    public $idProducto;
    public $cantidad;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->idPedido = $args['idPedido'] ?? '';
        $this->idProducto = $args['idProducto'] ?? '';
        $this->cantidad = $args['cantidad'] ?? '';
    }
}