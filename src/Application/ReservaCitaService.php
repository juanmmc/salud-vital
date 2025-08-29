<?php

namespace Application;

use Domain\CitaMedica;
use Domain\RepositorioCitasInterface;
use Domain\LogOperacionInterface;
use Application\NotificacionService;

class ReservaCitaService
{
    private RepositorioCitasInterface $repoCitas;
    private LogOperacionInterface $log;
    private NotificacionService $notificacionService;

    public function __construct(RepositorioCitasInterface $repoCitas, LogOperacionInterface $log, NotificacionService $notificacionService)
    {
        $this->repoCitas = $repoCitas;
        $this->log = $log;
        $this->notificacionService = $notificacionService;
    }

    public function reservar(CitaMedica $cita): void
    {
        $this->repoCitas->reservar($cita);
        $this->log->registrar('reserva_cita', ['id' => $cita->getId()]);
        $mensaje = 'Su cita ha sido reservada.';
        $this->notificacionService->notificar($cita->getPaciente(), $mensaje);
    }
}
