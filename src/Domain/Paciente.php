<?php

namespace Domain;

use Domain\Persona;

class Paciente extends Persona
{
    /** @var CitaMedica[] */
    private array $citas = [];

    public function __construct(string $id, string $nombre, string $apellido, string $dni, string $telefono, string $email)
    {
        parent::__construct($id, $nombre, $apellido, $dni, $telefono, $email);
    }

    /**
     * Agrega una cita al historial del paciente
     */
    public function agregarCita(CitaMedica $cita): void
    {
        $this->citas[] = $cita;
    }

    /**
     * Obtiene todas las citas del paciente
     * @return CitaMedica[]
     */
    public function getCitas(): array
    {
        return $this->citas;
    }
}