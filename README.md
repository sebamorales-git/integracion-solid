# Integración SOLID: Sistema A → Sistema B

Servicio en PHP que recibe una **venta** del Sistema A (cajas) por POST en formato JSON, la transforma en un **movimiento de stock** (`SALIDA`) y la envía al Sistema B (inventario). El conector hacia el Sistema B es intercambiable: `ClienteStockHttp` envía por HTTP y `ClienteFalso` guarda el resultado en `datos/ultimo_movimiento.json` para probar sin el Sistema B.

## Cómo probarlo

1. Copia la carpeta a `C:\xampp\htdocs\` y levanta Apache desde XAMPP.
2. Desde la raíz del proyecto, ejecuta (ajusta el puerto si es necesario):

```bash
curl -X POST http://localhost:3000/integracion-solid/controller/index.php -H "Content-Type: application/json" --data-binary "@datos/ventas.json"
```

3. Revisa el resultado en `datos/ultimo_movimiento.json` y en `datos/transacciones.log`.

Para elegir el conector, edita `controller/index.php` y comenta o descomenta `ClienteStockHttp` / `ClienteFalso`.

## Respuestas del endpoint

| Código | Cuándo ocurre |
|---|---|
| `200` | Venta válida y movimiento enviado correctamente. |
| `400` | La petición llegó sin cuerpo. |
| `405` | Se usó un método distinto de POST. |
| `422` | El JSON es inválido o faltan campos obligatorios (`ventaId`, `fecha`, `productos` con `codigo` y `cantidad`). |
| `502` | La venta es válida, pero no se pudo avisar al Sistema B. |
