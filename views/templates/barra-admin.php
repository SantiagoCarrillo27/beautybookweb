<?php

if (isset($_SESSION['admin'])) { ?>

    <div class="menu-hamburguer">
        <span class="material-symbols-outlined">
            menu
        </span>
        <span class="material-symbols-outlined">
            close
        </span>
    </div>

    <div class="barra-servicios-admin">

        <div>
            <div class="headers" id="logo" title="Logo">
                <span class="material-symbols-outlined">
                    health_and_beauty
                </span>
                <h1 class="logo-admin">Beauty<span>Book</span></h1>
            </div>


            <div class="usuario" title="<?php echo $nombre ?? ''; ?>">

                <span class="material-symbols-outlined logo-user">
                    account_circle
                </span>

                <p class="logo-admin"><span><?php echo $nombre ?? ''; ?></span></p>
            </div>


        </div>


        <nav class="navegacion">
            <ul>
                <li title="Ver Citas">
                    <a href="/admin">
                        <span class="material-symbols-outlined">calendar_month</span>
                        <span class="logo-admin">Ver Citas</span>
                    </a>
                </li>
                <li title="Ver Servicios">
                    <a href="/servicios">
                        <span class="material-symbols-outlined">search_check</span>
                        <span class="logo-admin">Ver Servicios</span>
                    </a>
                </li>
                <li title="Nuevo Servicio">
                    <a href="/servicios/crear">
                        <span class="material-symbols-outlined">add_box</span>
                        <span class="logo-admin">Nuevo Servicio</span>
                    </a>
                </li>
            </ul>
        </nav>


        <a class="bnt-logout" href="/logout" title="Cerra Sesión">
            <i class="material-symbols-outlined">
                logout
            </i>
            <span class="logo-admin">Cerrar Sesión</span>
        </a>

    </div>

<?php } ?>