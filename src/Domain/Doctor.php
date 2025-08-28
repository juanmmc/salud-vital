<?php

namespace Domain;

use Domain\Persona;

class Doctor extends Persona
{
    private Especialidad $especialidad;
    /** @var CitaMedica[] */
    private array $agenda = [];

    public function __construct(string $id, string $nombre, string $apellido, string $dni, string $telefono, string $email, Especialidad $especialidad)
    {
        parent::__construct($id, $nombre, $apellido, $dni, $telefono, $email);
        $this->especialidad = $especialidad;
    }

    public function getEspecialidad(): Especialidad
    {
        return $this->especialidad;
    }

    /**
     * Agrega una cita a la agenda del doctor
     */
    public function agregarCita(CitaMedica $cita): void
    {
        $this->agenda[] = $cita;
    }

    /**
     * Obtiene todas las citas de la agenda
     * @return CitaMedica[]
     */
    public function getAgenda(): array
    {
        return $this->agenda;
    }

    /**
     * Obtiene las citas del día especificado (formato 'Y-m-d')
     * @return CitaMedica[]
     */
    public function getCitasDelDia(string $fecha): array
    {
        return array_filter($this->agenda, function (CitaMedica $cita) use ($fecha) {
            return $cita->getFecha() === $fecha;
        });
    }
}
