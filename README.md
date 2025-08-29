# Salud Vital
Primer trabajo del diplomado en microservicios en la NUR, modulo 1

# Indicaciones para uso y verificación de los requerimientos

Comando de ejecución única para insertar datos de especialidades y doctores

```
php cli/seed_cli.php

```

Comando para registrar, actualizar pacientes y reservar, cancelar y reprogramar citas médicas

```
php cli/paciente_cli.php [registrar|actualizar|reservar|cancelar|reprogramar]

```

Comando para consultar agenda diaria, aprobar/rechazar y registrar resumen en citas médicas

```
php cli/doctor_cli.php [agenda|aprobar|rechazar|resumen]

```