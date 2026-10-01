<?php
// DTO de salida: el movimiento de stock como lo espera el sistema B.
// Solo lleva datos, no sabe de transformaciones ni de envios.

class Movimiento {
    public $tipoMovimiento;
    public $fecha;
    public $referencia;
    public $productos = [];

    public function __construct($tipoMovimiento, $fecha, $referencia, $productos) {
        $this->tipoMovimiento = $tipoMovimiento;
        $this->fecha = $fecha;
        $this->referencia = $referencia;
        $this->productos = $productos;
    }

    public function paraEnviar() {
        $lista = [];

        foreach ($this->productos as $producto) {
            $lista[] = $producto->paraEnviar();
        }

        return [
            "tipoMovimiento" => $this->tipoMovimiento,
            "fecha" => $this->fecha,
            "referencia" => $this->referencia,
            "productos" => $lista
        ];
    }
}
