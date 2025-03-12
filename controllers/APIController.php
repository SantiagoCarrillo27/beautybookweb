<?php


namespace Controllers;

use Classes\Email;
use Model\Cita;
use Model\CitaServicio;
use Model\Servicio;
use Model\Usuario;

class APIController
{

    public static function index()
    {
        $servicios = Servicio::all();

        echo json_encode($servicios);
    }

    public static function guardar()
    {

        // ALMACENA LA CITA Y DEVUELVE EL ID
        $cita = new Cita($_POST);
        $resultado = $cita->guardar();


        $id = $resultado['id'];

        $idServicios = explode(",", $_POST['servicios']);

        $servicios = [];


        foreach ($idServicios as $idServicio) {

            $args = [
                'citaId' => $id,
                'servicioId' => $idServicio
            ];

            $citaServicio = new CitaServicio($args);
            $citaServicio->guardar();

            // Obtener los nombres de los servicios
            $servicio = Servicio::find($idServicio);
            if ($servicio) {
                $servicios[] = $servicio->nombre;
            }
        }

         // OBTENER LOS DATOS DEL USUARIO
         $usuarioId = $_POST['usuarioId'];
         $usuario = Usuario::find($usuarioId);

          // ENVIAR CORREO DE CONFIRMACIÓN
        if ($usuario) {
            $email = new Email($usuario->email, $usuario->nombre);
            $correoEnviado = $email->enviarConfirmacionCita($_POST['fecha'], $_POST['hora'], $servicios);
        } else {
            $correoEnviado = false;
        }


        echo json_encode([
            'resultado' => $resultado,
            'correoEnviado' => $correoEnviado
        ]);
    }

    public static function eliminar()
    {


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];

            if (filter_var($id, FILTER_VALIDATE_INT)) {

                $cita = Cita::find($id);
            }

            if ($cita) {

                $cita->eliminar();
            }


            header('Location:' . $_SERVER['HTTP_REFERER']);
        }
    }
}
