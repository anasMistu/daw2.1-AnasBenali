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
    private Date $caducidadCodigoCookie;
    private int $tipoUsuario;
    private string $nombre;
    private string  $apellidos;

    public function __construct(int $idCliente, string $identificador,string $contrasenna
        , string $codigoCookie, Date $caducidadCodigoCookie,int $tipoUsuario, string $nombre, string $apellidos)
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
    public function getCaducidadCodigoCookie(): Date{return $this->caducidadCodigoCookie;}
    public function getTipoUsuario(): int{return $this->tipoUsuario;}
    public function getNombre(): string{return $this->nombre;}
    public function getApellidos(): string{return $this->apellidos;}

    /*  FUNCIONES SET DE USUARIO  */
    public function setIdentificador(string $identificador): void{$this->identificador = $identificador;}
    public function setContrasenna(string $contrasenna): void{$this->contrasenna = $contrasenna;}
    public function setCodigoCookie(string $codigoCookie): void{$this->codigoCookie = $codigoCookie;}
    public function setCaducidadCodigoCookie(Date $caducidadCodigoCookie): void{$this->caducidadCodigoCookie = $caducidadCodigoCookie;}
    public function setTipoUsuario(int $tipoUsuario): void{$this->tipoUsuario = $tipoUsuario;}
    public function setNombre(string $nombre): void{$this->nombre = $nombre;}
    public function setApellidos(string $apellidos): void{$this->apellidos = $apellidos;}


}

class Publicacion extends Dato
{
    use Identificable;
    private int $idPublicacion;
    private Date $fecha;
    private string $emisorId;
    private string $distinatorioId;
    private Date $destacadaHasta;
    private string $asunto;
    private string  $contenido;

    public function __construct(int $idPublicacion,Date $fecha, string $emisorId, string $distinatorioId, Date $destacadaHasta, string $asunto, string $contenido)
    {
        $this->setId($idPublicacion);
        $this->setFecha($fecha);
        $this->setEmisorId($emisorId);
        $this->setDistinatorioId($distinatorioId);
        $this->setDestacadaHasta($destacadaHasta);
        $this->setAsunto($asunto);
        $this->setContenido($contenido);
    }

    public function getFecha(): Date{return $this->fecha;}
    public function setFecha(Date $fecha): void{$this->fecha = $fecha;}

    public function getEmisorId(): string{return $this->emisorId;}
    public function setEmisorId(string $emisorId): void{$this->emisorId = $emisorId;}

    public function getDistinatorioId(): string{return $this->distinatorioId;}
    public function setDistinatorioId(string $distinatorioId): void{$this->distinatorioId = $distinatorioId;}


    public function getDestacadaHasta(): Date{return $this->destacadaHasta;}
    public function setDestacadaHasta(Date $destacadaHasta): void{$this->destacadaHasta = $destacadaHasta;}

    public function getAsunto(): string{return $this->asunto;}
    public function setAsunto(string $asunto): void{$this->asunto = $asunto;}

    public function getContenido(): string{return $this->contenido;}
    public function setContenido(string $contenido): void{$this->contenido = $contenido;}



}