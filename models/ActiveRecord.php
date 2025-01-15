<?php
/**
 * Clase ActiveRecord
 * 
 * Esta clase proporciona una base para la implementación de modelos ActiveRecord en una aplicación de comercio electrónico.
 * Los modelos ActiveRecord son utilizados para interactuar con la base de datos y realizar operaciones CRUD (Crear, Leer, Actualizar, Eliminar) en los registros.
 * 
 * Propiedades:
 * - $db: Objeto de conexión a la base de datos.
 * - $tabla: Nombre de la tabla de la base de datos asociada al modelo.
 * - $columnasDB: Arreglo que contiene los nombres de las columnas de la tabla de la base de datos.
 * - $alertas: Arreglo que almacena las alertas y mensajes generados durante la validación de los datos.
 * 
 * Métodos:
 * - setDB($database): Establece la conexión a la base de datos.
 * - setAlerta($tipo, $mensaje): Agrega una alerta o mensaje al arreglo de alertas.
 * - getAlertas(): Obtiene el arreglo de alertas.
 * - validar(): Realiza la validación de los datos y actualiza el arreglo de alertas.
 * - consultarSQL($query): Ejecuta una consulta SQL en la base de datos y retorna los resultados.
 * - crearObjeto($registro): Crea un objeto en memoria a partir de un registro de la base de datos.
 * - atributos(): Obtiene los atributos del objeto en memoria.
 * - sanitizarAtributos(): Sanitiza los atributos del objeto antes de guardarlos en la base de datos.
 * - sincronizar($args=[]): Sincroniza los atributos del objeto con los valores proporcionados en el arreglo $args.
 * - guardar(): Guarda el objeto en la base de datos, ya sea creando un nuevo registro o actualizando uno existente.
 * - all(): Obtiene todos los registros de la tabla.
 * - find($id): Busca un registro por su ID.
 * - findLast(): Busca el último registro de la tabla.
 * - get($limite): Obtiene una cantidad específica de registros de la tabla.
 * - where($columna, $valor): Busca registros que cumplan con una condición específica.
 * - SQL($query): Ejecuta una consulta SQL personalizada en la base de datos.
 * - crear(): Crea un nuevo registro en la base de datos.
 * - setImagen($imagen): Asigna una imagen al atributo "imagen" del objeto.
 * - borrarImagen(): Elimina la imagen asociada al objeto.
 * - actualizar(): Actualiza el registro en la base de datos.
 * - eliminar(): Elimina el registro de la base de datos.
 * - orderBy($columna, $direccion = 'asc'): Ordena los registros de la tabla según una columna específica y dirección.
 */

namespace Model;

class ActiveRecord {

    // Base DE DATOS
    protected static $db;
    protected static $tabla = '';
    protected static $columnasDB = [];

    // Alertas y Mensajes
    protected static $alertas = [];
    
    // Definir la conexión a la BD - includes/database.php
    public static function setDB($database) {
        self::$db = $database;
    }

    public static function setAlerta($tipo, $mensaje) {
        static::$alertas[$tipo][] = $mensaje;
    }

    // Validación
    public static function getAlertas() {
        return static::$alertas;
    }

    public function validar() {
        static::$alertas = [];
        return static::$alertas;
    }

    // Consulta SQL para crear un objeto en Memoria
    public static function consultarSQL($query) {
        // Consultar la base de datos
        $resultado = self::$db->query($query);
        
        // Iterar los resultados
        $array = [];
        while($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }
        
        // liberar la memoria
        $resultado->free();
    
        // retornar los resultados
        return $array;
    }

    // Crea el objeto en memoria que es igual al de la BD
    protected static function crearObjeto($registro) {
        $objeto = new static;

        foreach($registro as $key => $value ) {
            if(property_exists( $objeto, $key  )) {
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }

    // Identificar y unir los atributos de la BD
    public function atributos() {
        $atributos = [];
        foreach(static::$columnasDB as $columna) {
            if($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    // Sanitizar los datos antes de guardarlos en la BD
    public function sanitizarAtributos() {
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach($atributos as $key => $value ) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }

    // Sincroniza BD con Objetos en memoria
    public function sincronizar($args=[]) { 
        foreach($args as $key => $value) {
          if(property_exists($this, $key) && !is_null($value)) {
            $this->$key = $value;
          }
        }
    }

    // Registros - CRUD
    public function guardar() {
        $resultado = '';
        if(!is_null($this->id)) {
            // actualizar
            $resultado = $this->actualizar();
        } else {
            // Creando un nuevo registro
            $resultado = $this->crear();
        }
        return $resultado;
    }

    // Todos los registros
    public static function all() {
        $query = "SELECT * FROM " . static::$tabla;
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Busca un registro por su id
    public static function find($id) {
        $query = "SELECT * FROM " . static::$tabla  ." WHERE id = {$id}";
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado ) ;
    }

    // Busca el último registro por su id
    public static function findLast() {
        $query = "SELECT * FROM " . static::$tabla  ." ORDER BY id DESC LIMIT 1";
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }

    // Obtener Registros con cierta cantidad
    public static function get($limite) {
        $query = "SELECT * FROM " . static::$tabla . " LIMIT {$limite}";
        $resultado = self::consultarSQL($query);
        //debugear($resultado);
        return $resultado;
    }
   
    public static function where($columna, $valor) {
        $query = "SELECT * FROM " . static::$tabla  ." WHERE {$columna} = '{$valor}'";
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado ) ;
    }

    //Consulta Plana de SQL (Utilizar cunado los metodos del modelo no son suficientes)
    public static function SQL($query) {
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // public static function crearCategorias(){
    //         $alfombra = new Categoria();
    //         $alfombra->nombre = "Alfombra";
    //         $alfombra->guardar();
    //         $tapiz = new Categoria();
    //         $tapiz->nombre = "Tapiz";
    //         $tapiz->guardar();
    // }

    
    // crea un nuevo registro
    public function crear() {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Insertar en la base de datos
        $query = " INSERT INTO " . static::$tabla . " ( ";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES (' "; 
        $query .= join("', '", array_values($atributos));
        $query .= " ') ";


        // Resultado de la consulta
        $resultado = self::$db->query($query);
        return [
           'resultado' =>  $resultado,
           'id' => self::$db->insert_id
        ];
    }

    //subida de archivos
    public function setImagen($imagen) {
        //eliminar la imagen previa
        if(!is_null($this->id)) {
            $this->borrarImagen();
        }

        //asignar al atributo de imagen el nombre de la imagen
        if($imagen) {
            $this->imagen = $imagen;
        }
    }

    //elimina un archivo
    public function borrarImagen() {
        $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);

        if($existeArchivo) {
            unlink(CARPETA_IMAGENES . $this->imagen);
        }
    }

    // Actualizar el registro
    public function actualizar() {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Iterar para ir agregando cada campo de la BD
        $valores = [];
        foreach($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }

        // Consulta SQL
        $query = "UPDATE " . static::$tabla ." SET ";
        $query .=  join(', ', $valores );
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 "; 

        // Actualizar BD
        $resultado = self::$db->query($query);
        return $resultado;
    }

    // Eliminar un Registro por su ID
    public function eliminar() {
        $query = "DELETE FROM "  . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$db->query($query);
        return $resultado;
    }
    //Ordena en el admin Controller
    public static function orderBy($columna, $direccion = 'asc') {
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY {$columna} {$direccion}";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }
    

}