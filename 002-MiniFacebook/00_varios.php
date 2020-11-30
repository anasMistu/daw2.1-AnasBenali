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

    $sql ="SELECT * FROM Usuario WHERE identificador=? AND contrasenna=?";
    $select= $pdo->prepare($sql);
    $select->execute([$identificador,$contrasenna]);
    $resultados=$select->fetchAll();
    return $resultados;
}

function marcarSesionComoIniciada(int $id, string $identificador, string $nombre, string $apellidos)
{
    $_SESSION["id"] = "$id";
    $_SESSION["identoficador"] = "$identificador";
    $_SESSION["nombre"] = "$nombre";
    $_SESSION["apellidos"] = "$apellidos";
}

function haySesionIniciada(): boolean
{
if(isset($_SESSION["id"]) && isset($_SESSION["identoficador"]) && isset($_SESSION["nombre"]) && isset($_SESSION["apellidos"])){
    return true;
}else{
    return false;
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