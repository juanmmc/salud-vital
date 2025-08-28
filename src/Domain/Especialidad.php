<?php

namespace Domain;

class Especialidad
{
    private string $id;
    private string $nombre;

    public function __construct(string $id, string $nombre)
    {
        $this->id = $id;
        $this->nombre = $nombre;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }
}
