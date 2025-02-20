<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galería de Gallos</title>
	<link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
	<header>
	 <div class="header-content">
		<img src="imagenes/logo.png" alt="Logo de la Granja">
		<h1>Palenque <br> Quinta Laguna</h1>
	</div>
	</header>
	
    <h1 class="torneo-title">Torneo de Pollos</h1>
	
	<!-- Menú de botones en el lado izquierdo -->
    <nav id="menu">
        
    </nav>
	
    <div id="gallery"></div>

    <script>
        // PHP pasa los nombres de las carpetas a JavaScript
        const carpetas = <?php
            $directorio = '2025/';
            $carpetas = array_filter(glob($directorio . '*'), 'is_dir');
            $nombresCarpetas = array_map('basename', $carpetas);
            echo json_encode($nombresCarpetas);
        ?>;
    </script>
    <script src="js/scripts.js"></script>
</body>
</html>