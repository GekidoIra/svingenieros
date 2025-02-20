<?php
$granja = $_GET['granja'] ?? '';
$directorio = "2025/$granja/";

if (is_dir($directorio)) {
    $fotos = array_filter(scandir($directorio), function($item) use ($directorio) {
        return !is_dir($directorio . $item);
    });
    echo json_encode(array_values($fotos));
} else {
    echo json_encode([]);
}
?>