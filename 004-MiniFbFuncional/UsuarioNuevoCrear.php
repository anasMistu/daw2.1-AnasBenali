<?php
ini_set('display_errors', "1");
ini_set('display_startup_errors', "1");
error_reporting(E_ALL);
require_once "_com/DAO.php";

if(isset($_POST["crear"])){

        //$emailCliente=(string)$_POST["emailCliente"];
        $identificador=(string)$_POST["identificador"];
        $contrasenna=(string)$_POST["contrasenna"];
        $nombre=(string)$_POST["nombre"];
        $apellidos=(string)$_POST["apellidos"];
        if(strtolower($identificador)=="admin"){
            $tipoUsuario=1;
        }else{
            $tipoUsuario=0;
        }

    /* CARGAR EL ARRAY CON DATOS*/
    $informacionUsuario= array(
        "identificador"=>$identificador,
        "contrasenna"=>$contrasenna,
        "tipoUsuario"=>$tipoUsuario,
        "nombre"=>$nombre,
        "apellidos"=>$apellidos
    );

    DAO::crearUsuario($informacionUsuario);


}


