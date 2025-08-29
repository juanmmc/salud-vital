<?php

namespace Domain;

use Domain\Doctor;
use Domain\Especialidad;

interface RepositorioDoctoresInterface
{
    public function agregar(Doctor $doctor): void;
    public function obtenerPorId(string $id): ?Doctor;
    /**
     * @return Doctor[]
     */
    public function obtenerTodos(): array;
}
