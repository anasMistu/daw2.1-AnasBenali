<?php

abstract class Dato{

}

trait identificable{
    protected $id;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }
}

class Categoria extends Dato{
    use identificable;
    private $nombre;
    public function __construct($id, $nombre){
        $this->setId($id);
        $this->setNombre($nombre);
    }
    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre): void
    {
        $this->nombre = $nombre;
    }
}