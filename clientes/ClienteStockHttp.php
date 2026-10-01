<?php
// El conector real, el que habla con el sistema B por HTTP.
// Si manana cambian la API, se hace otra clase igual y no se toca el resto.

class ClienteStockHttp implements ClienteStock {

    private $url;

    public function __construct($url = "http://localhost:3000/api/stock/movimiento") {
        $this->url = $url;
    }

    public function enviar($movimiento) {
        $ch = curl_init($this->url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($movimiento->paraEnviar()));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);

        $respuesta = curl_exec($ch);

        // si la respuesta es false, cURL no pudo conectarse
        if ($respuesta === false) {
            curl_close($ch);
            return false;
        }

        $codigo = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // de 200 a 299 significa que el sistema B acepto el movimiento
        return ($codigo >= 200 && $codigo < 300);
    }
}
