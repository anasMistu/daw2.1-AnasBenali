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
        $bd = "Agenda"; // Schema
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

    private static function ejecutarConsulta(string $sql, array $parametros): array
    {
        if (!isset(self::$pdo)) self::$pdo = self::obtenerPdoConexionBd();

        $select = self::$pdo->prepare($sql);
        $select->execute($parametros);
        $rs = $select->fetchAll();

        return $rs;
    }

    // Devuelve:
    //   - null: si ha habido un error
    //   - 0, 1 u otro número positivo: OK (no errores) y estas son las filas afectadas.
    private static function ejecutarActualizacion(string $sql, array $parametros): ?int
    {
        if (!isset(self::$pdo)) self::$pdo = self::obtenerPdoConexionBd();

        $actualizacion = self::$pdo->prepare($sql);
        $sqlConExito = $actualizacion->execute($parametros);

        if (!$sqlConExito) return null;
        else return self::$pdo->lastInsertId();
    }



    /* CATEGORÍA */

    private static function categoriaCrearDesdeRs(array $fila): Categoria
    {
        return new Categoria($fila["id"], $fila["nombre"]);
    }

    public static function categoriaObtenerPorId(int $id): ?Categoria
    {
        $rs = self::ejecutarConsulta(
            "SELECT * FROM Categoria WHERE id=?",
            [$id]
        );
        if ($rs) return self::categoriaCrearDesdeRs($rs[0]);
        else return null;
    }

    public static function categoriaActualizar($id, $nombre)
    {
        $sql="UPDATE Categoria SET nombre=? WHERE id=?";
        return self::ejecutarConsultaActualizar($sql,[$nombre,$id]);
    }
    public static function eliminarCategoriaPorId(int $id): bool
    {

        $sql = "DELETE FROM Categoria WHERE id=?";

        return self::ejecutarConsultaActualizar($sql, [$id]);
    }
    public static function categoriaEliminar($id){
        $sql = "DELETE FROM Categoria WHERE id=?";
        return self::ejecutarConsulta($sql,[$id]);

    }

    public static function categoriaCrear(string $nombre): Categoria
    {
        $idAutogenerado = self::ejecutarActualizacion(
            "INSERT INTO Categoria (nombre) VALUES (?)",
            [$nombre]
        );

        return self::categoriaObtenerPorId($idAutogenerado);
    }
    public static function ejecutarConsultaActualizar(string $sql, array $parametros): int
    {
        if (!isset(DAO::$pdo)) DAO::$pdo = DAO::obtenerPdoConexionBd();

        $sentencia = DAO::$pdo->prepare($sql);
        $sentencia->execute($parametros);
        return $sentencia->rowCount();
    }
    public static function categoriaObtenerTodas(): array
    {
        $datos = [];

        $rs = self::ejecutarConsulta(
            "SELECT * FROM Categoria ORDER BY nombre",
            []
        );

        foreach ($rs as $fila) {
            $categoria = self::categoriaCrearDesdeRs($fila);
            array_push($datos, $categoria);
        }

        return $datos;
    }

    /* PERSONA */
    private static function personaCrearDesdeRs(array $fila): Persona
    {
        return new Persona($fila["id"], $fila["nombre"], $fila["apellidos"], $fila["telefono"], $fila["estrella"], $fila["categoriaId"]);
    }

    public static function personaObtenerPorId(int $id): ?Persona
    {
        $rs = self::ejecutarConsulta(
            "SELECT * FROM Persona WHERE id=?",
            [$id]
        );
        if ($rs) return self::personaCrearDesdeRs($rs[0]);
        else return null;
    }

    public static function personaActualizar($id, $nombre, $apellidos, $telefono, $estrella, $categoriaId)
    {
        self::ejecutarActualizacion(
            "UPDATE Persona SET nombre=?, apellidos=?, telefono=?, estrella=?, categoriaId=? WHERE id=?",
            [$nombre, $apellidos, $telefono, $estrella, $categoriaId, $id]
        );
    }

    public static function personaCrear(string $nombre, string $apellidos, string $telefono, bool $estrella, int $categoriaId): Persona
    {
        $idAutogenerado = self::ejecutarActualizacion(
            "INSERT INTO Persona (nombre, apellidos, telefono, estrella, categoriaId) VALUES (?, ?, ?, ?, ?)",
            [$nombre, $apellidos, $telefono, $estrella, $categoriaId]
        );

        return self::personaObtenerPorId($idAutogenerado);
    }

    public static function personaObtenerTodas(): array
    {

        return self::ejecutarConsulta(
            "SELECT * FROM Persona ORDER BY nombre",
            []
        );

    }

    public static function personaEliminar(int $id): ?bool
    {
        $correcto= self::ejecutarActualizacion(
            "DELETE FROM Persona WHERE id = ?",
            [$id]
        );
        if($correcto) {
            return true;
        }else {
            return null;
        }
    }

}