<?php

namespace Domain;

class Persona
{
    private string $id;
    private string $nombre;
    private string $apellido;
    private string $dni;
    private string $telefono;
    private string $email;

    public function __construct(string $id, string $nombre, string $apellido, string $dni, string $telefono, string $email)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->dni = $dni;
        $this->telefono = $telefono;
        $this->email = $email;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getApellido(): string
    {
        return $this->apellido;
    }

    public function getDni(): string
    {
        return $this->dni;
    }

    public function getTelefono(): string
    {
        return $this->telefono;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function actualizarNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function actualizarApellido(string $apellido): void
    {
        $this->apellido = $apellido;
    }

    public function actualizarTelefono(string $telefono): void
    {
        $this->telefono = $telefono;
    }

    public function actualizarEmail(string $email): void
    {
        $this->email = $email;
    }

}