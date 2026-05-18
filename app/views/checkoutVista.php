<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pasarela de Pago </title>
    <style>
        body { font-family: sans-serif; background: #121212; color: #fff; text-align: center; padding: 50px 20px; }
        .checkout-container { background: #1e1e1e; border: 1px solid #333; padding: 30px; display: inline-block; border-radius: 8px; text-align: left; width: 360px; box-shadow: 0 4px 15px rgba(0,0,0,0.5); }
        .alert-simulacion { background: rgba(0, 255, 136, 0.1); border: 1px solid #00ff88; color: #00ff88; padding: 10px; border-radius: 4px; font-size: 12px; margin-bottom: 20px; text-align: center; }
        .pack-resumen { background: #2a2a2a; padding: 12px; border-radius: 6px; margin-bottom: 20px; border-left: 4px solid #fe2c55; }
        label { display: block; font-size: 12px; color: #aaa; margin-bottom: 5px; text-transform: uppercase; }
        input { display: block; width: 100%; margin-bottom: 15px; padding: 10px; box-sizing: border-box; background: #333; color: #fff; border: 1px solid #555; border-radius: 4px; font-size: 15px; }
        .fila-doble { display: flex; gap: 15px; }
        .btn-pagar { background: #00ff88; color: #000; border: none; padding: 12px; width: 100%; font-weight: bold; font-size: 16px; cursor: pointer; border-radius: 4px; transition: 0.2s; margin-top: 10px; }
        .btn-pagar:hover { background: #00cc6e; transform: scale(1.02); }
        .cancelar { color: #888; text-decoration: none; display: block; text-align: center; margin-top: 15px; font-size: 14px; }
    </style>
</head>
<body>

    <div class="checkout-container">
        <h3 style="text-align: center; margin-top: 0; color: #fff;">💳 Pago con Tarjeta</h3>
        
        <div class="alert-simulacion">
            <strong>⚙️ ENTRADA DE SIMULACIÓN:</strong><br>
            Puede introducir cualquier número de tarjeta simulado para validar el flujo.
        </div>

        <div class="pack-resumen">
            <span style="font-size: 11px; color: #aaa; display: block;">PRODUCTO SELECCIONADO</span>
            <strong style="font-size: 18px; color: #fff;"><?php echo $nombrePack; ?></strong><br>
            <span style="color: #fe2c55; font-weight: bold;">Total a pagar: <?php echo $precioPack; ?></span>
        </div>

        <form action="/checkout" method="POST">
            <input type="hidden" name="pack_tipo" value="<?php echo $packElegido; ?>">

            <label>Titular de la Tarjeta</label>
            <input type="text" placeholder="Ej. Xavier" required>

            <label>Número de Tarjeta</label>
            <input type="text" placeholder="4000 1234 5678 9010" maxlength="19" required>

            <div class="fila-doble">
                <div>
                    <label>Expiración</label>
                    <input type="text" placeholder="MM/AA" maxlength="5" required>
                </div>
                <div>
                    <label>CVV</label>
                    <input type="password" placeholder="123" maxlength="3" required>
                </div>
            </div>

            <button type="submit" class="btn-pagar">🔒 Confirmar Pago Seguro</button>
        </form>

        <a href="/recargar" class="cancelar">Cancelar y volver</a>
    </div>

</body>
</html>