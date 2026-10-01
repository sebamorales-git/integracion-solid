<?php
// Para probar rapido desde el navegador.
// Usa el cliente falso, no necesita que el sistema B este prendido.

// la interfaz va antes que el cliente porque el cliente la implementa
require_once __DIR__ . "/../dto/Venta.php";
require_once __DIR__ . "/../dto/MovimientoProducto.php";
require_once __DIR__ . "/../dto/Movimiento.php";
require_once __DIR__ . "/../servicios/ServicioVenta.php";
require_once __DIR__ . "/../transformador/Transformador.php";
require_once __DIR__ . "/../clientes/ClienteStock.php";
require_once __DIR__ . "/../clientes/ClienteFalso.php";

$json = file_get_contents("../datos/ventas.json");

$fabrica = new Venta();
$venta = $fabrica->desdeJson($json);

if ($venta == null) {
    echo "La venta vino mal, fijate el ventas.json";
    return;
}

$servicio = new ServicioVenta(new ClienteFalso("../datos/ultimo_movimiento.json"));

if ($servicio->procesar($venta)) {
    file_put_contents("../datos/transacciones.log", date("Y-m-d H:i:s") . "  venta " . $venta->ventaId . "  probada con el cliente falso" . PHP_EOL, FILE_APPEND);

    echo "Venta procesada.<br><br>";
    echo "Esto es lo que se mando al sistema B:<br>";
    echo "<p>" . file_get_contents("../datos/ultimo_movimiento.json") . "</p>";
} else {
    echo "Algo salio mal";
}
