<?php
// api/index.php

header("Access-Control-Allow-Origin: *");
header("Content-Type: text/html; charset=UTF-8");

// Recibir JSON desde fetch
$data = json_decode(file_get_contents('php://input'), true);

$nombreCliente = $data['nombre_cliente'] ?? '';
$direccionCliente = $data['direccion_cliente'] ?? '';
$arr = $data['arr'] ?? [];
$cantidad = $data['cantidad'] ?? [];

date_default_timezone_set('America/Bogota');
$fecha = date("d/m/Y H:i:s");

$total = 0;

$ar = fopen("/tmp/db.txt", "w") or die("Problemas en la creacion");

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

if (!empty($arr)) {
    foreach ($arr as $item => $id) {
        list($nombre, $precio) = explode('|', $id);
        $cant = $cantidad[$item] ?? 0;

        fputs($ar, "$nombre                             $ $precio          $cant \n");

        $pedido[] = [
            "nombre" => $nombre,
            "precio" => $precio,
            "cantidad" => $cant,
            "subtotal" => $precio * $cant
        ];

        $total += ($precio * $cant);
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
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <title>Factura</title>
    <link href="../src/output.css" rel="stylesheet" />
</head>

<body>
    <div class="max-w-lg mx-auto mt-10 p-6 rounded-xl shadow-lg bg-white border border-gray-300">
        <h2 class="text-3xl font-bold text-center text-red-600 mb-6 drop-shadow">🍕 Pizzería El Atraco</h2>
        <p class="text-center text-gray-600 mb-4">Resumen del pedido</p>
        <p class="text-gray-600 py-2"><b>Cliente:</b> <?= htmlspecialchars($nombreCliente) ?></p>
        <p class="text-gray-600 py-2"><b>Dirección:</b> <?= htmlspecialchars($direccionCliente) ?></p>
        <p class="text-gray-600 mb-2"><strong>Fecha:</strong> <?= $fecha ?></p>
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
                        <td class="py-2"><?= htmlspecialchars($p['nombre']) ?></td>
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
            <a href="../index.html" class="px-4 py-2 bg-red-600 text-white font-bold rounded-lg shadow">Nuevo pedido</a>
        </div>
    </div>
</body>

</html>
