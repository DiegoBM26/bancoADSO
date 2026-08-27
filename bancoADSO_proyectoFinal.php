<?php

$usuarios = [
    ["id" => 1, "nombre" => "Juan Perez", "cuenta" => "101", "saldo" => 4000, "contraseña" => "1234"],
    ["id" => 2, "nombre" => "Maria Lopez", "cuenta" => "102", "saldo" => 6000, "contraseña" => "2345"],
    ["id" => 3, "nombre" => "Carlos Gomez", "cuenta" => "103", "saldo" => 5000, "contraseña" => "3456"],
    ["id" => 4, "nombre" => "Ana Rodriguez", "cuenta" => "104", "saldo" => 4500, "contraseña" => "4567"],
    ["id" => 5, "nombre" => "Luis Martinez", "cuenta" => "105", "saldo" => 5500, "contraseña" => "5678"]
];

$retiros = [];

$transferencias = [];

$cuentaEncontrada = false;

$indiceUsuario = -1;

while ($cuentaEncontrada == false) {

    echo "BANCO ADSO\n";
    echo "\n";

    $cuenta = readline("Ingrese su numero de cuenta: ");

    foreach ($usuarios as $indice => $usuario) {

        if ($usuario["cuenta"] == $cuenta) {

            $cuentaEncontrada = true;

            $indiceUsuario = $indice;
        }
    }

    if ($cuentaEncontrada == false) {

        echo "\n";
        echo "La cuenta no existe.\n";
        echo "Intente nuevamente.\n";
        echo "\n";
    }
}

$contraseñaCorrecta = false;

while ($contraseñaCorrecta == false) {

    $contraseña = readline("Ingrese su contraseña: ");

    if ($contraseña == $usuarios[$indiceUsuario]["contraseña"]) {

        $contraseñaCorrecta = true;

        echo "\n";
        echo "Inicio de sesion correcto.\n";
        echo "Bienvenido ";
        echo $usuarios[$indiceUsuario]["nombre"];
        echo "\n";

    } else {

        echo "\n";
        echo "Contraseña incorrecta.\n";
        echo "Intente nuevamente.\n";
    }
}

$opcion = 0;

