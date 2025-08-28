<?php

namespace Application;

use Infrastructure\RepositorioCitasArchivo;
use Domain\LogOperacionInterface;
use Application\NotificacionService;

class AprobacionCitaService
{
    private RepositorioCitasArchivo $repoCitas;
    private LogOperacionInterface $log;
    private NotificacionService $notificacionService;

    public function __construct(RepositorioCitasArchivo $repoCitas, LogOperacionInterface $log, NotificacionService $notificacionService)
    {
        $this->repoCitas = $repoCitas;
        $this->log = $log;
        $this->notificacionService = $notificacionService;
    }

    public function aprobar(string $idCita): void
    {
        $cita = $this->repoCitas->obtenerPorId($idCita);
        if ($cita) {
            $cita->aprobar();
            $this->repoCitas->reservar($cita);
            $this->log->registrar('aprobacion_cita', ['id' => $idCita]);
            $mensaje = 'Su cita ha sido aprobada.';
            $this->notificacionService->notificar($cita->getPaciente(), $mensaje);
        }
    }

    public function rechazar(string $idCita): void
    {
        $cita = $this->repoCitas->obtenerPorId($idCita);
        if ($cita) {
            $cita->rechazar();
            $this->repoCitas->reservar($cita);
            $this->log->registrar('rechazo_cita', ['id' => $idCita]);
            $mensaje = 'Su cita ha sido rechazada.';
            $this->notificacionService->notificar($cita->getPaciente(), $mensaje);
        }
    }
}
