<?php

namespace Application;

use Domain\CitaMedica;
use Infrastructure\RepositorioCitasArchivo;
use Domain\LogOperacionInterface;
use Application\NotificacionService;

class ReprogramacionCitaService
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

    public function reprogramar(CitaMedica $cita): void
    {
        $this->repoCitas->reprogramar($cita);
        $this->log->registrar('reprogramacion_cita', ['id' => $cita->getId(), 'fecha' => $cita->getFecha(), 'hora' => $cita->getHora()]);
        $mensaje = 'Su cita ha sido reprogramada.';
        $this->notificacionService->notificar($cita->getPaciente(), $mensaje);
    }
}
