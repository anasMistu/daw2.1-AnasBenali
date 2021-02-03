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
    public static function haySesionRamIniciada(): bool
    {
        // Está iniciada si isset($_SESSION["id"])
        return isset($_SESSION["id"]);
    }

    public static function intentarCanjearSesionCookie(): bool
    {
        if (isset($_COOKIE["identificador"]) && isset($_COOKIE["codigoCookie"])) {
            $arrayUsuario = DAO::obtenerUsuarioPorCodigoCookie($_COOKIE["identificador"], $_COOKIE["codigoCookie"]);
            $usuario=DAO::crearUsuarioDesdeRs($arrayUsuario);
            if ($arrayUsuario) {
                DAO::establecerSesionRam($usuario);
               DAO::generarCookieRecordar($usuario); // Para re-generar el numerito.
                return true;
            } else { // Venían cookies pero los datos no estaban bien.
                DAO::borrarCookies(); // Las borramos para evitar problemas.
                return false;
            }
        } else { // No vienen ambas cookies.
            DAO::borrarCookies(); // Las borramos por si venía solo una de ellas, para evitar problemas.
            return false;
        }
    }

    public static function borrarCookies()
    {
        setcookie("identificador", "", time() - 3600); // Tiempo en el pasado, para (pedir) borrar la cookie.
        setcookie("codigoCookie", "", time() - 3600); // Tiempo en el pasado, para (pedir) borrar la cookie.}
    }

    public static function destruirSesionRamYCookie()
    {
        //actualizarCodigoCookieEnBD(Null);
        self::anotarCookieEnBDD("NULL",$_SESSION["identificador"],"NULL");
        DAO::borrarCookies();
        session_destroy();
        unset($_SESSION); // Por si acaso
    }
    public static function pintarInfoSesion() {
        if (DAO::haySesionRamIniciada()) {
            echo "<span>Sesión iniciada por <a href='UsuarioPerfilVer.php?identificador=$_SESSION[identificador]'>$_SESSION[identificador]</a> ($_SESSION[nombre] $_SESSION[apellidos]) <a href='SesionCerrar.php'>Cerrar sesión</a></span>";
        } else {
            echo "<a href='SesionInicioFormulario.php'>Iniciar sesión</a>";
        }
    }
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
        $identificador = $usuario->getIdentificador();
        $fecha_actual = date("Y/m/d H:i:s");
        $caducidadCodigoCookie=date("Y/m/d H:i:s",strtotime($fecha_actual."+ 1 days"));

        // actualizar el codigoCookie en la BDD
        DAO::anotarCookieEnBDD($codigoCookie, $identificador,$caducidadCodigoCookie);
        // anotar la cookie en el navegador
        $identificador = $usuario->getIdentificador();
        $valorCookie = $codigoCookie;
        setcookie("identificador", $identificador, time() + 86400);
        setcookie("codigoCookie", $valorCookie, time() + 86400);
    }
    public static function anotarCookieEnBDD($codigoCookie, $idUsuario,$caducidadCodigoCookie): bool
    {
        $pdo = DAO::obtenerPdoConexionBD();
        if ($codigoCookie == "NULL") {
            $codigoCookie = NULL;
            $caducidadCodigoCookie=NULL;
        }
        $sqlSentencia = "UPDATE Usuario SET codigoCookie=?,caducidadCodigoCookie=? WHERE identificador=?";

        $sqlUpdate = $pdo->prepare($sqlSentencia);
        $sqlUpdate->execute([$codigoCookie,$caducidadCodigoCookie, $idUsuario]);
        if ($sqlUpdate->rowCount() == 1) {
            return true;
        } else {
            return false;
        }
    }
    public static function establecerSesionRam(Usuario $usuario)
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
    public static function verificarUsuario($identificador): bool
    {
        $sql="SELECT * FROM Usuario WHERE identificador=?";
        $usuario=DAO::ejecutarConsultaObtener($sql,[$identificador]);
        if($usuario){
            return true;
        }else{
            return false;
        }
    }
    public static function obtenerUsuarioPorCodigoCookie(string $identificador, string $codigoCookie): ?array
    {
        $conexion = DAO::obtenerPdoConexionBD();

        $sql = "SELECT * FROM Usuario WHERE identificador=? AND codigoCookie=?";
        $select = $conexion->prepare($sql);
        $select->execute([$identificador, $codigoCookie]);
        $rs = $select->fetchAll();

        // $rs[0] es la primera (y esperemos que única) fila que ha podido venir. Es un array asociativo.
        return $select->rowCount()==1 ? $rs[0] : null;
    }

    public static function crearUsuarioDesdeRs(array $arrayInfo): Usuario
    {
        $id=$arrayInfo["id"];
        $identificador=$arrayInfo["identificador"];
        $contrasenna=$arrayInfo["contrasenna"];
        $codigoCookie=(string)$arrayInfo["codigoCookie"];
        $caducidadCodigoCookie=(string)$arrayInfo["caducidadCodigoCookie"];
        $tipoUsuario=$arrayInfo["tipoUsuario"];
        $nombre=$arrayInfo["nombre"];
        $apellidos=$arrayInfo["apellidos"];
        return new Usuario($id,$identificador,$contrasenna,$codigoCookie,$caducidadCodigoCookie,$tipoUsuario,$nombre,$apellidos);
    }
    public static function obtenerUsuarioConIdentificador(string $identificador): ?array
    {
        $pdo = DAO::obtenerPdoConexionBD();
        $sql = "SELECT * FROM Usuario WHERE identificador='$identificador' ";
        $select = $pdo->prepare($sql);
        $select->execute([]);
        $resultados = $select->fetchAll();

        return $resultados[0];
    }



    public static function crearUsuario(array $usuario)
    {
        $pdo = DAO::obtenerPdoConexionBD();
        /*CRAGAR LOS DATOS DEL OBJETO*/
        $codigoCookie = NULL;
        $caducidadCodigoCookie=NULL;
        $nombre = (string)$usuario["nombre"];
        $apellidos = (string)$usuario["apellidos"];
        $identificador = (string)$usuario["identificador"];
        $tipoUsuario = $usuario["tipoUsuario"];
        $contrasenna = (string)$usuario["contrasenna"];
        $verificarIdCliente = DAO::obtenerUsuarioConIdentificador(strtolower($identificador));
        if (!empty($verificarIdCliente)) {
            $_SESSION["txt"] = "¡ERROR! El usuario introducido ya existen.";
            redireccionar("UsuarioNuevoFormulario.php");
        } else {
            $sqlSentencia = "INSERT INTO Usuario 
            (identificador,contrasenna,codigoCookie,caducidadCodigoCookie,tipoUsuario,nombre,apellidos )
            VALUES (?,?,?,?,?,?,?)";
            $sqlInsert = $pdo->prepare($sqlSentencia);
            $sqlInsert->execute([
                $identificador,password_hash($contrasenna, PASSWORD_BCRYPT),
                $codigoCookie,$caducidadCodigoCookie,$tipoUsuario , $nombre, $apellidos
            ]);
            if ($sqlInsert->rowCount() == 1) {
                $_SESSION["txt"] = "¡La cuenta se ha creado correctamente! Ya pudes iniciar session.";
                redireccionar("UsuarioNuevoFormulario.php");
            } else {
                $_SESSION["txt"] = "¡ERROR! No se ha podido crear la cuenta, intentalo otra vez.";
                redireccionar("UsuarioNuevoFormulario.php");
            }
        }
    } //FIN FUNCION DE CREAR NUEVO USUARIO




    /*  FUNCIONES PARA PUBLICACION   */
    public static function crearPublicacionDesdeRs(array $arrayInfo): Publicacion
    {
        $id=$arrayInfo["id"];
        $fecha=(string)$arrayInfo["fecha"];
        $emisorId=(string)$arrayInfo["emisorId"];
        $destinatarioId=(string)$arrayInfo["destinatarioId"];
        $destacadaHasta=(string)$arrayInfo["destacadaHasta"];
        $asunto=(string)$arrayInfo["asunto"];
        $contenido=(string)$arrayInfo["contenido"];
        return new Publicacion($id,$fecha,$emisorId,$destinatarioId,$destacadaHasta,$asunto,$contenido);
    }

    public static function publicacionObtenerTodo(){
        if (!isset(DAO::$pdo)) DAO::$pdo = DAO::obtenerPdoConexionBd();
        $sql="SELECT * FROM Publicacion ORDER BY destacadaHasta  DESC";
        $sentencia = DAO::$pdo->prepare($sql);
        $sentencia->execute();
        $resultado = $sentencia->fetchAll();
        return $resultado;
    }

    public static function publicacionCrear(array $publicacion){
        $sql="INSERT INTO Publicacion 
            (fecha,destinatarioId,emisorId,destacadaHasta,asunto,contenido)
            VALUES (?,?,?,?,?,?)";
        $pdo = DAO::obtenerPdoConexionBD();
        $select = $pdo->prepare($sql);
        $select->execute($publicacion);
        //$resultados = $select->fetchAll();
        return $select->rowCount();
    }
}


