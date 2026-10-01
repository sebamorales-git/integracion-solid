<?php
// La venta como la manda el sistema A.

class Venta {
    public $ventaId;
    public $fecha;
    public $cajeroId;
    public $productos = [];

    // Arma la venta desde el json que manda la caja
    public function desdeJson($json) {
        $datos = json_decode($json, true);

        // si el json esta roto no hay venta que armar
        if ($datos == null) {
            return null;
        }

        if (!is_array($datos)) {
            return null;
        }

        if (!isset($datos["ventaId"], $datos["fecha"], $datos["productos"])) {
            return null;
        }

        if (!is_array($datos["productos"]) || count($datos["productos"]) == 0) {
            return null;
        }

        $productos = [];

        // los productos malos se saltan, no tiran abajo toda la venta
        foreach ($datos["productos"] as $p) {
            if (!isset($p["codigo"], $p["cantidad"])) {
                continue;
            }

            $cantidad = (int) $p["cantidad"];

            // una cantidad en cero o negativa no tiene sentido para stock
            if ($cantidad <= 0) {
                continue;
            }

            $productos[] = [
                "codigo" => (string) $p["codigo"],
                "cantidad" => $cantidad,
                "precioUnitario" => isset($p["precioUnitario"]) ? (float) $p["precioUnitario"] : 0
            ];
        }

        if (count($productos) == 0) {
            return null;
        }

        $venta = new Venta();
        $venta->ventaId = (int) $datos["ventaId"];
        $venta->fecha = $datos["fecha"];
        $venta->cajeroId = isset($datos["cajeroId"]) ? (int) $datos["cajeroId"] : 0;
        $venta->productos = $productos;

        return $venta;
    }
}
