<?php
include_once __DIR__ . '/../templates/barra-admin.php'
?>

<div class="contenedor-admin">
    <?php
    include_once __DIR__ . '/../templates/barra.php';
    // include_once __DIR__ . '/../templates/alertas.php';
    ?>

    <h1 class="nombre-pagina">Servicios</h1>

    <p class="descripcion-pagina">Administración de servicios</p>

    <?php
        if (empty($servicios)): ?>
            <div class="sin-servicios">
                <h3 class="sin-info">Sin Servicios, agrégalos en el apartado de Nuevo servicio.</h3>
            </div>
        <?php endif ?>

    <ul class="servicios ">
            <?php foreach ($servicios as $servicio): ?>
                <li>
                    <figure>
                        <img loading="lazy" src="/build/imagenes/<?= $servicio->imagen_url;?>" alt="Imagen del servicio">
                    </figure>
                    <span class="datos">
                        <p>Nombre: <span><?= $servicio->nombre; ?></span> </p>
                        <p>Precio: <span>€ <?= number_format($servicio->precio, 2, '.', ','); ?></span> </p>
                    </span>
                    <div class="border"></div>
                    <div class="acciones">
                        <a class="boton" href="/servicios/actualizar?id=<?= $servicio->id; ?>">Actualizar</a>
                        <form action="/servicios/eliminar" method="POST">
                            <input type="hidden" name="id" value="<?= $servicio->id; ?>">
                            <input type="submit" value="Eliminar" class="boton-eliminar">
                        </form>
                    </div>
                </li>
            <?php endforeach ?>
    </ul>

</div>


<?php
$script = "
<script src='build/js/helpers.js'></script>

";

?>