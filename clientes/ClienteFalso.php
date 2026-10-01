<?php
// Conector de prueba, guarda el movimiento en un archivo en vez de mandarlo.
// Se usa comentando el ClienteStockHttp en index.php.
class ClienteFalso implements ClienteStock {

    private $archivo;

    public function __construct($archivo = "datos/ultimo_movimiento.json") {
        $this->archivo = $archivo;
    }

    public function enviar($movimiento) {
        $json = json_encode($movimiento->paraEnviar(), JSON_PRETTY_PRINT);

        if ($json === false) {
            return false;
        }

        return file_put_contents($this->archivo, $json) !== false;
    }
}
