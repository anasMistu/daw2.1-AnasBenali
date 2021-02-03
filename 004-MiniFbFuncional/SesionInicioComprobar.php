<?php

require_once "_com/DAO.php";


$arrayUsuario = DAO::obtenerUsuarioConIdentificador($_POST["identificador"]);
$usuario=DAO::crearUsuarioDesdeRs($arrayUsuario);
//print_r($usuario);
if ($arrayUsuario) { // Identificador existía y contraseña era correcta.
    DAO::establecerSesionRam($usuario);

    if (isset($_POST["recordar"])) {
       DAO::generarCookieRecordar($usuario);
        //print_r("BIEN");
    }

    //redireccionar("MuroVerGlobal.php");
} else {
    redireccionar("SesionInicioFormulario.php?datosErroneos");

}
