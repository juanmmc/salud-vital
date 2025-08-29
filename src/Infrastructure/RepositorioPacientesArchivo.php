<?php

namespace Infrastructure;

use Domain\Paciente;
use Domain\RepositorioPacientesInterface;

class RepositorioPacientesArchivo implements RepositorioPacientesInterface
{
    private string $archivo;
    private array $pacientes = [];

    public function __construct(string $archivo)
    {
        $this->archivo = $archivo;
        $this->cargar();
    }

    private function cargar(): void
    {
        if (file_exists($this->archivo)) {
            $json = file_get_contents($this->archivo);
            $this->pacientes = json_decode($json, true) ?? [];
        }
    }

    private function guardar(): void
    {
        file_put_contents($this->archivo, json_encode($this->pacientes));
    }

    public function agregar(Paciente $paciente): void
    {
        $this->pacientes[$paciente->getId()] = [
            'id' => $paciente->getId(),
            'nombre' => $paciente->getNombre(),
            'apellido' => $paciente->getApellido(),
            'dni' => $paciente->getDni(),
            'telefono' => $paciente->getTelefono(),
            'email' => $paciente->getEmail(),
        ];
        $this->guardar();
    }

    public function actualizar(Paciente $paciente): void
    {
        if (isset($this->pacientes[$paciente->getId()])) {
            $this->pacientes[$paciente->getId()] = [
                'id' => $paciente->getId(),
                'nombre' => $paciente->getNombre(),
                'apellido' => $paciente->getApellido(),
                'dni' => $paciente->getDni(),
                'telefono' => $paciente->getTelefono(),
                'email' => $paciente->getEmail(),
            ];
            $this->guardar();
        }
    }

    public function obtenerPorId(string $id): ?Paciente
    {
        if (!isset($this->pacientes[$id])) {
            return null;
        }
        $data = $this->pacientes[$id];
        return new Paciente($data['id'], $data['nombre'], $data['apellido'], $data['dni'], $data['telefono'], $data['email']);
    }

    public function obtenerTodos(): array
    {
        $result = [];
        foreach ($this->pacientes as $data) {
            $result[] = new Paciente($data['id'], $data['nombre'], $data['apellido'], $data['dni'], $data['telefono'], $data['email']);
        }
        return $result;
    }
}
