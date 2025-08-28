<?php

namespace Application;

use Domain\Paciente;
use Infrastructure\RepositorioPacientesArchivo;
use Domain\LogOperacionInterface;

class RegistroPacienteService
{
    private RepositorioPacientesArchivo $repoPacientes;
    private LogOperacionInterface $log;

    public function __construct(RepositorioPacientesArchivo $repoPacientes, LogOperacionInterface $log)
    {
        $this->repoPacientes = $repoPacientes;
        $this->log = $log;
    }

    public function registrar(Paciente $paciente): void
    {
        $this->repoPacientes->agregar($paciente);
        $this->log->registrar('registro_paciente', ['id' => $paciente->getId()]);
    }

    public function actualizar(Paciente $paciente): void
    {
        $this->repoPacientes->actualizar($paciente);
        $this->log->registrar('actualizacion_paciente', ['id' => $paciente->getId()]);
    }
}
