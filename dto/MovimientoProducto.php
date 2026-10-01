<?php
// DTO de salida: un producto del sistema B.
// Solo lleva datos, no sabe de transformaciones ni de envios.

class MovimientoProducto {
    public $codigoProducto;
    public $cantidad;

    public function __construct($codigo, $cantidad) {
        $this->codigoProducto = $codigo;
        $this->cantidad = $cantidad;
    }

    public function paraEnviar() {
        return [
            "codigoProducto" => $this->codigoProducto,
            "cantidad" => $this->cantidad
        ];
    }
}
