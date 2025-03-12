<?php


namespace Controllers;

use Model\Servicio;
use MVC\Router;

class ServicioController
{

    public static function index(Router $router)
    {
        isAdmin();
        $servicios = Servicio::all();

        $router->render('servicios/index', [
            'nombre' => $_SESSION['nombre'],
            'servicios' => $servicios,
            'titulo' => 'Servicios'
        ]);
    }
    public static function crear(Router $router)
    {

        isAdmin();

        $servicio = new Servicio;
        $alertas = [];


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $servicio->sincronizar($_POST);

            $alertas = $servicio->validar();

            if (empty($alertas)) {

                // DECLARAMOS LA VARIABLE, SI NO EXISTE LE ASIGNAMOS NULL POR DAFAULT
                $imagen = $_FILES['imagen'] ?? null;


                $carpetaImagenes = 'build/imagenes/';

                // SI NO ESTÁ EL DIRECTORIO LO CREO

                if (!is_dir($carpetaImagenes)) {

                    mkdir($carpetaImagenes);
                }

                // GENERAR NOMBRE ÚNICO IMÁGENES

                $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

                // SUBIR IMAGEN 

                move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);

                // debuguear($nombreImagen);

                $servicio->imagen_url = trim($nombreImagen, " \t\n\r\0\x0B"); // Elimina espacios y caracteres ocultos

                $servicio->guardar();
                header('Location: /servicios');
                exit;
            }
        }

        $router->render('servicios/crear', [
            'nombre' => $_SESSION['nombre'],
            'servicio' => $servicio,
            'alertas' => $alertas,
            'titulo' => 'Crear Servicio'
        ]);
    }

    public static function actualizar(Router $router)
    {

        isAdmin();
        $id = $_GET['id'];
        if (!is_numeric($id)) return header('Location: /servicios');
        $servicio = Servicio::find($id);
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $servicio->sincronizar($_POST);

            $alertas = $servicio->validar(true);

            if (empty($alertas)) {

                // DECLARAMOS LA VARIABLE, SI NO EXISTE LEE ASIGNAMOS NULL POR DAFAULT
                $imagen = $_FILES['imagen'] ?? null;

                $carpetaImagenes = 'build/imagenes/';

                // SI NO ESTÁ EL DIRECTORIO LO CREO
                if (!is_dir($carpetaImagenes)) {

                    mkdir($carpetaImagenes);
                }
                $nombreImagen = '';

                if ($imagen['name']) {
                    // ElIMINAMOS LA ANTERIOR IMAGEN
                    unlink($carpetaImagenes . $servicio->imagen_url);
                    // CREAMOS IDENTIFICADOR ÚNICO NUEVA IMAGEN
                    $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
                    // SUBIR IMAGEN 
                    move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);

                    $servicio->imagen_url = trim($nombreImagen, " \t\n\r\0\x0B"); // Elimina espacios y caracteres ocultos


                } else {
                    $nombreImagen = $servicio->imagen_url;
                }


                $servicio->guardar();
                header('Location: /servicios ');
            }
        }
        $router->render('servicios/actualizar', [
            'nombre' => $_SESSION['nombre'],
            'servicio' => $servicio,
            'alertas' => $alertas
        ]);
    }

    public static function eliminar()
    {
        isAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $servicio = Servicio::find($id);
            if ($servicio) {
                // BUSCAMOS LAS IMÁGENES EN EL SERVIDOR
                $rutaImagen = 'build/imagenes/'.$servicio->imagen_url;

                if(file_exists($rutaImagen)){
                    // SI LA ENCUENTRA LA ELIMINA
                    unlink($rutaImagen);
                }

                $servicio->eliminar();
            }

            header('Location: /servicios');
            exit;
        }
    }
}
