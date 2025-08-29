<?php

namespace Application;

use Domain\RepositorioCitasInterface;
use Domain\RepositorioPacientesInterface;
use Domain\LogOperacionInterface;
use Application\NotificacionService;

class ReprogramacionCitaService
{
    private RepositorioCitasInterface $repoCitas;
    private RepositorioPacientesInterface $repoPacientes;
    private LogOperacionInterface $log;
    private NotificacionService $notificacionService;

    public function __construct(RepositorioCitasInterface $repoCitas, RepositorioPacientesInterface $repoPacientes, LogOperacionInterface $log, NotificacionService $notificacionService)
    {
        $this->repoCitas = $repoCitas;
        $this->repoPacientes = $repoPacientes;
        $this->log = $log;
        $this->notificacionService = $notificacionService;
    }

    public function reprogramar(string $idCita, string $nuevaFecha, string $nuevaHora): void
    {
        $cita = $this->repoCitas->obtenerPorId($idCita);
        if (!$cita) {
            echo "Cita no encontrada.\n";
            exit(1);
        }
        $this->repoCitas->reprogramar($cita, $nuevaFecha, $nuevaHora);
        $this->log->registrar('reprogramacion_cita', ['id' => $cita->getId(), 'fecha' => $nuevaFecha, 'hora' => $nuevaHora]);

        $paciente = $this->repoPacientes->obtenerPorId($cita->getPaciente()->getId());
        if (!$paciente) {
            echo "Paciente no encontrado.\n";
            exit(1);
        }
        $mensaje = 'Su cita ha sido reprogramada.';
        $this->notificacionService->notificar($paciente, $mensaje);
    }
}
