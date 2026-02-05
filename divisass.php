<?php
// --- LÓGICA PHP (Backend) ---
$url = "https://open.er-api.com/v6/latest/USD";
$valor = 0;
$convertido = 0;
$mensaje = "";
$error = "";

// Intentamos obtener los datos
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 5); // Timeout corto para no colgar la página
$response = curl_exec($ch);
curl_close($ch);

if ($response) {
    $data = json_decode($response, true);
    // Usamos el operador de fusión null (??) para seguridad
    $valor = $data['rates']['MXN'] ?? 0;
} else {
    $error = "No se pudo conectar con el servidor de divisas.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cantidad = floatval($_POST['cantidad']);
    
    if ($cantidad > 0 && $valor > 0) {
        $convertido = $cantidad * $valor;
    } elseif ($valor == 0) {
        $error = "No se pudo obtener la tasa de cambio actual.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambio Divisas Pro</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #4e99c8;
            --secondary: #4149e4;
            --accent: #00d2ff;
            --text-dark: #2d3436;
            --text-light: #636e72;
            --white: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            min-height: 100vh;
            display: flex;
            justify-content: center;
            
            align-items: center;
            padding: 20px;
            color: var(--text-dark);
        }

        .container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px); /* Efecto cristal */
            padding: 3rem;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 450px;
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        /* Adorno visual en el fondo de la tarjeta */
        .container::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 150px;
            height: 150px;
            background: var(--accent);
            border-radius: 50%;
            opacity: 0.1;
        }

        h1 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--primary);
            text-align: center;
        }

        h2 {
            font-size: 0.9rem;
            font-weight: 400;
            color: var(--text-light);
            text-align: center;
            margin-bottom: 2rem;
        }

        .input-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .input-group i {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary);
            font-size: 1.2rem;
        }

        input[type="number"] {
            width: 100%;
            padding: 16px 20px 16px 50px; /* Espacio para el icono */
            border: 2px solid #e1e1e1;
            border-radius: 12px;
            font-size: 1.1rem;
            font-family: inherit;
            transition: all 0.3s ease;
            outline: none;
            background: #f9f9f9;
        }

        input[type="number"]:focus {
            border-color: var(--primary);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(78, 84, 200, 0.1);
        }

        button {
            width: 100%;
            padding: 16px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            display: flex;
            justify-content: center;
            
            align-items: center;
            gap: 10px;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(78, 84, 200, 0.3);
        }

        button:active {
            transform: translateY(0);
        }

        /* Caja de Resultados */
        .result-card {
            margin-top: 2rem;
            background: #f0f3ff;
            border-left: 5px solid var(--primary);
            padding: 1.5rem;
            border-radius: 8px;
            animation: slideUp 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .result-amount {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary);
            display: block;
            margin: 10px 0;
        }

        .rate-info {
            font-size: 0.8rem;
            color: var(--text-light);
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .error-msg {
            background: #ffecec;
            color: #d63031;
            padding: 1rem;
            border-radius: 8px;
            text-align: center;
            margin-top: 1rem;
            border: 1px solid #ff7675;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Responsivo */
        @media (max-width: 480px) {
            .container { padding: 2rem; }
            h1 { font-size: 1.5rem; }
        }
    </style>
</head>
<body>

    <div class="container">
        <h1><i class="fa-solid fa-money-bill-transfer"></i> Conversor</h1>
        <h2>Dólares (USD) a Pesos Mexicanos (MXN)</h2>

        <form method="post" action="">
            <div class="input-group">
                <i class="fa-solid fa-dollar-sign"></i>
                <input type="number" name="cantidad" step="0.01" placeholder="Ingresa cantidad USD" required 
                       value="<?php echo isset($_POST['cantidad']) ? htmlspecialchars($_POST['cantidad']) : ''; ?>">
            </div>
            
            <button type="submit">
                Convertir Ahora <i class="fa-solid fa-arrow-right"></i>
            </button>
        </form>

        <?php if (!empty($error)): ?>
            <div class="error-msg">
                <i class="fa-solid fa-triangle-exclamation"></i> <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && $convertido > 0): ?>
            <div class="result-card">
                <span style="font-size: 0.9rem; color: #666;">Estás convirtiendo:</span>
                <div style="font-weight: 600; font-size: 1.1rem;">$<?php echo number_format($cantidad, 2); ?> USD =</div>
                
                <span class="result-amount">$<?php echo number_format($convertido, 2); ?> MXN</span>
                
                <div class="rate-info">
                    <i class="fa-solid fa-chart-line"></i> 
                    Tasa actual: 1 USD = $<?php echo number_format($valor, 2); ?> MXN
                </div>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>