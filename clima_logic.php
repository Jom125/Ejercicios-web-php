<?php
// clima_logic.php
date_default_timezone_set('America/Mexico_City'); // Forzamos hora de México

// Coordenadas Ciudad del Carmen
$apiUrl = "https://www.7timer.info/bin/api.pl?lon=-91.795&lat=18.655&product=civil&output=json";

$response = @file_get_contents($apiUrl);
$data = null;
$error = null;

if ($response === FALSE) {
    $error = "Sin conexión al servicio.";
} else {
    $data = json_decode($response, true);
    if ($data === null) $error = "Error de datos.";
}

function traducirClima($weatherStr) {
    $weatherStr = strtolower(trim($weatherStr));
    
    // Mapeo extendido para evitar signos de interrogación
    $mapa = [
        'clear' => ['icon' => 'fa-sun', 'text' => 'Despejado', 'anim' => 'spin-slow'],
        'clearday' => ['icon' => 'fa-sun', 'text' => 'Día Soleado', 'anim' => 'spin-slow'],
        'clearnight' => ['icon' => 'fa-moon', 'text' => 'Noche Despejada', 'anim' => 'float'],
        'pcloudy' => ['icon' => 'fa-cloud-sun', 'text' => 'Parcialmente Nublado', 'anim' => 'float'],
        'mcloudy' => ['icon' => 'fa-cloud', 'text' => 'Nublado', 'anim' => 'float'],
        'cloudy' => ['icon' => 'fa-cloud', 'text' => 'Muy Nublado', 'anim' => 'float'],
        'humid' => ['icon' => 'fa-water', 'text' => 'Húmedo', 'anim' => 'pulse'],
        'lightrain' => ['icon' => 'fa-cloud-rain', 'text' => 'Lluvia Ligera', 'anim' => 'pulse'],
        'oshower' => ['icon' => 'fa-cloud-showers-heavy', 'text' => 'Chubascos', 'anim' => 'pulse'],
        'ishower' => ['icon' => 'fa-cloud-sun-rain', 'text' => 'Lluvia Aislada', 'anim' => 'pulse'],
        'lightsnow' => ['icon' => 'fa-snowflake', 'text' => 'Nevada Ligera', 'anim' => 'spin'],
        'rain' => ['icon' => 'fa-cloud-showers-heavy', 'text' => 'Lluvia', 'anim' => 'pulse'],
        'snow' => ['icon' => 'fa-snowflake', 'text' => 'Nieve', 'anim' => 'spin'],
        'ts' => ['icon' => 'fa-bolt', 'text' => 'Tormenta', 'anim' => 'pulse'],
        'tsrain' => ['icon' => 'fa-poo-storm', 'text' => 'Tormenta Lluviosa', 'anim' => 'pulse']
    ];

    // Fallback: Si no existe, devuelve una nube genérica para que no se vea feo
    return $mapa[$weatherStr] ?? ['icon' => 'fa-cloud', 'text' => ucfirst($weatherStr), 'anim' => 'float'];
}

// Función auxiliar para fecha en español
function fechaEspanol() {
    $dias = ["Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado"];
    $meses = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
    return $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1];
}
?>