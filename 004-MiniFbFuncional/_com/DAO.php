<?php

require_once "Clases.php";
require_once "Varios.php";

class DAO
{
    private static $pdo = null;

    private static function obtenerPdoConexionBD()
    {
        $servidor = "localhost";
        $identificador = "root";
        $contrasenna = "";
        $bd = "MiniFb"; // Schema
        $opciones = [
            PDO::ATTR_EMULATE_PREPARES => false, // Modo emulación desactivado para prepared statements "reales"
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Que los errores salgan como excepciones.
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // El modo de fetch que queremos por defecto.
        ];

        try {
            $pdo = new PDO("mysql:host=$servidor;dbname=$bd;charset=utf8", $identificador, $contrasenna, $opciones);
        } catch (Exception $e) {
            error_log("Error al conectar: " . $e->getMessage());
            exit("Error al conectar" . $e->getMessage());
        }

        return $pdo;
    }

/* FUNCIONE GENERALES */
    private static function ejecutarConsulta(string $sql, array $parametros): ?array
    {
        if (!isset(self::$pdo)) self::$pdo = self::obtenerPdoConexionBd();

        $select = self::$pdo->prepare($sql);
        $select->execute($parametros);
        $rs = $select->fetchAll();

        return $rs;
    }

    public static function generarCookieRecordar(Usuario $usuario)
    {
        // Creamos un código cookie muy complejo (no necesariamente único).
        $codigoCookie = generarCadenaAleatoria(32); // Random...
        $idUsuario = $usuario->getId();
        // actualizar el codigoCookie en la BDD
        DAO::anotarCookieEnBDD($codigoCookie, $idUsuario);
        // anotar la cookie en el navegador
        $identificador = $usuario->getIdentificador();
        $valorCookie = $codigoCookie;
        setcookie("identificador", $identificador, time() + 86400);
        setcookie("clave", $valorCookie, time() + 86400);
    }
    public static function marcarSesionComoIniciada(Usuario $usuario)
    {
        $_SESSION["id"] = $usuario->getId();
        $_SESSION["identificador"] = $usuario->getIdentificador();
        $_SESSION["nombre"] = $usuario->getNombre();
        $_SESSION["apellidos"] = $usuario->getApellidos();
    }

    public static function ejecutarConsultaObtener(string $sql, array $parametros): ?array
    {
        if (!isset(DAO::$pdo)) DAO::$pdo = DAO::obtenerPdoConexionBd();

        $sentencia = DAO::$pdo->prepare($sql);
        $sentencia->execute($parametros);
        $resultado = $sentencia->fetchAll();
        return $resultado;
    }
    public static function ejecutarConsultaActualizar(string $sql, array $parametros): int
    {
        if (!isset(DAO::$pdo)) DAO::$pdo = DAO::obtenerPdoConexionBd();

        $sentencia = DAO::$pdo->prepare($sql);
        $sentencia->execute($parametros);
        return $sentencia->rowCount();
    }

    /*  FUNCIONES PARA USUARIO   */

    public function crearUsuarioDesdeRs(array $arrayInfo): Usuario
    {
        $id=$arrayInfo[0]["id"];
        $identificador=$arrayInfo[0]["identificador"];
        $contrasenna=$arrayInfo[0]["contrasenna"];
        $codigoCookie=$arrayInfo[0]["codigoCookie"];
        $caducidadCodigoCookie=new Date($arrayInfo[0]["caducidadCodigoCookie"]);
        $tipoUsuario=$arrayInfo[0]["tipoUsuario"];
        $nombre=$arrayInfo[0]["nombre"];
        $apellidos=$arrayInfo[0]["apellidos"];
        return new Usuario($id,$identificador,$contrasenna,$codigoCookie,$caducidadCodigoCookie,$tipoUsuario,$nombre,$apellidos);
    }

    /*  FUNCIONES PARA PUBLICACION   */
    public function crearPublicacionDesdeRs(array $arrayInfo): Publicacion
    {
        $id=$arrayInfo[0]["id"];
        $fecha=new Date($arrayInfo[0]["fecha"]);
        $emisorId=$arrayInfo[0]["emisorId"];
        $destinatarioId=$arrayInfo[0]["destinatarioId"];
        $destacadaHasta=new Date($arrayInfo[0]["destacadaHasta"]);
        $asunto=$arrayInfo[0]["asunto"];
        $contenido=$arrayInfo[0]["contenido"];
        return new Publicacion($id,$fecha,$emisorId,$destinatarioId,$destacadaHasta,$asunto,$contenido);
    }



}


