<?php

namespace Model;

class Servicio extends ActiveRecord
{

    // BD
    protected static $tabla = 'servicios';
    protected static $columnasDB = ['id', 'nombre', 'precio', 'imagen_url'];


    public $id;
    public $nombre;
    public $precio;
    public $imagen_url;

    public function __construct($args = [])
    {

        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen_url = $args['imagen_url'] ?? '';
    }


    public function validar($esActualizacion = false)
    {

        $imagen = $_FILES['imagen'];


        if (!$this->nombre) {
            self::$alertas['error'][] = 'El nombre del servicio es Obligatorio';
        }
        if (!$this->precio) {
            self::$alertas['error'][] = 'El precio del servicio es Obligatorio';
        }
        if (!is_numeric($this->precio)) {
            self::$alertas['error'][] = 'El precio debe ser un número';
        }

        if (!$esActualizacion || ($imagen && $imagen['name'])) {
            if (!$imagen || !$imagen['name'] || $imagen['error']) {
                self::$alertas['error'][] = 'La imagen es obligatoria';
            }
        }

        // VALIDAR POR TAMAÑO (2M)

        $medida = 2 * 1024 * 1024;

        if ($imagen['size'] > $medida) {
            self::$alertas['error'][] = 'La imagen es muy pesada';
        }

        return self::$alertas;
    }
}
