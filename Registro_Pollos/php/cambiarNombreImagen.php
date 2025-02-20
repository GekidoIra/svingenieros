<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $granja = $_POST['granja'];
    $nombreActual = $_POST['nombreActual'];
    $nuevoNombre = $_POST['nuevoNombre'];

    $directorio = "../2025/$granja/";
    $rutaActual = $directorio . $nombreActual;

    // Obtener la extensión del archivo
    $extension = pathinfo($nombreActual, PATHINFO_EXTENSION);
    $nombreBase = pathinfo($nuevoNombre, PATHINFO_FILENAME); // Nombre sin extensión

    // Función para generar un nombre único
    function generarNombreUnico($directorio, $nombreBase, $extension) {
        $contador = 1;
        $nombreFinal = "$nombreBase.$extension"; // Nombre inicial

        // Verificar si el nombre ya existe
        while (file_exists($directorio . $nombreFinal)) {
            $nombreFinal = "$nombreBase($contador).$extension"; // Agregar número consecutivo
            $contador++;
        }

        return $nombreFinal;
    }

    // Generar un nombre único para el archivo
    $nombreFinal = generarNombreUnico($directorio, $nombreBase, $extension);
    $rutaNueva = $directorio . $nombreFinal;

    if (file_exists($rutaActual)) {
        if (rename($rutaActual, $rutaNueva)) {
            echo json_encode(['success' => true, 'nuevoNombre' => $nombreFinal]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Error al renombrar la imagen.']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'La imagen no existe.']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Método no permitido.']);
}
?>