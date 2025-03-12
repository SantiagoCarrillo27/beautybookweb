<div class="contenedor-principal">
<h1 class="nombre-pagina">Actualizar Servicios</h1>

<p class="descripcion-pagina">Modifica los datos a actualizar</p>

<?php
// include_once __DIR__ . '/../templates/barra.php';
include_once __DIR__ . '/../templates/alertas.php';
?>

<a href="/servicios" class="boton"><span class="material-symbols-outlined">arrow_back</span> Volver</a>

<form id="actualizar" method="POST" class="formulario" enctype="multipart/form-data">

    <?php include_once __DIR__ . '/formulario.php' ?>

    <input type="submit" class="boton" value="Actualizar Servicio">
</form>
</div>