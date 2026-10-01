<?php
// El controlador: decide que pasa con la venta que llega del sistema A.
// No imprime ni corta el script, devuelve el codigo http y el mensaje.

class ControladorVenta {

    private $cliente;

    public function __construct($cliente) {
        $this->cliente = $cliente;
    }

    // devuelve un array con el codigo http y el mensaje
    public function manejar() {
        // El sistema A siempre avisa con POST, si viene otra cosa no hay nada que hacer
        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            return [405, "Este endpoint solo recibe ventas por POST"];
        }

        $json = file_get_contents("php://input");

        if ($json === false || $json === "") {
            return [400, "La peticion vino sin datos, falta el json de la venta"];
        }

        // METODO PARA convertir el texto JSON que llego en un objeto Venta de PHP.
        $fabrica = new Venta();
        $venta = $fabrica->desdeJson($json);

        if ($venta == null) {
            return [422, "La venta no se pudo leer: tiene que venir ventaId, fecha y productos con codigo y cantidad"];
        }

        $servicio = new ServicioVenta($this->cliente);

        // true si el sistema B nos dijo que lo guardo
        if ($servicio->procesar($venta)) {
            $this->registrarEnElLog($venta->ventaId, "mandada");
            return [200, "Venta " . $venta->ventaId . " registrada y movimiento enviado al sistema B"];
        }

        $this->registrarEnElLog($venta->ventaId, "no se pudo mandar");
        return [502, "La venta esta bien pero no se pudo avisar al sistema B. Revisa que este prendido en el puerto 3000"];
    }

    // una linea por venta, para ver despues que paso con cada una
    private function registrarEnElLog($ventaId, $anotado) {
        $log = "../datos/transacciones.log";
        file_put_contents($log, date("Y-m-d H:i:s") . "  venta " . $ventaId . "  " . $anotado . PHP_EOL, FILE_APPEND);
    }
}
