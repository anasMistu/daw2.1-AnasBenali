<?php

abstract class Dato
{
}
trait Identificable
{
    protected int $id;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }
}

/*----------------- Clase Cliente -------------------*/
class Usuario extends Dato
{
    use Identificable;
    private string $identificador;
    private string $contrasenna;
    private string $codigoCookie;
    private string $caducidadCodigoCookie;
    private int $tipoUsuario;
    private string $nombre;
    private string  $apellidos;

    public function __construct(int $idCliente, string $identificador,string $contrasenna
        , string $codigoCookie, string $caducidadCodigoCookie,int $tipoUsuario, string $nombre, string $apellidos)
    {
        $this->setId($idCliente);
        $this->setIdentificador($identificador);
        $this->setContrasenna($contrasenna);
        $this->setCodigoCookie($codigoCookie);
        $this->setCaducidadCodigoCookie($caducidadCodigoCookie);
        $this->setTipoUsuario($tipoUsuario);
        $this->setNombre($nombre);
        $this->setApellidos($apellidos);
    }

    /*  FUNCIONES GET DE USUARIO  */
    public function getIdentificador(): string{return $this->identificador;}
    public function getContrasenna(): string{return $this->contrasenna;}
    public function getCodigoCookie(): string{return $this->codigoCookie;}
    public function getCaducidadCodigoCookie(): string{return $this->caducidadCodigoCookie;}
    public function getTipoUsuario(): int{return $this->tipoUsuario;}
    public function getNombre(): string{return $this->nombre;}
    public function getApellidos(): string{return $this->apellidos;}

    /*  FUNCIONES SET DE USUARIO  */
    public function setIdentificador(string $identificador): void{$this->identificador = $identificador;}
    public function setContrasenna(string $contrasenna): void{$this->contrasenna = $contrasenna;}
    public function setCodigoCookie(string $codigoCookie): void{$this->codigoCookie = $codigoCookie;}
    public function setCaducidadCodigoCookie(string $caducidadCodigoCookie): void{$this->caducidadCodigoCookie = $caducidadCodigoCookie;}
    public function setTipoUsuario(int $tipoUsuario): void{$this->tipoUsuario = $tipoUsuario;}
    public function setNombre(string $nombre): void{$this->nombre = $nombre;}
    public function setApellidos(string $apellidos): void{$this->apellidos = $apellidos;}


}

class Publicacion extends Dato
{
    use Identificable;
    private int $idPublicacion;
    private string $fecha;
    private string $emisorId;
    private string $distinatorioId;
    private string $destacadaHasta;
    private string $asunto;
    private string  $contenido;

    public function __construct(int $idPublicacion,string $fecha, string $emisorId, string $distinatorioId, string $destacadaHasta, string $asunto, string $contenido)
    {
        $this->setId($idPublicacion);
        $this->setFecha($fecha);
        $this->setEmisorId($emisorId);
        $this->setDistinatorioId($distinatorioId);
        $this->setDestacadaHasta($destacadaHasta);
        $this->setAsunto($asunto);
        $this->setContenido($contenido);
    }

    public function getFecha(): string{return $this->fecha;}
    public function setFecha(string $fecha): void{$this->fecha = $fecha;}

    public function getEmisorId(): string{return $this->emisorId;}
    public function setEmisorId(string $emisorId): void{$this->emisorId = $emisorId;}

    public function getDistinatorioId(): string{return $this->distinatorioId;}
    public function setDistinatorioId(string $distinatorioId): void{$this->distinatorioId = $distinatorioId;}


    public function getDestacadaHasta(): string{return $this->destacadaHasta;}
    public function setDestacadaHasta(string $destacadaHasta): void{$this->destacadaHasta = $destacadaHasta;}

    public function getAsunto(): string{return $this->asunto;}
    public function setAsunto(string $asunto): void{$this->asunto = $asunto;}

    public function getContenido(): string{return $this->contenido;}
    public function setContenido(string $contenido): void{$this->contenido = $contenido;}



}