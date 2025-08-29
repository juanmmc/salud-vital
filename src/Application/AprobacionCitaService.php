<?php

namespace Application;

use Domain\RepositorioCitasInterface;
use Domain\RepositorioDoctoresInterface;
use Domain\LogOperacionInterface;
use Application\NotificacionService;

class AprobacionCitaService
{
    private RepositorioCitasInterface $repoCitas;
    private RepositorioDoctoresInterface $repoDoctores;
    private LogOperacionInterface $log;
    private NotificacionService $notificacionService;

    public function __construct(RepositorioCitasInterface $repoCitas, RepositorioDoctoresInterface $repoDoctores, LogOperacionInterface $log, NotificacionService $notificacionService)
    {
        $this->repoCitas = $repoCitas;
        $this->repoDoctores = $repoDoctores;
        $this->log = $log;
        $this->notificacionService = $notificacionService;
    }

    public function aprobar(string $idCita): void
    {
        $cita = $this->repoCitas->obtenerPorId($idCita);
        if (!$cita) {
            echo "Cita no encontrada.\n";
            exit(1);
        }
        $this->repoCitas->aprobar($cita);
        $this->log->registrar('aprobacion_cita', ['id' => $cita->getId()]);

        $doctor = $this->repoDoctores->obtenerPorId($cita->getDoctor()->getId());
        if (!$doctor) {
            echo "Doctor no encontrado.\n";
            exit(1);
        }
        $mensaje = 'Cita aprobada.';
        $this->notificacionService->notificar($doctor, $mensaje);
        
    }

    public function rechazar(string $idCita): void
    {
        $cita = $this->repoCitas->obtenerPorId($idCita);
        if (!$cita) {
            echo "Cita no encontrada.\n";
            exit(1);
        }
        $this->repoCitas->rechazar($cita);
        $this->log->registrar('rechazo_cita', ['id' => $cita->getId()]);

        $doctor = $this->repoDoctores->obtenerPorId($cita->getDoctor()->getId());
        if (!$doctor) {
            echo "Doctor no encontrado.\n";
            exit(1);
        }
        $mensaje = 'Cita rechazada.';
        $this->notificacionService->notificar($doctor, $mensaje);
    }

}
