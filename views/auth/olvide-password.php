<div class="contenedor">

<div class="contenedor-sm">

    <div class="contenedor-img">

        <picture class="img-login">
            <img class="img-formulario" src="build/img/salonBelleza3.jpg" alt="Imagen Login">
        </picture>
    </div>


    <div class="contenedor-forms">

        <h1 class="nombre-pagina">Olvide mi Password</h1>
        <p class="descripcion-pagina">Restablece tu password escribiendo tu E-mail a continuación </p>

        <?php include_once __DIR__ . '/../templates/alertas.php' ?>


        <form action="/olvide" method="POST" class="formulario">
            <div class="campo">
                <label for="email">E-mail:</label>
                <input type="email" placeholder="Escribe tu Email, Eje: juanito@gmail.com"
                    name="email" id="email">
            </div>

            <button type="submit" class="boton">Enviar Instrucciones <span class="material-symbols-outlined">integration_instructions</span></button>
        </form>

        <div class="acciones">
            <a href="/">¿Ya tienes una cuenta? <span>Inicia Sesión</span></a>
            <a href="/crear-cuenta">¿Aún no tienes una cuenta? <span>Crear una</span></a>
        </div>

    </div>

</div>

</div>