<?php
// CAPA DE PROCESOS: Lógica de consumo del servicio

$url = "https://restcountries.com/v3.1/name/mexico";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);

$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);
$info = $data[0]; // Obtenemos el primer resultado
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mashup de Países - SOA</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; display: flex; justify-content: center; padding: 20px; background-color: #e9ecef; }
        .card { background: white; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.2); overflow: hidden; width: 350px; }
        .card-header { background: #007bff; color: white; padding: 15px; text-align: center; }
        .card-body { padding: 20px; }
        .flag { width: 100%; height: auto; border-bottom: 1px solid #ddd; }
        
        ul { list-style: none; padding: 0; }
        li { margin-bottom: 10px; border-bottom: 1px solid #eee; padding-bottom: 5px; }
    </style>
</head>
<body>
    <div class="card">
        <img src="<?php echo $info['flags']['png']; ?>" alt="Bandera" class="flag">
        <img src="<?php echo $info['coatOfArms']['png']; ?>" alt="Bandera" class="flag">
        
        <div class="card-header">
            <h2><?php echo $info['name']['common']; ?></h2>
        </div>
        <div class="card-body">
            <ul>
                <li><strong>Nombre Oficial:</strong> <?php echo $info['name']['official']; ?></li>
                <li><strong>Capital:</strong> <?php echo $info['capital'][0]; ?></li>
                <li><strong>Población:</strong> <?php echo number_format($info['population']); ?></li>
                <li><strong>Región:</strong> <?php echo $info['region']; ?></li>
                <li><strong>Nombre alternativo:</strong> <?php echo $info['altSpellings'][3]; ?></li>
          

            </ul>
        </div>
    </div>
    
    </div>
    
</body>
</html>
