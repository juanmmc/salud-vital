<?php
// cli/paciente_cli.php

require_once __DIR__ . '/../src/Domain/Persona.php';
require_once __DIR__ . '/../src/Domain/Paciente.php';
require_once __DIR__ . '/../src/Domain/LogOperacionInterface.php';
require_once __DIR__ . '/../src/Infrastructure/RepositorioPacientesArchivo.php';
require_once __DIR__ . '/../src/Infrastructure/LogOperacionArchivo.php';
require_once __DIR__ . '/../src/Application/RegistroPacienteService.php';

use Domain\Paciente;
use Infrastructure\RepositorioPacientesArchivo;
use Application\RegistroPacienteService;
use Infrastructure\LogOperacionArchivo;

$accion = $argv[1] ?? null;

if (!$accion || !in_array($accion, ['registrar', 'actualizar'])) {
    echo "Uso: php paciente_cli.php [registrar|actualizar]\n";
    exit(1);
}

function leer($mensaje) {
    echo $mensaje;
    return trim(fgets(STDIN));
}

$id = leer('ID: ');
$nombre = leer('Nombre: ');
$apellido = leer('Apellido: ');
$dni = leer('DNI: ');
$telefono = leer('Teléfono: ');
$email = leer('Email: ');

$paciente = new Paciente($id, $nombre, $apellido, $dni, $telefono, $email);

$repo = new RepositorioPacientesArchivo(__DIR__ . '/../data/pacientes.json');
$log = new LogOperacionArchivo(__DIR__ . '/../data/log_operaciones.txt');
$servicio = new RegistroPacienteService($repo, $log);

if ($accion === 'registrar') {
    $servicio->registrar($paciente);
    echo "Paciente registrado correctamente.\n";
} else {
    $repo->actualizar($paciente);
    $log->registrar('actualizacion_paciente', ['id' => $paciente->getId()]);
    echo "Paciente actualizado correctamente.\n";
}
