<?php
// Endpoint que recibe la venta del sistema A.
header("Content-Type: application/json; charset=utf-8");

// la interfaz va antes que los clientes porque son los que la implementan
require_once __DIR__ . "/../dto/Venta.php";
require_once __DIR__ . "/../dto/MovimientoProducto.php";
require_once __DIR__ . "/../dto/Movimiento.php";
require_once __DIR__ . "/../servicios/ServicioVenta.php";
require_once __DIR__ . "/../transformador/Transformador.php";
require_once __DIR__ . "/../clientes/ClienteStock.php";
require_once __DIR__ . "/../clientes/ClienteStockHttp.php";
require_once __DIR__ . "/../clientes/ClienteFalso.php";
require_once __DIR__ . "/controller.php";

// para mostrar el 200 sin sistema B, comentá este y descomentá el de abajo
//$cliente = new ClienteStockHttp();
$cliente = new ClienteFalso("../datos/ultimo_movimiento.json");

$controlador = new ControladorVenta($cliente);

[$codigo, $mensaje] = $controlador->manejar();

http_response_code($codigo);
echo json_encode(["mensaje" => $mensaje]);
