<?php

namespace Application;

use Domain\CitaMedica;
use Infrastructure\RepositorioCitasArchivo;
use Domain\LogOperacionInterface;

class ResumenCitaService
{
    private RepositorioCitasArchivo $repoCitas;
    private LogOperacionInterface $log;

    public function __construct(RepositorioCitasArchivo $repoCitas, LogOperacionInterface $log)
    {
        $this->repoCitas = $repoCitas;
        $this->log = $log;
    }

    public function registrar(CitaMedica $cita, string $resumen): void
    {
        $this->repoCitas->registrarResumen($cita, $resumen);
        $this->log->registrar('resumen_consulta', ['id' => $cita->getId(), 'resumen' => $resumen]);
    }
}
