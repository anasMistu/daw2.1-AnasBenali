<?php
declare(strict_types=1);
session_start();

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

/*------ Funcion para marcar la session iniciada -------*/
function obtenerUsuario(string $identificador): ?array
{
    $pdo = obtenerPdoConexionBD();
    $sql="SELECT * FROM Usuario WHERE identificador='$identificador'";
    $select= $pdo->prepare($sql);
    $select->execute([]);
    $resultados= $select->fetchAll();
    return $resultados;
}

/*------- Funcion para  Crear Usuario (insert a BDD) --------*/
function crearUsuario(string $identificador, string $nombre, string $apellidos,string $contrasenna){
    $codigoCookie="NULL";
    $tipoUsuario=0;
    $pdo=obtenerPdoConexionBD();
    $verificarIdentificador=obtenerUsuario($identificador);
    if(!empty($verificarIdentificador)){
        $_SESSION["txt"]="¡ERROR! El usuario introducido ya existe.";
        redireccionar("UsuarioNuevoFormulario.php");
    }else{
        $sqlSentencia="INSERT INTO Usuario (identificador,contrasenna,codigoCookie,tipoUsuario,nombre,apellidos) VALUES (?,?,?,?,?,?)";
        $sqlInsert= $pdo->prepare($sqlSentencia);
        $sqlInsert->execute([$identificador,password_hash($contrasenna,PASSWORD_BCRYPT),$codigoCookie,$tipoUsuario,$nombre,$apellidos]);
        if($sqlInsert->rowCount()==1){
            $_SESSION["txt"]="¡La cuenta se ha creado correctamente! Ya pudes iniciar session.";
            redireccionar("UsuarioNuevoFormulario.php");
        }else{
            $_SESSION["txt"]="¡ERROR! No se ha podido crear la cuenta, intentalo otra vez.";
            redireccionar("UsuarioNuevoFormulario.php");
        }
    }

}
/*------ Funcion para actualizar datos de un usuario -------*/
function actualizarDatos(array $datos){
    $id=$datos[0]["id"];
    $identificador=$datos[0]["identificador"];
    $nombre=$datos[0]["nombre"];
    $apellidos=$datos[0]["apellidos"];
    /*----- Verificar si el identificador no existe -----*/
    $verificarIdentificador=obtenerUsuario($identificador);
    //TODO: Solucionar el problema del identificador al cambiar
    if(count($verificarIdentificador)!=0){
        $_SESSION["msg"]="¡El usuario que has introducido ya existe!";
        redireccionar("UsuarioPerfilVer.php?identificador=$identificador");
    }else{
        $pdo=obtenerPdoConexionBD();
        $sqlSentencia="UPDATE Usuario SET identificador=?,nombre=?,apellidos=? WHERE id=?";
        $sqlUpdate=$pdo->prepare($sqlSentencia);
        $sqlUpdate->execute([$identificador,$nombre,$apellidos,$id]);
        if($sqlUpdate->rowCount()==1){
            $_SESSION["msg"]="¡Los cambios se han guardado correctamente!";
            redireccionar("UsuarioPerfilVer.php?identificador=$identificador");
        }else{
            $_SESSION["msg"]="¡Ha ocurrido algun error!";
            redireccionar("UsuarioPerfilVer.php?identificador=$identificador");
        }

    }

}

/*------ Funcion para marcar la session iniciada -------*/
function marcarSesionComoIniciada(int $id, string $identificador, string $nombre, string $apellidos)
{
    $_SESSION["id"]=$id;
    $_SESSION["identificador"]=$identificador;
    $_SESSION["nombre"] =$nombre;
    $_SESSION["apellidos"]=$apellidos;
    redireccionar("ContenidoPrivado1.php");
}

/*------ Funcion que devuelve true/false segun la el estado de las sessiones -------*/
function haySesionIniciada(): bool{
        if(isset($_SESSION["id"])){
             return TRUE;
        }else{
            return FALSE;
        }
}

/*------ Funcion para Cerrar session (no tiene mas :)) -------*/
function cerrarSesion()
{
    //session_start();

    session_unset();

    session_destroy();

    redireccionar("SessionInicioFormulario.php");
}


function redireccionar(string $url)
{
    header("Location: $url");
    exit;
}

function syso(string $contenido)
{
    file_put_contents('php://stderr', $contenido . "\n");
}