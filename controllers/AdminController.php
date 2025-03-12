<?php

namespace Controllers;

use Model\AdminCita;
use MVC\Router;

class AdminController
{

    public static function index(Router $router)
    {


        isAdmin();


        $fecha = $_GET['fecha'] ?? date('Y-m-d');

        $fechas = explode('-',$fecha);

        // debuguear($fecha);

        if(!checkdate($fechas[1],$fechas[2],$fechas[0])){
            header('Location: /404');
        };



        if (!isset($_SESSION['nombre'])) {
            header('Location: /'); // Redirigir a la página de login si no hay sesión
            exit(); // Detiene la ejecución para evitar que el código continúe
        }

        // CONSULTAR BASE DE DATOS

        $consulta = "SELECT citas.id, citas.hora, CONCAT( usuarios.nombre, ' ', usuarios.apellido) as cliente, ";
        $consulta .= " usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio  ";
        $consulta .= " FROM citas  ";
        $consulta .= " LEFT OUTER JOIN usuarios ";
        $consulta .= " ON citas.usuarioId=usuarios.id  ";
        $consulta .= " LEFT OUTER JOIN citas_servicios ";
        $consulta .= " ON citas_servicios.citaId=citas.id ";
        $consulta .= " LEFT OUTER JOIN servicios ";
        $consulta .= " ON servicios.id=citas_servicios.servicioId ";
        $consulta .= " WHERE fecha =  '$fecha' ";


        $citas  = AdminCita::SQL($consulta);


        $router->render('admin/index', [
            'nombre' => $_SESSION['nombre'] ?? '',
            'citas' => $citas,
            'fecha' => $fecha,
            'titulo'=> 'Administrador'
        ]);
    }
}
