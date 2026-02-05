<?php require_once 'clima_logic.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clima Profesional | Cd. Carmen</title>
    <link rel="stylesheet" href="estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<div class="weather-card">
    <?php if ($error): ?>
        <div class="error-banner">
            <i class="fas fa-wifi"></i> <?php echo $error; ?>
        </div>
    <?php else: ?>
        <?php 
            $actual = $data['dataseries'][0]; 
            $info = traducirClima($actual['weather']);
        ?>

        <header>
            <div class="location"><i class="fas fa-map-marker-alt"></i> Cd. Carmen</div>
            <div class="date-info"><?php echo fechaEspanol(); ?></div>
            <div class="live-clock" id="reloj">--:--:--</div>
        </header>

        <div class="main-weather">
            <i class="fas <?php echo $info['icon']; ?> main-icon <?php echo $info['anim']; ?>"></i>
            
            <div class="temp-large"><?php echo $actual['temp2m']; ?>°</div>
            <div class="weather-desc"><?php echo $info['text']; ?></div>
        </div>

        <div class="details-grid">
            <div class="detail-box">
                <i class="fas fa-wind"></i>
                <span class="detail-label">Viento</span>
                <span class="detail-value"><?php echo $actual['wind10m']['speed']; ?> km/h</span>
            </div>
            <div class="detail-box">
                <i class="fas fa-droplet"></i> <span class="detail-label">Humedad</span>
                <span class="detail-value"><?php echo $actual['rh2m']; ?></span>
            </div>
            <div class="detail-box">
                <i class="fas fa-cloud"></i>
                <span class="detail-label">Nubes</span>
                <span class="detail-value"><?php echo $actual['cloudcover']; ?>/9</span>
            </div>
            <div class="detail-box">
                <i class="fas fa-umbrella"></i>
                <span class="detail-label">Lluvia</span>
                <span class="detail-value"><?php echo $actual['prec_type']; ?></span>
            </div>
        </div>

        <div class="forecast-section">
            <div class="forecast-title">Próximas horas</div>
            <div class="forecast-container">
                <?php 
                // Mostramos 4 periodos futuros
                for ($i = 1; $i <= 4; $i++): 
                    $fData = $data['dataseries'][$i];
                    $fInfo = traducirClima($fData['weather']);
                ?>
                <div class="forecast-mini">
                    <span>+<?php echo $fData['timepoint']; ?>h</span>
                    <i class="fas <?php echo $fInfo['icon']; ?>"></i>
                    <strong><?php echo $fData['temp2m']; ?>°</strong>
                </div>
                <?php endfor; ?>
            </div>
        </div>

    <?php endif; ?>
</div>

<script src="main.js"></script>

</body>
</html>