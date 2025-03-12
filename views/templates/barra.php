<?php
if (!isset($_SESSION['admin'])) { ?>

    <header class="barra">

        <div class="left">
            <div class="brand">
                <span class="material-symbols-outlined">health_and_beauty</span>
                <h2>Beauty<span>Book</span></h2>
            </div>
        </div>


        <div class="right">
            <a class="menu-icons" href="#"><i class="material-symbols-outlined">notifications</i></a>


            <a href="/logout">Logout<i class="material-symbols-outlined">logout</i></a>


        </div>


    </header>



<?php } ?>