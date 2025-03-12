<?php

namespace Model;


class Usuario extends ActiveRecord
{

    // BASE DE DATOS

    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'admin', 'telefono', 'email', 'password', 'apellido', 'nombre', 'confirmado', 'token'];


    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $admin;
    public $telefono;
    public $password;
    public $confirmado;
    public $token;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->admin = $args['admin'] ?? "0";
        $this->telefono = $args['telefono'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->confirmado = $args['confirmado'] ?? "0";
        $this->token = $args['token'] ?? '';
    }

    // MENSAJES DE VALIDACIÓN PARA LA CREACIÓN DE UNA CUENTA

    public function validarNuevaCuenta()
    {
        if (!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre es obligatorio';
        }
        if (!$this->apellido) {
            self::$alertas['error'][] = 'El Apellido es obligatorio';
        }
        if (!$this->email) {
            self::$alertas['error'][] = 'El correo electrónico es obligatorio';
        }
        if (!$this->password) {
            self::$alertas['error'][] = 'El password es obligatorio';
        }
        if (strlen($this->password) < 6) {
            self::$alertas['error'][] = 'El password debe contener al menos 6 caracteres';
        }

        return self::$alertas;
    }


    public function validarLogin()
    {
        if (!$this->email) {
            self::$alertas['error'][] = "El correo electrónico es obligatorio";
        }
        if (!$this->password) {
            self::$alertas['error'][] = "El Password es obligatorio";
        }

        return self::$alertas;
    }

    public function validarEmail()
    {
        if (!$this->email) {
            self::$alertas['error'][] = 'El correo electrónico es obligatorio';
        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'El correo electrónico no es válido';
        } elseif (!preg_match('/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-zA-Z]{2,}$/', $this->email)) {
            self::$alertas['error'][] = 'El correo electrónico debe tener al menos dos caracteres después del punto';
        }
        return self::$alertas;
    }



    // REVISA SI EL USUARIO YA EXISTE CUANDO INTENTA CREAR UNA CUENTA
    public function userExists()
    {

        $query = "SELECT * FROM " . self::$tabla . " WHERE email ='" . $this->email . "' LIMIT 1";

        $resultado = self::$db->query($query);

        if ($resultado->num_rows) {
            self::$alertas['error'][] = 'El usuario ya está registrado';
        }

        return $resultado;
    }

    public function hashPassword()
    {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function createToken()
    {
        $this->token = uniqid();
    }


    public function comprobarPasswordAndVerificado($password)
    {

        $alertas = [];

        $resultado = password_verify($password, $this->password);
        if (!$resultado || !$this->confirmado) {
            self::$alertas['error'][] = 'Password incorrecto o tu cuenta no ha sido confirmada';
        } else {
            return true;
        }
    }


    public function validarPassword()
    {
        if (!$this->password) {
            self::$alertas['error'][] = 'El password es obligatorio';
        }

        if (strlen($this->password) < 6) {
            self::$alertas['error'][] = 'El password debe contener al menos 6 caracteres';
        }


        return self::$alertas;
    }
}
