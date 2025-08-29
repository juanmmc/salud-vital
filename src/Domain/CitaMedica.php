<?php

namespace Domain;

class CitaMedica
{
    private string $id;
    private string $fecha;
    private string $hora;
    private Paciente $paciente;
    private Especialidad $especialidad;
    private Doctor $doctor;
    private string $estado; // pendiente, aprobada, rechazada, cancelada, reprogramada
    private ?string $resumen = null;

    public function __construct(
        string $id,
        string $fecha,
        string $hora,
        Paciente $paciente,
        Especialidad $especialidad,
        Doctor $doctor,
        string $estado = 'pendiente'
    ) {
        $this->id = $id;
        $this->fecha = $fecha;
        $this->hora = $hora;
        $this->paciente = $paciente;
        $this->especialidad = $especialidad;
        $this->doctor = $doctor;
        $this->estado = $estado;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getFecha(): string
    {
        return $this->fecha;
    }

    public function getHora(): string
    {
        return $this->hora;
    }

    public function getPaciente(): Paciente
    {
        return $this->paciente;
    }

    public function setPaciente(Paciente $paciente): void
    {
        $this->paciente = $paciente;
    }

    public function getEspecialidad(): Especialidad
    {
        return $this->especialidad;
    }

    public function setEspecialidad(Especialidad $especialidad): void
    {
        $this->especialidad = $especialidad;
    }

    public function getDoctor(): Doctor
    {
        return $this->doctor;
    }

    public function setDoctor(Doctor $doctor): void
    {
        $this->doctor = $doctor;
    }

    public function getEstado(): string
    {
        return $this->estado;
    }

    public function getResumen(): ?string
    {
        return $this->resumen;
    }

}
