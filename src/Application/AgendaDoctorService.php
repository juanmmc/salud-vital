<?php

namespace Application;

use Domain\RepositorioCitasInterface;

class AgendaDoctorService
{
    private RepositorioCitasInterface $repoCitas;

    public function __construct(RepositorioCitasInterface $repoCitas)
    {
        $this->repoCitas = $repoCitas;
    }

    public function obtenerAgenda(string $idDoctor, string $fecha): array
    {
        return $this->repoCitas->obtenerPorDoctor($idDoctor, $fecha);
    }
}
