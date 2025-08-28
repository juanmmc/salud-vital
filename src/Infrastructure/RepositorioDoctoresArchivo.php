<?php

namespace Infrastructure;

use Domain\Doctor;
use Domain\Especialidad;

class RepositorioDoctoresArchivo
{
    private string $archivo;
    private array $doctores = [];

    public function __construct(string $archivo)
    {
        $this->archivo = $archivo;
        $this->cargar();
    }

    private function cargar(): void
    {
        if (file_exists($this->archivo)) {
            $json = file_get_contents($this->archivo);
            $this->doctores = json_decode($json, true) ?? [];
        }
    }

    private function guardar(): void
    {
        file_put_contents($this->archivo, json_encode($this->doctores));
    }

    public function agregar(Doctor $doctor): void
    {
        $this->doctores[$doctor->getId()] = [
            'id' => $doctor->getId(),
            'nombre' => $doctor->getNombre(),
            'apellido' => $doctor->getApellido(),
            'dni' => $doctor->getDni(),
            'telefono' => $doctor->getTelefono(),
            'email' => $doctor->getEmail(),
            'especialidad' => $doctor->getEspecialidad()->getId(),
        ];
        $this->guardar();
    }

    public function obtenerPorId(string $id): ?Doctor
    {
        if (!isset($this->doctores[$id])) {
            return null;
        }
        $data = $this->doctores[$id];
        $especialidad = new Especialidad($data['especialidad'], '');
        return new Doctor($data['id'], $data['nombre'], $data['apellido'], $data['dni'], $data['telefono'], $data['email'], $especialidad);
    }

    public function obtenerTodos(): array
    {
        $result = [];
        foreach ($this->doctores as $data) {
            $especialidad = new Especialidad($data['especialidad'], '');
            $result[] = new Doctor($data['id'], $data['nombre'], $data['apellido'], $data['dni'], $data['telefono'], $data['email'], $especialidad);
        }
        return $result;
    }
}
