<div class="campo">
    <label for="nombre">Nombre: </label>
    <input type="text" name="nombre" id="nombre" placeholder="Nombre del servicio" value="<?= $servicio->nombre; ?>">
</div>
<div class="campo">
    <label for="precio">Precio: </label>
    <input type="number" id="precio" name="precio" placeholder="Precio del servicio" value="<?= $servicio->precio; ?>">
</div>
<div class="campo">
    <label for="imagen">Imagen: </label>
    <input type="file" id="imagen" name="imagen" accept="image/jpeg, image/png" onchange="mostrarImagenPrevia(event)">

    <?php if (!empty($servicio->imagen_url)): ?>
        <img id="imagen-actual" src="/build/imagenes/<?= $servicio->imagen_url; ?>" alt="imagen del servicio">
    <?php endif; ?>


    <div id="preview-container">
        <img id="preview" src="" alt="Previsualización de imagen">
    </div>

</div>



<?php

$script = "
    <script src='../build/js/helpers.js'></script>
";

?>