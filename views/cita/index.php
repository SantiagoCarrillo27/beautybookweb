    <?php
    include_once __DIR__ . '/../templates/barra.php'
    ?>

    <div class="contenedor-users">
        <h1 class="nombre-pagina">Crear nueva Cita</h1>
        <p class="descripcion-pagina">Elige tus servicios y coloca tus datos</p>

        <div id="app">

            <nav class="tabs">
                <button class="actual" type="button" data-paso="1">Servicios</button>
                <button type="button" data-paso="2">Información cita</button>
                <button type="button" data-paso="3">Resumen</button>
            </nav>

            <div class="seccion" id="paso-1">
                <h2>Servicios</h2>
                <p class="text-center">Elige tus servicios a continuación</p>
                <div id="servicios" class="listado-servicios"></div>
            </div>
            <div class="seccion" id="paso-2">
                <h2>Tus datos y cita</h2>
                <p class="text-center">Coloca tus datos y fecha de tu cita</p>
                <form class="formulario">
                    <div class="campo">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" id="nombre" value="<?= $nombre ?>" disabled>
                    </div>

                    <div class="campo">
                        <label for="fecha">Fecha</label>
                        <div class="contenedor-input">
                            <input type="date" name="fecha" id="fecha" placeholder="Selecciona una Fecha">
                            <span class="material-symbols-outlined icon-view">calendar_month</span>
                        </div>
                    </div>

                    <div class="campo">
                        <label for="hora">Hora</label>
                        <div class="contenedor-input">
                            <input type="time" name="hora" id="hora" placeholder="Selecciona una Hora">
                            <span class="material-symbols-outlined icon-view">schedule</span>
                        </div>
                    </div>

                    <input type="hidden" value="<?= $id; ?>" id="id">

                </form>
            </div>
            <div class="seccion contenido-resumen" id="paso-3">
                <h2>Resumen</h2>
                <p class="text-center">Verifica que la información sea correcta</p>
            </div>

            <div class="paginacion">
                <button id="anterior" class="boton"><i class="material-symbols-outlined">arrow_back</i> Anterior</button>
                <button id="siguiente" class="boton"> Siguiente <i class="material-symbols-outlined">arrow_forward</i></button>
            </div>

        </div>

    </div>

    <?php $script = " 
    <script src='build/js/app.js'></script>
";
    ?>