<?php

namespace Application;

use Domain\CitaMedica;
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

    public function cancelar(CitaMedica $cita): void
    {
        $this->repoCitas->cancelar($cita);
        $this->log->registrar('cancelacion_cita', ['id' => $cita->getId()]);
        $mensaje = 'Su cita ha sido cancelada.';
        $this->notificacionService->notificar($cita->getPaciente(), $mensaje);
    }
}
