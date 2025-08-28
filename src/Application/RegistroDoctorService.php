<?php

namespace Application;

use Domain\Doctor;
use Infrastructure\RepositorioDoctoresArchivo;
use Domain\LogOperacionInterface;

class RegistroDoctorService
{
    private RepositorioDoctoresArchivo $repoDoctores;
    private LogOperacionInterface $log;

    public function __construct(RepositorioDoctoresArchivo $repoDoctores, LogOperacionInterface $log)
    {
        $this->repoDoctores = $repoDoctores;
        $this->log = $log;
    }

    public function registrar(Doctor $doctor): void
    {
        $this->repoDoctores->agregar($doctor);
        $this->log->registrar('registro_doctor', ['id' => $doctor->getId(), 'nombre' => $doctor->getNombre()]);
    }
}
