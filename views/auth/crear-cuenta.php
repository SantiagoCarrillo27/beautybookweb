<div class="contenedor">

    <div class="contenedor-sm">



        <div class="contenedor-img">

            <picture class="img-login">
                <img class="img-formulario" src="build/img/salonBelleza3.jpg" alt="Imagen Login">
            </picture>
        </div>

        <div class="contenedor-forms">

            <h1 class="nombre-pagina">Crear Cuenta</h1>

            <p class="descripcion-pagina">Llena el siguiente formulario para crear una cuenta.</p>

            <?php include_once __DIR__ . "/../templates/alertas.php" ?>

            <form action="/crear-cuenta" method="POST" class="formulario">

                <div class="campo">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre"
                        placeholder="Escribe tu nombre"
                        value="<?php echo s($usuario->nombre); ?>">
                </div>
                <div class="campo">
                    <label for="apellido">Apellido:</label>
                    <input type="text" id="apellido" name="apellido"
                        placeholder="Escribe tu apellido"
                        value="<?php echo s($usuario->apellido); ?>">
                </div>
                <div class="campo">
                    <label for="telefono">Teléfono:</label>
                    <input type="text" id="telefono" name="telefono"
                        placeholder="Escribe tu teléfono"
                        value="<?php echo s($usuario->telefono); ?>">
                </div>

                <div class="campo">
                    <label for="email">E-mail:</label>
                    <input type="email" id="email" name="email"
                        placeholder="Escribe tu email"
                        value="<?php echo s($usuario->email); ?>">
                </div>

                <div class="campo">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password"
                        placeholder="Escribe tu password">
                </div>

                <button type="submit" class="boton">Crear cuenta <span class="material-symbols-outlined">account_circle</span></button>

            </form>



            <div class="acciones">
                <a href="/">¿Ya tienes una cuenta? <span>Inicia sesión</span></a>
                <a href="/olvide">¿Olvidaste tu password?</a>
            </div>

        </div>

    </div>

</div>