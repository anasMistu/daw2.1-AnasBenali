<?php

declare(strict_types=1);

function obtenerPdoConexionBD(): PDO
{
    $servidor = "localhost";
    $bd = "MiniFb";
    $identificador = "root";
    $contrasenna = "";
    $opciones = [
        PDO::ATTR_EMULATE_PREPARES   => false, // turn off emulation mode for "real" prepared statements
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array
    ];

    try {
        $conexion = new PDO("mysql:host=$servidor;dbname=$bd;charset=utf8", $identificador, $contrasenna, $opciones);
    } catch (Exception $e) {
        error_log("Error al conectar: " . $e->getMessage()); // El error se vuelca a php_error.log
        exit('Error al conectar'); //something a user can understand
    }

    return $conexion;
}

function obtenerUsuario(string $identificador, string $contrasenna): ?array
{
    $pdo = obtenerPdoConexionBD();
    $sql="SELECT * FROM Usuario WHERE identificador='$identificador' AND contrasenna='$contrasenna'";
    $select= $pdo->prepare($sql);
    $select->execute([]);
    $resultados= $select->fetchAll();
    /* No he consiguido que funcione de esta manera
    $id=$resultados[0]['id'];
    $nombre=$resultados[0]['nombre'];
    $apellidos=$resultados[0]['apellidos'];
    $identificadorr=$resultados[0]['identificador'];
    */
    return $resultados;
}

function marcarSesionComoIniciada(int $id, string $identificador, string $nombre, string $apellidos)
{
    session_start();
    $_SESSION["id"]=$id;
    $_SESSION["identificador"]=$identificador;
    $_SESSION["nombre"] =$nombre;
    $_SESSION["apellidos"]=$apellidos;
    redireccionar("02ContenidoPrivado1.php");
}

function haySesionIniciada(): bool{
        if(isset($_SESSION["id"])){
             return TRUE;
        }else{
            return FALSE;
        }
}

function cerrarSesion()
{
    //session_start();

    session_unset();

    session_destroy();

    redireccionar("01SessionMostrarFormulario.php");
}

// (Esta función no se utiliza en este proyecto pero se deja por si se optimizase el flujo de navegación.)
// Esta función redirige a otra página y deja de ejecutar el PHP que la llamó:
function redireccionar(string $url)
{
    header("Location: $url");
    exit;
}

function syso(string $contenido)
{
    file_put_contents('php://stderr', $contenido . "\n");
}