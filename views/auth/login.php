<div class="contenedor">

    <div class="contenedor-sm">

        <div class="contenedor-img">

            <picture class="img-login">
                <source srcset="build/img/salonBelleza3.webp" type="image/webp">
                <source srcset="build/img/salonBelleza3.avif" type="image/avif">
                <img loading="lazy" class="img-formulario" src="build/img/salonBelleza3.jpg" alt="Imagen Login">
            </picture>
        </div>

        <div class="contenedor-forms">
            <h1 class="nombre-pagina">Login</h1>

            <p class="descripcion-pagina">Inicia sesión con tus datos</p>

            <?php include_once __DIR__ . '/../templates/alertas.php' ?>

            <form method="POST" class="formulario" action="/">
                <div class="campo">
                    <label for="email">Email:</label>
                    <input id="email" type="email" placeholder="Escribe tu Email" name="email">
                    <!-- value="<?php echo s($auth->email); ?>"> -->
                    

                </div>
                <div class="campo">
                    <label for="password">Password:</label>
                    <div class="contenedor-input">
                        <input id="password" type="password" placeholder="Escribe tu Password" name="password">
                        <span class="material-symbols-outlined" id="cambioIconoPassword">
                            visibility_off
                        </span>
                    </div>
                </div>

                <button class="boton" type="submit">Iniciar Sesión <span class="material-symbols-outlined">login</span></button>

            </form>

            <div class="acciones">
                <a href="/crear-cuenta">¿Aún no tienes una cuenta? <span>Crear una</span></a>
                <a href="/olvide">¿Olvidaste tu password?</a>
            </div>

        </div>

    </div>

</div>



<?php 

$script = "
    <script src='build/js/helpers.js'></script>
";

?>