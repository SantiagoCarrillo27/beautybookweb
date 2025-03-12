<div class="contenedor-principal">

    <a href="/servicios" class="boton volver"><span class="material-symbols-outlined">arrow_back</span>Volver</a>
    <h1 class="nombre-pagina">Nuevo Servicio</h1>

    <p class="descripcion-pagina">Llena todos los campos para crear un nuevo servicio</p>

    <?php
    // include_once __DIR__ . '/../templates/barra.php';
    include_once __DIR__ . '/../templates/alertas.php';
    ?>



    <form action="/servicios/crear" method="POST" class="formulario" enctype="multipart/form-data">

        <?php include_once __DIR__ . '/formulario.php' ?>

        <button type="submit" class="boton guardar-servicio">Guardar Servicio <span class="material-symbols-outlined">add_circle</span></button>
    </form>
</div>