<?php
require_once "_varios.php";
$pdo=obtenerPdoConexionBD();
/*Si no hay session iniciada redirigimos a la pagina de Iniciar Session*/

    $id="";
    $nombre="";
    $apellidos="";
    $identificador=(string)$_REQUEST["identificador"];
    $contrasenna=(string)$_REQUEST["contrasenna"];
    /* Consultar que el usuario y contrasenna estan en la BDD */
    $resultados= obtenerUsuario($identificador);
    if(isset($_POST["recordar"])){
        generarCookieRecordar($resultados);
    }
    /* SI hay un solo resultado---> Inicio session correcto */

    if(count($resultados)==1 && password_verify("$contrasenna",$resultados[0]["contrasenna"])){
        $id=(int)$resultados[0]["id"];
        $identificador=(string)$resultados[0]["identificador"];
        $nombre=(string)$resultados[0]["nombre"];
        $apellidos=(string)$resultados[0]["apellidos"];
        marcarSesionComoIniciada($id,$identificador,$nombre,$apellidos);
    }else{
        $_SESSION["txto"]="El usuario o la contraseña no son correctos";
        redireccionar("SessionInicioFormulario.php");
    }


