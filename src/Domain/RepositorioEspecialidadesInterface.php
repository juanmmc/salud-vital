<?php

namespace Domain;

use Domain\Especialidad;

interface RepositorioEspecialidadesInterface
{
    public function agregar(Especialidad $especialidad): void;
    public function obtenerPorId(string $id): ?Especialidad;
    /**
     * @return Especialidad[]
     */
    public function obtenerTodos(): array;
}
