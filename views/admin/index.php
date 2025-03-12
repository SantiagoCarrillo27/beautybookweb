<?php
include_once __DIR__ . '/../templates/barra-admin.php'
?>

<div class="contenedor-admin ">


    <?php
    include_once __DIR__ . '/../templates/barra.php'; ?>
    <h1 class="nombre-pagina">Panel de administración</h1>

    <h2>Buscar Citas</h2>
    <div class="busqueda">
        <form action="" class="formulario">
            <div class="campo">
                <label for="fecha">Fecha</label>
                <div class="contenedor-input">
                    <input type="date" id="fecha" name="fecha" value="<?= $fecha; ?>">
                    <span class="material-symbols-outlined icon-view">calendar_month</span>
                </div>
            </div>
        </form>
    </div>

    <?php
    if (count($citas) === 0): ?>
        <h2 class="sin-info">No hay citas para la fecha seleccionada</h2>
    <?php endif ?>

    <div id="citas-admin">
        <ul class="citas">
            <?php
            $idCita = 0;
            foreach ($citas as $key => $cita):
                // Si es una nueva cita, se abre una nueva lista
                if ($idCita !== $cita->id):
                    $total = 0;
                    if ($idCita !== 0) echo "</li>"; // Cierra el <li> anterior si no es la primera iteración
            ?>
                    <li>
                        <h3>Datos del cliente</h3>
                        <p>ID: <span><?= $cita->id; ?></span></p>
                        <p>Hora: <span><?= $cita->hora; ?></span></p>
                        <p>Nombre: <span><?= $cita->cliente; ?></span></p>
                        <p>Email: <span><?= $cita->email; ?></span></p>
                        <p>Teléfono: <span><?= $cita->telefono; ?></span></p>
                        <h3>Servicios</h3>
                    <?php
                    $idCita = $cita->id;
                endif;
                $total += $cita->precio;
                    ?>
                    <p class="datos-servicio"><?= $cita->servicio; ?> : <span>€<?= $cita->precio; ?></span></p>

                    <?php
                    $actual = $cita->id;
                    $proximo = $citas[$key + 1]->id ?? 0;

                    if (esUltimo($actual, $proximo)) { ?>
                        <p class="total">Total: <span>€<?= number_format($total, 2, '.', ','); ?></span></p>
                        <form action="/api/eliminar" method="POST">
                            <input type="hidden" name="id" value="<?= $cita->id; ?>">

                            <input type="submit" class="boton-eliminar" value="Eliminar">
                        </form>
                    <?php  } ?>
                <?php endforeach; ?>
                    </li> <!-- Cierra el último <li> -->
        </ul>
    </div>

</div>


<?php

$script = "
<script src='build/js/helpers.js'></script>
<script src='build/js/buscador.js'></script>


";

?>