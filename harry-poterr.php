<?php
// CAPA DE PROCESOS: Lógica de consumo del servicio

$url = "https://hp-api.onrender.com/api/characters"; // API 

$ch = curl_init(); // inicia la conexion
// configura la conexion
curl_setopt($ch, CURLOPT_URL, $url); // establece la URL a la q
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
curl_setopt($ch, CURLOPT_TIMEOUT, 10); 

$response = curl_exec($ch); 
curl_close($ch);

$data = json_decode($response, true); 
$info = $data[0]; 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>harry potter</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; margin-top: 0; background-color: #e9ecef; } 
        .card { background: white; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.2); overflow: hidden; display: flex; flex-direction: row; width: 600px; height: 300px} 
        .card-img-container { width: 40%; background-color: #ddd; } 
        .card-img-container img { width: 100%; height: 100%; object-fit:cover; display: block; } 
       
        .card-header { background: #fcdf03ab; color: white; padding: 15px; text-align: center; } 
        .card-body { padding: 20px; flex-grow: 1; overflow-y: auto  }
        .character { width: 100%; height: auto; border-bottom: 1px solid #ddd; } 
        ul { list-style: none; padding: 0; } 
        li { margin-bottom: 10px; border-bottom: 2px solid #eee; padding-bottom: 5px; } 
        strong { text-transform: capitalize; } 
        
    </style>
</head>
<body>
    <div class="card">
        <div class="card-img-container"> <!-- contenedor de la imagen del personaje-->
            <img src="<?php echo $info['image']; ?>" alt="personaje" class="character">   <!--  foto del personaje-  este pide la url de la imagen* -->
            
        </div>
        <div class="card-header"> <!-- barra azul del nombre del personaje - contenedor de la columna central-->

            <h2><?php echo $info['name']; ?></h2> <!--  imprime el nombre del personaje -->
        </div>
        <div class="card-body">
            <ul>

            <!--  imprime los detalles del personaje -->
                <li><strong>Nombre :</strong> <?php echo $info['name']; ?></li>
                <li><strong>Especie:</strong> <?php echo $info['species']; ?></li>
                <li><strong>Genero:</strong> <?php echo $info['gender']; ?></li>
                <li><strong>casa:</strong> <?php echo $info['house']; ?></li>
                <li><strong>Fecha de nacimiento:</strong> <?php echo $info['dateOfBirth']; ?></li>
                <li><strong>mago:</strong> <?php echo $info['wizard']; ?></li>
                <li><strong>Ascendencia:</strong> <?php echo $info['ancestry']; ?></li>
                <li><strong>varita mágica:</strong> <?php echo $info['wand']['core']; ?></li> 
                <li><strong>Actor:</strong> <?php echo $info['actor']; ?></li>
                
            </ul>
        </div>
    </div>
    
    </div>
    
</body>
</html>
