<?php

namespace Application;

use Domain\CitaMedica;
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

    public function aprobar(CitaMedica $cita): void
    {
        $this->repoCitas->aprobar($cita);
        $this->log->registrar('aprobacion_cita', ['id' => $cita->getId()]);
        $mensaje = 'Cita aprobada.';
        $this->notificacionService->notificar($cita->getDoctor(), $mensaje);
    }

    public function rechazar(CitaMedica $cita): void
    {
        $this->repoCitas->rechazar($cita);
        $this->log->registrar('rechazo_cita', ['id' => $cita->getId()]);
        $mensaje = 'Cita rechazada.';
        $this->notificacionService->notificar($cita->getDoctor(), $mensaje);
    }

}
