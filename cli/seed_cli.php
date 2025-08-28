<?php
// cli/seed_cli.php

require_once __DIR__ . '/../src/Domain/Especialidad.php';
require_once __DIR__ . '/../src/Domain/Persona.php';
require_once __DIR__ . '/../src/Domain/Doctor.php';
require_once __DIR__ . '/../src/Domain/LogOperacionInterface.php';
require_once __DIR__ . '/../src/Infrastructure/RepositorioEspecialidadesArchivo.php';
require_once __DIR__ . '/../src/Infrastructure/RepositorioDoctoresArchivo.php';
require_once __DIR__ . '/../src/Infrastructure/LogOperacionArchivo.php';
require_once __DIR__ . '/../src/Application/RegistroEspecialidadService.php';
require_once __DIR__ . '/../src/Application/RegistroDoctorService.php';

use Domain\Especialidad;
use Domain\Doctor;
use Infrastructure\RepositorioEspecialidadesArchivo;
use Infrastructure\RepositorioDoctoresArchivo;
use Application\RegistroEspecialidadService;
use Application\RegistroDoctorService;
use Infrastructure\LogOperacionArchivo;

$repoEspecialidades = new RepositorioEspecialidadesArchivo(__DIR__ . '/../data/especialidades.json');
$repoDoctores = new RepositorioDoctoresArchivo(__DIR__ . '/../data/doctores.json');
$log = new LogOperacionArchivo(__DIR__ . '/../data/log_operaciones.txt');
$servicioEspecialidad = new RegistroEspecialidadService($repoEspecialidades, $log);
$servicioDoctor = new RegistroDoctorService($repoDoctores, $log);

// Especialidades
$especialidades = [
    new Especialidad('esp1', 'Pediatría'),
    new Especialidad('esp2', 'Cardiología'),
    new Especialidad('esp3', 'Dermatología'),
];
foreach ($especialidades as $esp) {
    $servicioEspecialidad->registrar($esp);
}

// Doctores
$doctores = [
    new Doctor('doc1', 'Ana', 'García', '12345678A', '555-1111', 'anag@gmail.com', $especialidades[0]),
    new Doctor('doc2', 'Luis', 'Martínez', '23456789B', '555-2222', 'luism@gmail.com', $especialidades[1]),
    new Doctor('doc3', 'María', 'López', '34567890C', '555-3333', 'marial@gmail.com', $especialidades[2]),
    new Doctor('doc4', 'Carlos', 'Ruiz', '45678901D', '555-4444', 'carlosr@gmail.com', $especialidades[0]),
    new Doctor('doc5', 'Sofía', 'Torres', '56789012E', '555-5555', 'sofiat@gmail.com', $especialidades[1]),
];
foreach ($doctores as $doc) {
    $servicioDoctor->registrar($doc);
}

echo "Seed completado: 3 especialidades y 5 doctores registrados.\n";
