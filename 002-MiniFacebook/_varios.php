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

/*------ Funcion para Obtener datos del usuario por identificador(USUARIO) -------*/
function obtenerUsuario(string $identificador): ?array
{
    $pdo = obtenerPdoConexionBD();
    $sql="SELECT * FROM Usuario WHERE identificador='$identificador'";
    $select= $pdo->prepare($sql);
    $select->execute([]);
    $resultados= $select->fetchAll();
    return $resultados;
}
/*------ Funcion para Obtener datos del usuario por identificador(USUARIO) -------*/
function obtenerUsuarioId(string $id): ?array
{
    $pdo = obtenerPdoConexionBD();
    $sql="SELECT * FROM Usuario WHERE id='$id'";
    $select= $pdo->prepare($sql);
    $select->execute([]);
    $resultados= $select->fetchAll();
    return $resultados;
}

/*------- Funcion para  Crear Usuario (insert a BDD) --------*/
function crearUsuario(string $identificador, string $nombre, string $apellidos,string $contrasenna,$foto,$ruta){
    $codigoCookie="NULL";
    $tipoUsuario=0;
    $pdo=obtenerPdoConexionBD();
    $verificarIdentificador=obtenerUsuario($identificador);

    if(!empty($verificarIdentificador)){
        $_SESSION["txt"]="¡ERROR! El usuario introducido ya existe.";
        redireccionar("UsuarioNuevoFormulario.php");
    }else{
        $sqlSentencia="INSERT INTO Usuario (identificador,contrasenna,codigoCookie,tipoUsuario,fotoDePerfil,nombre,apellidos) VALUES (?,?,?,?,?,?,?)";
        $sqlInsert= $pdo->prepare($sqlSentencia);
        $sqlInsert->execute([$identificador,password_hash($contrasenna,PASSWORD_BCRYPT),$codigoCookie,$tipoUsuario,$foto,$nombre,$apellidos]);
        guardarImg($identificador,$foto,$ruta);
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

        $pdo=obtenerPdoConexionBD();
        $sqlSentencia="UPDATE Usuario SET nombre=?,apellidos=? WHERE id=? AND identificador=?";
        $sqlUpdate=$pdo->prepare($sqlSentencia);
        $sqlUpdate->execute([$nombre,$apellidos,$id,$identificador]);
        if($sqlUpdate->rowCount()==1){
            $_SESSION["msg"]="¡Los cambios se han guardado correctamente!";
            redireccionar("UsuarioPerfilVer.php?identificador=$identificador");
        }else{
            $_SESSION["msg"]="¡Ha ocurrido algun error!";
            redireccionar("UsuarioPerfilVer.php?identificador=$identificador");
        }


}

/*------ Funcion para marcar la session iniciada -------*/
function marcarSesionComoIniciada($arrayUsuario)
{
    $_SESSION["id"]=$arrayUsuario[0]["id"];
    $_SESSION["identificador"]=$arrayUsuario[0]["identificador"];
    $_SESSION["nombre"] =$arrayUsuario[0]["nombre"];
    $_SESSION["apellidos"]=$arrayUsuario[0]["apellidos"];
    redireccionar("ContenidoPrivado1.php");
}

function guardarImg($usuario,$foto,$ruta){
    //foto: name del de la foto
    // ruta: ruta temporal
    // usuario: usuario de que vamos a modificar

    $destino= "FotosDePerfil/".$foto;
    copy($ruta, $destino);
    $extension=pathinfo($foto,PATHINFO_EXTENSION);
    $nombreNuevo="$usuario"."."."$extension";
    rename("FotosDePerfil/$foto","FotosDePerfil/"."$nombreNuevo");
    /*------- Insertar en la BDD ---------*/
    $pdo=obtenerPdoConexionBD();
    $sqlSentencia="UPDATE Usuario SET fotoDePerfil=? WHERE identificador=?";
    $sqlUpdate=$pdo->prepare($sqlSentencia);
    $sqlUpdate->execute([$nombreNuevo,$usuario]);
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
    $arrayUsuario=obtenerUsuarioId((string)$_SESSION["id"]);
    borrarCookieRecordar($arrayUsuario);
    session_unset();
    session_destroy();
    redireccionar("SessionInicioFormulario.php");
}

/*--------- funcion para generar la cookie y anotarla en la BDD -----------*/
function generarCookieRecordar(array $arrayUsuario)
{
    // Creamos un código cookie muy complejo (no necesariamente único).
    $codigoCookie = generarCadenaAleatoria(32); // Random...
    $id= $arrayUsuario[0]["id"];
    // actualizar el codigoCookie en la BDD
    anotarCookieEnBDD($codigoCookie,$id);
    // TODO Para una seguridad óptima convendría anotar en la BD la fecha de caducidad de la cookie y no aceptar ninguna cookie pasada dicha fecha.
    // anotar la cookie en el navegador
    $valorIdentificador=$arrayUsuario[0]["identificador"];
    $valorClave=$codigoCookie;
    setcookie("identificador",$valorIdentificador,time()+86400);
    setcookie("clave",$valorClave,time()+86400);

}

/*--------- funcion actualizar el codigo cookie en la BDD -----------*/
function anotarCookieEnBDD( $codigoCookie, $idUsuario): bool {
    $pdo=obtenerPdoConexionBD();
    if($codigoCookie=="NULL"){
        $codigoCookie=NULL;
    }
    $sqlSentencia="UPDATE Usuario SET codigoCookie=? WHERE id=?";

    $sqlUpdate=$pdo->prepare($sqlSentencia);
    $sqlUpdate->execute([$codigoCookie,$idUsuario]);
    if($sqlUpdate->rowCount()==1){
        return true;
    }else{
        return false;
    }

}

/*--------- funcion que comprueba si el codigo cookie y el value estan en la BDD -----------*/
function iniciarSessionConCookie(): bool
{
        if(isset($_COOKIE["identificador"]) && isset($_COOKIE["clave"])){
            $identificador=$_COOKIE["identificador"];
            $codigoCookie=$_COOKIE["clave"];
            $arrayUsuario=obtenerUsuario($identificador);//Obtener usuario con el identificador de la cookie
            // Si hay un usuario con el identificador de la cookie
            // Y ademas coincide el codigoCookie de la BDD y el codigoCookie de la cookie
            if( $arrayUsuario && $arrayUsuario[0]["codigoCookie"]==$codigoCookie ){
                generarCookieRecordar($arrayUsuario);// Generamos otro codigo y renovamos la cookie
                return true;
            }else{
                borrarCookieRecordar($arrayUsuario);// Borranos la cookie
                return false;
            }
        }else{
            return false;
        }

}

/*--------- funcion para borrar la cookie del navegador y la bdd -----------*/
function borrarCookieRecordar(array $arrayUsuario)
{
    // TODO Eliminar el código cookie de nuestra BD.
    $id= $arrayUsuario[0]["id"];
    anotarCookieEnBDD("NULL",$id);
    // TODO Pedir borrar cookie (setcookie con tiempo time() - negativo...)
    setcookie("identificador","",time()-86400);
    setcookie("clave","",time()-86400);
}

/*--------- funcion para generar cadenas aleatorias -----------*/
function generarCadenaAleatoria(int $longitud): string
{
    for ($s = '', $i = 0, $z = strlen($a = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789')-1; $i != $longitud; $x = rand(0,$z), $s .= $a[$x], $i++);
    return $s;
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