<?php

namespace Domain;

use Domain\CitaMedica;

interface RepositorioCitasInterface
{
    public function reservar(CitaMedica $cita): void;
    public function cancelar(CitaMedica $cita): void;
    public function reprogramar(CitaMedica $cita, string $nuevaFecha, string $nuevaHora): void;
    public function aprobar(CitaMedica $cita): void;
    public function rechazar(CitaMedica $cita): void;
    public function registrarResumen(CitaMedica $cita, string $resumen): void;
    public function obtenerPorId(string $idCita): ?CitaMedica;
    /**
     * @return CitaMedica[]
     */
    public function obtenerPorDoctor(string $idDoctor, string $fecha): array;
    /**
     * @return CitaMedica[]
     */
    public function obtenerPorPaciente(string $idPaciente): array;
}
