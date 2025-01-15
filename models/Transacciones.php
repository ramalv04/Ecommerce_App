<?php

namespace Model;

class Transacciones extends ActiveRecord{

    protected static $tabla = 'transacciones';
    protected static $columnasDB = ['id', 'orderID', 'pedidoID'];

    public $id;
    public $orderID;
    public $pedidoID;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->orderID = $args['orderID'] ?? '';
        $this->pedidoID = $args['pedidoID'] ?? '';
    }
}
