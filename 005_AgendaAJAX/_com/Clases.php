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

class Categoria extends Dato implements JsonSerializable
{
    use Identificable;

    private string $nombre;
    private array $personasPertenecientes;

    public function __construct(int $id, string $nombre)
    {
        $this->setId($id);
        $this->setNombre($nombre);
    }

    public function jsonSerialize()
    {
        return [
            "nombre" => $this->nombre,
            "id" => $this->id,
        ];

    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre)
    {
        $this->nombre = $nombre;
    }

    public function obtenerPersonasPertenecientes(): array
    {
        if ($this->personasPertenecientes == null) $personasPertenecientes = DAO::personaObtenerPorCategoria($this->id);

        return $personasPertenecientes;
    }
}

class Persona extends Dato
{
    use Identificable;

    private string $nombre;
    private ?string $apellidos;
    private string $telefono;
    private bool $estrella;
    private int $categoriaId;
    private Categoria $categoria;

    public function __construct(int $id, string $nombre, ?string $apellidos, string $telefono, bool $estrella, int $categoriaId)
    {
        $this->setId($id);
        $this->setNombre($nombre);
        $this->setApellidos($apellidos);
        $this->setTelefono($telefono);
        $this->setEstrella($estrella);
        $this->setCategoriaId($categoriaId);
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }
    public function setNombre(string $nombre)
    {
        $this->nombre = $nombre;
    }

    public function getApellidos(): ?string
    {
        return $this->apellidos;
    }
    public function setApellidos(?string $apellidos)
    {
        $this->apellidos = $apellidos;
    }

    public function getTelefono(): string
    {
        return $this->telefono;
    }
    public function setTelefono(string $telefono)
    {
        $this->telefono = $telefono;
    }

    public function getEstrella(): bool
    {
        return $this->estrella;
    }
    public function setEstrella(bool $estrella)
    {
        $this->estrella = $estrella;
    }

    public function getCategoriaId(): int
    {
        return $this->categoriaId;
    }
    public function setCategoriaId(int $categoriaId)
    {
        $this->categoriaId = $categoriaId;
    }

    public function obtenerCategoria(): Categoria
    {
        if ($this->categoria == null) $categoria = DAO::categoriaObtenerPorId($this->categoriaId);

        return $categoria;
    }
}