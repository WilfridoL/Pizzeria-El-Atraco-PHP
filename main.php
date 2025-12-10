<?php
$total = 0;
$nombreCliente = $_POST['nombre_cliente'];
$direccionCliente = $_POST['direccion_cliente'];
date_default_timezone_set('America/Bogota');
$fecha = date("d/m/Y H:i:s");

$ar = fopen("db.txt", "w") or die("Problemas en la creacion");

fputs($ar, "-------------------------------------------------------- \n");
fputs($ar, "\n");
fputs($ar, "                PIZZERIA EL ATRACO \n");
fputs($ar, "\n");
fputs($ar, "-------------------------------------------------------- \n \n");

fputs($ar, "Cliente: $nombreCliente\n");
fputs($ar, "Dirección: $direccionCliente\n");

fputs($ar, "Fecha del pedido: $fecha\n \n");
fputs($ar, "-------------------------------------------------------- \n \n");
fputs($ar, "Productos                               Precio          Cantidad \n");

$pedido = [];

if (!empty($_POST['arr'])) {
    foreach ($_POST['arr'] as $item => $id) {

        list($nombre, $precio) = explode('|', $id);
        $cantidad = $_POST['cantidad'][$item];

        fputs($ar, "$nombre                             $ $precio          $cantidad \n");

        $pedido[] = [
            "nombre" => $nombre,
            "precio" => $precio,
            "cantidad" => $cantidad,
            "subtotal" => $precio * $cantidad
        ];

        $total += ($precio * $cantidad);
    }
}

fputs($ar, "\n");
fputs($ar, "-------------------------------------------------------- \n \n");
fputs($ar, "Total: $ $total \n");
fputs($ar, "\n");
fputs($ar, "-------------------------------------------------------- ");
fclose($ar);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="./src/output.css" rel="stylesheet">

</head>

<body>

    <div class="max-w-lg mx-auto mt-10 p-6 rounded-xl shadow-lg bg-white border border-gray-300">
        <h2 class="text-3xl font-bold text-center text-red-600 mb-6 drop-shadow">🍕 Pizzería El Atraco</h2>
        <p class="text-center text-gray-600 mb-4">Resumen del pedido</p>
        <p class="text-gray-600 py-2"><b>Cliente:</b> <?= $nombreCliente ?></p>
        <p class="text-gray-600 py-2"><b>Dirección:</b> <?= $direccionCliente ?></p>
        <p class="text-gray-600 mb-2">
            <strong>Fecha:</strong> <?= $fecha ?>
        </p>
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b">
                    <th class="py-2 font-semibold">Producto</th>
                    <th class="py-2 font-semibold">Precio</th>
                    <th class="py-2 font-semibold">Cant.</th>
                    <th class="py-2 font-semibold">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pedido as $p): ?>
                    <tr class="border-b">
                        <td class="py-2"><?= $p['nombre'] ?></td>
                        <td class="py-2">$<?= number_format($p['precio']) ?></td>
                        <td class="py-2"><?= $p['cantidad'] ?></td>
                        <td class="py-2 font-semibold">$<?= number_format($p['subtotal']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="text-right mt-4 text-xl font-bold">
            Total: $<?= number_format($total) ?>
        </div>

        <div class="mt-6 text-center">
            <a href="index.html" class=" px-4 py-2 bg-red-600 text-white font-bold rounded-lg shadow">Nuevo pedido</a>
        </div>
    </div>

</body>

</html>