<?php

namespace Domain;

use Domain\Paciente;

interface RepositorioPacientesInterface
{
    public function agregar(Paciente $paciente): void;
    public function actualizar(Paciente $paciente): void;
    public function obtenerPorId(string $id): ?Paciente;
    /**
     * @return Paciente[]
     */
    public function obtenerTodos(): array;
}
