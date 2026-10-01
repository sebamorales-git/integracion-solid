<?php
// La interfaz del conector. El servicio no sabe con quien se esta comunicando.

interface ClienteStock {
    public function enviar($movimiento);
}
