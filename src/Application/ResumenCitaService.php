<?php

namespace Application;


use Domain\RepositorioCitasInterface;
use Domain\RepositorioDoctoresInterface;
use Domain\LogOperacionInterface;
use Application\NotificacionService;

class ResumenCitaService
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

    public function registrar(string $idCita, string $resumen): void
    {
        $cita = $this->repoCitas->obtenerPorId($idCita);
        if (!$cita) {
            echo "Cita no encontrada.\n";
            exit(1);
        }
        $this->repoCitas->registrarResumen($cita, $resumen);
        $this->log->registrar('resumen_consulta', ['id' => $cita->getId(), 'resumen' => $resumen]);

        $doctor = $this->repoDoctores->obtenerPorId($cita->getDoctor()->getId());
        if (!$doctor) {
            echo "Doctor no encontrado.\n";
            exit(1);
        }
        $mensaje = 'Registro de resumen registrado.';
        $this->notificacionService->notificar($doctor, $mensaje);
    }
}
