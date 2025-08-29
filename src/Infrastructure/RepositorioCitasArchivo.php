<?php

namespace Infrastructure;

use Domain\RepositorioCitasInterface;
use Domain\CitaMedica;
use Domain\Paciente;
use Domain\Especialidad;
use Domain\Doctor;

class RepositorioCitasArchivo implements RepositorioCitasInterface
{
    private string $archivo;
    private array $citas = [];

    public function __construct(string $archivo)
    {
        $this->archivo = $archivo;
        $this->cargar();
    }

    private function cargar(): void
    {
        if (file_exists($this->archivo)) {
            $json = file_get_contents($this->archivo);
            $this->citas = json_decode($json, true) ?? [];
        }
    }

    private function guardar(): void
    {
        file_put_contents($this->archivo, json_encode($this->citas));
    }

    public function reservar(CitaMedica $cita): void
    {
        $this->citas[$cita->getId()] = [
            'id' => $cita->getId(),
            'fecha' => $cita->getFecha(),
            'hora' => $cita->getHora(),
            'paciente' => $cita->getPaciente()->getId(),
            'especialidad' => $cita->getEspecialidad()->getId(),
            'doctor' => $cita->getDoctor()->getId(),
            'estado' => $cita->getEstado(),
            'resumen' => $cita->getResumen(),
        ];
        $this->guardar();
    }

    public function cancelar(CitaMedica $cita): void
    {
        $idCita = $cita->getId();
        if (isset($this->citas[$idCita])) {
            $this->citas[$idCita]['estado'] = 'cancelada';
            $this->guardar();
        }
    }

    public function reprogramar(CitaMedica $cita, string $nuevaFecha, string $nuevaHora): void
    {
        $idCita = $cita->getId();
        if (isset($this->citas[$idCita])) {
            $this->citas[$idCita]['fecha'] = $nuevaFecha;
            $this->citas[$idCita]['hora'] = $nuevaHora;
            $this->citas[$idCita]['estado'] = 'reprogramada';
            $this->guardar();
        }
    }

    public function aprobar(CitaMedica $cita): void
    {
        $idCita = $cita->getId();
        if (isset($this->citas[$idCita])) {
            $this->citas[$idCita]['estado'] = 'aprobada';
            $this->guardar();
        }
    }

    public function rechazar(CitaMedica $cita): void
    {
        $idCita = $cita->getId();
        if (isset($this->citas[$idCita])) {
            $this->citas[$idCita]['estado'] = 'rechazada';
            $this->guardar();
        }
    }

    public function registrarResumen(CitaMedica $cita, string $resumen): void
    {
        $idCita = $cita->getId();
        if (isset($this->citas[$idCita])) {
            $this->citas[$idCita]['resumen'] = $resumen;
            $this->guardar();
        }
    }

    public function obtenerPorId(string $idCita): ?CitaMedica
    {
        if (!isset($this->citas[$idCita])) {
            return null;
        }
        $data = $this->citas[$idCita];
        $paciente = new Paciente($data['paciente'], '', '', '', '', '');
        $especialidad = new Especialidad($data['especialidad'], '');
        $doctor = new Doctor($data['doctor'], '', '', '', '', '', $especialidad);
        $cita = new CitaMedica(
            $data['id'],
            $data['fecha'],
            $data['hora'],
            $paciente,
            $especialidad,
            $doctor,
            $data['estado'] ?? 'pendiente'
        );
        return $cita;
    }

    public function obtenerPorDoctor(string $idDoctor, string $fecha): array
    {
        $result = [];
        foreach ($this->citas as $data) {
            if ($data['doctor'] === $idDoctor && $data['fecha'] === $fecha) {
                $paciente = new Paciente($data['paciente'], '', '', '', '', '');
                $especialidad = new Especialidad($data['especialidad'], '');
                $doctor = new Doctor($data['doctor'], '', '', '', '', '', $especialidad);
                $cita = new CitaMedica(
                    $data['id'],
                    $data['fecha'],
                    $data['hora'],
                    $paciente,
                    $especialidad,
                    $doctor,
                    $data['estado'] ?? 'pendiente'
                );
                $result[] = $cita;
            }
        }
        return $result;
    }

    public function obtenerPorPaciente(string $idPaciente): array
    {
        $result = [];
        foreach ($this->citas as $data) {
            if ($data['paciente'] === $idPaciente) {
                $paciente = new Paciente($data['paciente'], '', '', '', '', '');
                $especialidad = new Especialidad($data['especialidad'], '');
                $doctor = new Doctor($data['doctor'], '', '', '', '', '', $especialidad);
                $cita = new CitaMedica(
                    $data['id'],
                    $data['fecha'],
                    $data['hora'],
                    $paciente,
                    $especialidad,
                    $doctor,
                    $data['estado'] ?? 'pendiente'
                );
                $result[] = $cita;
            }
        }
        return $result;
    }
}