while ($opcion != 5) {

    echo "\n";
    echo "MENU PRINCIPAL\n";
    echo "\n";
    echo "1. Consultar saldo\n";
    echo "2. Realizar retiro\n";
    echo "3. Realizar transferencia\n";
    echo "4. Consultar informacion\n";
    echo "5. Salir\n";
    echo "\n";

    $opcion = readline("Seleccione una opcion: ");

    if ($opcion == 1) {

        echo "\n";
        echo "CONSULTAR SALDO\n";
        echo "\n";

        echo "Titular: ";
        echo $usuarios[$indiceUsuario]["nombre"];
        echo "\n";

        echo "Numero de cuenta: ";
        echo $usuarios[$indiceUsuario]["cuenta"];
        echo "\n";

        echo "Saldo: $";
        echo $usuarios[$indiceUsuario]["saldo"];
        echo "\n";

    } else if ($opcion == 2) {

        echo "\n";
        echo "REALIZAR RETIRO\n";
        echo "\n";

        $contraseñaRetiro = readline("Ingrese su contraseña: ");

        if ($contraseñaRetiro != $usuarios[$indiceUsuario]["contraseña"]) {

            echo "Contraseña incorrecta.\n";
            echo "No se puede realizar el retiro.\n";

        } else {

            $valorRetiro = readline("Ingrese el valor a retirar: ");

            if ($valorRetiro == "" || !ctype_digit($valorRetiro)) {

                echo "El valor solo puede contener numeros.\n";

            } else if ($valorRetiro <= 0) {

                echo "El valor debe ser mayor que 0.\n";

            } else if ($valorRetiro > $usuarios[$indiceUsuario]["saldo"]) {

                echo "No tiene saldo suficiente.\n";

            } else {

                $usuarios[$indiceUsuario]["saldo"] =
                    $usuarios[$indiceUsuario]["saldo"] - $valorRetiro;

                $retiros[] = [
                    "cuenta" => $usuarios[$indiceUsuario]["cuenta"],
                    "valor" => $valorRetiro,
                    "fecha" => date("d/m/Y")
                ];

                echo "Retiro realizado correctamente.\n";

                echo "Nuevo saldo: $";
                echo $usuarios[$indiceUsuario]["saldo"];
                echo "\n";
            }
        }

    } else if ($opcion == 3) {

        echo "\n";
        echo "TRANSFERENCIA\n";
        echo "\n";

        $contraseñaTransferencia = readline("Ingrese su contraseña: ");

        if ($contraseñaTransferencia != $usuarios[$indiceUsuario]["contraseña"]) {

            echo "Contraseña incorrecta.\n";
            echo "No se puede realizar la transferencia.\n";

        } else {

            $cuentaDestino = readline("Ingrese la cuenta destino: ");

            if ($cuentaDestino == "" || !ctype_digit($cuentaDestino)) {

                echo "La cuenta destino solo puede contener numeros.\n";

            } else {

                $valorTransferencia = readline("Ingrese el valor a transferir: ");

                if ($valorTransferencia == "" || !ctype_digit($valorTransferencia)) {

                    echo "El valor solo puede contener numeros.\n";

                } else {

                    $destinoEncontrado = false;

                    $indiceDestino = -1;

                    foreach ($usuarios as $indice => $usuario) {

                        if ($usuario["cuenta"] == $cuentaDestino) {

                            $destinoEncontrado = true;

                            $indiceDestino = $indice;
                        }
                    }

                    if ($destinoEncontrado == false) {

                        echo "La cuenta destino no existe.\n";

                    } else if ($indiceDestino == $indiceUsuario) {

                        echo "No puede transferir a su propia cuenta.\n";

                    } else if ($valorTransferencia <= 0) {

                        echo "El valor debe ser mayor que 0.\n";

                    } else if ($valorTransferencia > $usuarios[$indiceUsuario]["saldo"]) {

                        echo "No tiene saldo suficiente.\n";

                    } else {

                        $usuarios[$indiceUsuario]["saldo"] =
                            $usuarios[$indiceUsuario]["saldo"] - $valorTransferencia;

                        $usuarios[$indiceDestino]["saldo"] =
                            $usuarios[$indiceDestino]["saldo"] + $valorTransferencia;

                        $transferencias[] = [
                            "cuenta_origen" => $usuarios[$indiceUsuario]["cuenta"],
                            "cuenta_destino" => $usuarios[$indiceDestino]["cuenta"],
                            "valor" => $valorTransferencia,
                            "fecha" => date("d/m/Y")
                        ];

                        echo "Transferencia realizada correctamente.\n";

                        echo "Nuevo saldo: $";
                        echo $usuarios[$indiceUsuario]["saldo"];
                        echo "\n";
                    }
                }
            }
        }

    } else if ($opcion == 4) {

        echo "\n";
        echo "INFORMACION\n";
        echo "\n";

        echo "Nombre: ";
        echo $usuarios[$indiceUsuario]["nombre"];
        echo "\n";

        echo "Cuenta: ";
        echo $usuarios[$indiceUsuario]["cuenta"];
        echo "\n";

        echo "Saldo: $";
        echo $usuarios[$indiceUsuario]["saldo"];
        echo "\n";

        echo "\n";
        echo "RETIROS\n";
        echo "\n";

        $cantidadRetiros = 0;

        $totalRetiros = 0;

        foreach ($retiros as $retiro) {

            if ($retiro["cuenta"] == $usuarios[$indiceUsuario]["cuenta"]) {

                echo "Valor retirado: $";
                echo $retiro["valor"];
                echo "\n";

                echo "Fecha: ";
                echo $retiro["fecha"];
                echo "\n";

                echo "\n";

                $cantidadRetiros++;

                $totalRetiros = $totalRetiros + $retiro["valor"];
            }
        }

        echo "Cantidad de retiros: ";
        echo $cantidadRetiros;
        echo "\n";

        echo "Total retirado: $";
        echo $totalRetiros;
        echo "\n";

        echo "\n";
        echo "TRANSFERENCIAS\n";
        echo "\n";

        $cantidadTransferencias = 0;

        $totalTransferencias = 0;

        foreach ($transferencias as $transferencia) {

            if ($transferencia["cuenta_origen"] == $usuarios[$indiceUsuario]["cuenta"]) {

                echo "Cuenta destino: ";
                echo $transferencia["cuenta_destino"];
                echo "\n";

                echo "Valor transferido: $";
                echo $transferencia["valor"];
                echo "\n";

                echo "Fecha: ";
                echo $transferencia["fecha"];
                echo "\n";

                echo "\n";

                $cantidadTransferencias++;

                $totalTransferencias =
                    $totalTransferencias + $transferencia["valor"];
            }
        }

        echo "Cantidad de transferencias: ";
        echo $cantidadTransferencias;
        echo "\n";

        echo "Total transferido: $";
        echo $totalTransferencias;
        echo "\n";

    } else if ($opcion == 5) {

        echo "\n";
        echo "Gracias por utilizar Banco ADSO.\n";

    } else {

        echo "\n";
        echo "La opcion seleccionada no existe.\n";
    }
}

?>