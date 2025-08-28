<?php

namespace Application;

use Infrastructure\RepositorioCitasArchivo;
use Domain\LogOperacionInterface;
use Application\NotificacionService;

class CancelacionCitaService
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

    public function cancelar(string $idCita): void
    {
        $this->repoCitas->cancelar($idCita);
        $this->log->registrar('cancelacion_cita', ['id' => $idCita]);
        $cita = $this->repoCitas->obtenerPorId($idCita);
        if ($cita) {
            $mensaje = 'Su cita ha sido cancelada.';
            $this->notificacionService->notificar($cita->getPaciente(), $mensaje);
        }
    }
}
