<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}


function esUltimo(string $actual,string $proximo) : bool{
    if($actual !== $proximo){
        return true;
    }

    return false;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

//FUNCIÓN QUE REVISA QUE EL USUARIO ESTÉ AUTENTICADO

function isAuth(){

    if(!isset($_SESSION['login'])){
        header('Location: /');
    }
}


function isAdmin(){
    if(!isset($_SESSION['admin'])){
        header('Location: /');
    }

    
}