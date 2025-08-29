<?php

function leer($mensaje) {
    echo $mensaje;
    return trim(fgets(STDIN));
}

function mostrarCitas($citas) {
    if (empty($citas)) {
        echo "No hay citas para mostrar.\n";
        return;
    }
    foreach ($citas as $cita) {
        echo "ID: " . $cita->getId() . " | Paciente: " . $cita->getPaciente()->getId();
        echo " | Fecha: " . $cita->getFecha() . " | Hora: " . $cita->getHora() . " | Estado: " . $cita->getEstado() . "\n";
    }
}