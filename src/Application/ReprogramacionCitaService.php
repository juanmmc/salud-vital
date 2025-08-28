<?php

namespace Application;

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

    public function reprogramar(string $idCita, string $nuevaFecha, string $nuevaHora): void
    {
        $this->repoCitas->reprogramar($idCita, $nuevaFecha, $nuevaHora);
        $this->log->registrar('reprogramacion_cita', ['id' => $idCita, 'fecha' => $nuevaFecha, 'hora' => $nuevaHora]);
        $cita = $this->repoCitas->obtenerPorId($idCita);
        if ($cita) {
            $mensaje = 'Su cita ha sido reprogramada.';
            $this->notificacionService->notificar($cita->getPaciente(), $mensaje);
        }
    }
}
