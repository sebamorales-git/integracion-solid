<?php
// Traduce una venta del sistema A a un movimiento del sistema B.

class Transformador {

    public function convertir($venta) {
        $productos = [];

        foreach ($venta->productos as $p) {
            $productos[] = new MovimientoProducto($p["codigo"], $p["cantidad"]);
        }

        return new Movimiento(
            "SALIDA",
            $venta->fecha,
            "VENTA-" . $venta->ventaId,
            $productos
        );
    }
}
