<?php

namespace Infrastructure;

use Domain\Especialidad;
use Domain\RepositorioEspecialidadesInterface;

class RepositorioEspecialidadesArchivo implements RepositorioEspecialidadesInterface
{
    private string $archivo;
    private array $especialidades = [];

    public function __construct(string $archivo)
    {
        $this->archivo = $archivo;
        $this->cargar();
    }

    private function cargar(): void
    {
        if (file_exists($this->archivo)) {
            $json = file_get_contents($this->archivo);
            $this->especialidades = json_decode($json, true) ?? [];
        }
    }

    private function guardar(): void
    {
        file_put_contents($this->archivo, json_encode($this->especialidades));
    }

    public function agregar(Especialidad $especialidad): void
    {
        $this->especialidades[$especialidad->getId()] = [
            'id' => $especialidad->getId(),
            'nombre' => $especialidad->getNombre(),
        ];
        $this->guardar();
    }

    public function obtenerPorId(string $id): ?Especialidad
    {
        if (!isset($this->especialidades[$id])) {
            return null;
        }
        $data = $this->especialidades[$id];
        return new Especialidad($data['id'], $data['nombre']);
    }

    public function obtenerTodos(): array
    {
        $result = [];
        foreach ($this->especialidades as $data) {
            $result[] = new Especialidad($data['id'], $data['nombre']);
        }
        return $result;
    }
}
