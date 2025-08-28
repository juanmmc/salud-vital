<?php

namespace Application;

use Infrastructure\RepositorioCitasArchivo;

class AgendaDoctorService
{
    private RepositorioCitasArchivo $repoCitas;

    public function __construct(RepositorioCitasArchivo $repoCitas)
    {
        $this->repoCitas = $repoCitas;
    }

    public function obtenerAgenda(string $idDoctor, string $fecha): array
    {
        return $this->repoCitas->obtenerPorDoctor($idDoctor, $fecha);
    }
}
