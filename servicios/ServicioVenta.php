<?php
// El servicio junta todo: transforma la venta y la manda.

class ServicioVenta {

    private $cliente;
    private $transformador;

    // le paso cualquier cliente que cumpla la interfaz
    public function __construct($cliente, $transformador = null) {
        $this->cliente = $cliente;

        if ($transformador == null) {
            $transformador = new Transformador();
        }

        $this->transformador = $transformador;
    }

    public function procesar($venta) {
        $movimiento = $this->transformador->convertir($venta);
        return $this->cliente->enviar($movimiento);
    }
}
