<?php
session_start();
require_once "00_varios.php";
$pdo=obtenerPdoConexionBD();
/*Si no hay session iniciada redirigimos a la pagina de Iniciar Session*/
    $id="";
    $nombre="";
    $apellidos="";
    $identificador=(string)$_REQUEST["identificador"];
    $contrasenna=(string)$_REQUEST["contrasenna"];
    /* Consultar que el usuario y contrasenna estan en la BDD */
    $resultados= obtenerUsuario($identificador,$contrasenna);
    /* SI hay un solo resultado---> Inicio session correcto */

    if(count($resultados)==1 && !empty($resultados)){
        $id=(int)$resultados[0]["id"];
        $identificador=(string)$resultados[0]["identificador"];
        $nombre=(string)$resultados[0]["nombre"];
        $apellidos=(string)$resultados[0]["apellidos"];
        marcarSesionComoIniciada($id,$identificador,$nombre,$apellidos);
    }else{
        $_SESSION["txt"]="El usuario o la contraseña no son correctos";
        redireccionar("01SessionMostrarFormulario.php");
    }


// TODO Verificar (usar funciones de _Varios.php) identificador y contrasenna recibidos
// y redirigir a ContenidoPrivado1 (si OK) o a iniciar sesión (si NO ok).
