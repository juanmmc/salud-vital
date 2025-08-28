<?php

namespace Application;

use Infrastructure\RepositorioCitasArchivo;
use Domain\LogOperacionInterface;

class ResumenConsultaService
{
    private RepositorioCitasArchivo $repoCitas;
    private LogOperacionInterface $log;

    public function __construct(RepositorioCitasArchivo $repoCitas, LogOperacionInterface $log)
    {
        $this->repoCitas = $repoCitas;
        $this->log = $log;
    }

    public function registrarResumen(string $idCita, string $resumen): void
    {
        $cita = $this->repoCitas->obtenerPorId($idCita);
        if ($cita) {
            $cita->registrarResumenConsulta($resumen);
            $this->repoCitas->reservar($cita);
            $this->log->registrar('resumen_consulta', ['id' => $idCita, 'resumen' => $resumen]);
        }
    }
}
