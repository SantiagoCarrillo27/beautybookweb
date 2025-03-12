<?php


namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController
{
    public static function login(Router $router)
    {

        $alertas = [];
        // AUTOCOMPLETAR EMAIL CUANDO ESTE MAL LA CONTRASEÑA
        // $auth = new Usuario;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);
            $alertas = $auth->validarLogin();

            if (empty($alertas)) {

                $usuario = Usuario::where('email', $auth->email);

                if ($usuario) {
                    // VERIFICAR EL PASSWORD
                    if ($usuario->comprobarPasswordAndVerificado($auth->password)) {
                        // AUNTENTICAR AL USUARIO
                        // session_start();

                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        // REDIRECCIONAMIENTO

                        if ($usuario->admin === "1") {
                            $_SESSION['admin'] = $usuario->admin ?? null;
                            header('Location: /admin');
                        } else {
                            header('Location: /citas');
                        }
                    }
                } else {
                    Usuario::setAlerta('error', 'El Usuario ingresado no ha sido encontrado');
                }
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/login', [
            'alertas' => $alertas,
            'titulo' => 'Inicio Sesión'
            // 'auth' => $auth
        ]);
    }

    public static function logout()
    {
        if (!isset($_SESSION['nombre'])) {
            header('Location: /');
            exit();
        }

        $_SESSION = [];
        session_destroy();
        header('Location: /');
        exit();
    }
    public static function olvide(Router $router)
    {

        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();

            if (empty($alertas)) {
                $usuario = Usuario::where('email', $auth->email);
                if ($usuario && $usuario->confirmado === "1") {

                    $usuario->createToken();
                    $usuario->guardar();

                    // Enviar Email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();


                    // ALERTA DE EXITO
                    Usuario::setAlerta('exito', 'Revisa tu correo electrónico para restablecer tu password');
                } else {
                    Usuario::setAlerta('error', 'El usuario no existe o no esta confirmado');
                }
            }
        }
        $alertas = Usuario::getAlertas();
        $router->render('auth/olvide-password', [
            'alertas' => $alertas,
            'titulo' => 'Recuperar Password'
        ]);
    }

    public static function recuperar(Router $router)
    {

        $alertas = [];
        $error = false;

        $token = s($_GET['token']);

        //BUSCAR AL USUARIO POR SU TOKEN

        $usuario = Usuario::where('token', $token);

        if (empty($usuario)) {
            Usuario::setAlerta('error', 'Token no válido');
            $error = true;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // LEER EL NUEVO PASSWORD Y GUARDARLO

            $password = new Usuario($_POST);

            $alertas = $password->validarPassword();

            if (empty($alertas)) {

                $usuario->password = null;


                $usuario->password = $password->password;
                $usuario->hashPassword();
                $usuario->token = null;
                $resultado = $usuario->guardar();

                if ($resultado) {
                    header('Location: /');
                }
            }
        }


        $alertas = Usuario::getAlertas();
        $router->render('auth/recuperar-password', [
            'alertas' => $alertas,
            'error' => $error,
        ]);
    }

    public static function crear(Router $router)
    {

        $usuario = new Usuario($_POST);

        // ALERTAS VACíAS
        $alertas = [];
        // debuguear($usuario);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();

            if (empty($alertas)) {
                $resultado = $usuario->userExists();

                if ($resultado->num_rows) {
                    $alertas = Usuario::getAlertas();
                } else {

                    // HASHEAR EL PASSWORD
                    $usuario->hashPassword();

                    // GENERAR UN TOKEN ÚNICO
                    $usuario->createToken();

                    // ENVIAR EMAIL

                    $email = new Email(
                        $usuario->email,
                        $usuario->nombre,
                        $usuario->token
                    );

                    $email->sendConfirmation();

                    // CREAR EL USUARIO

                    $resultado = $usuario->guardar();

                    if ($resultado) {
                        header('Location: /mensaje');
                    }

                    // debuguear($email);
                    // debuguear($usuario);
                }
            }
        }

        $router->render('auth/crear-cuenta', [
            'usuario' => $usuario,
            'alertas' => $alertas,
            'titulo' => 'Registrarse'
        ]);
    }


    public static function confirmar(Router $router)
    {

        $alertas = [];
        $token = s($_GET['token']);

        $usuario = Usuario::where('token', $token);

        if (empty($usuario) || $usuario->token === "") {
            // MOSTRAR MENSAJE DE ERROR
            Usuario::setAlerta('error', 'Token no válido o  ya Validado');
        } else {
            // MODIFICAR A USUARIO CONFIRMADO
            $usuario->confirmado = "1";
            $usuario->token = "";
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta comprobada correctamente');
        }
        // LLAMAR ALERTAS
        $alertas = Usuario::getAlertas();

        $router->render('auth/confirmar-cuenta', [
            'alertas' => $alertas,
            'titulo' => 'Confirmar Cuenta'
        ]);
    }

    public static function mensaje(Router $router)
    {
        $router->render('auth/mensaje', [
            'titulo' => 'Mensaje'
        ]);
    }
}
