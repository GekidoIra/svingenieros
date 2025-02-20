<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "db.php";
$conn = connect();

if ($conn->connect_errno) {
    die("Error conectando " . $conn->connect_error);
}

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $partido = $_POST["partido"];
        $tipo = $_POST["tipo"];
        $anillo = $_POST["anillo"];

        // Verificar si el número de anillo ya existe
        $checkAnillo = "SELECT COUNT(*) as count FROM pollos WHERE anillo = '$anillo'";
        $result = $conn->query($checkAnillo);

        if ($result === false) {
            throw new Exception("Error al verificar el número de anillo: " . $conn->error);
        }

        $row = $result->fetch_assoc();
        if ($row['count'] > 0) {
            throw new Exception("El número de anillo ya está registrado.");
        }

        // Guardar la imagen
        $imagenNombre = $_FILES["foto"]["name"];
        $imagenTemp = $_FILES["foto"]["tmp_name"];
        $extension = pathinfo($imagenNombre, PATHINFO_EXTENSION);
        $imagenRuta = $_SERVER['DOCUMENT_ROOT'] . "/imagenes/pollos/" . $anillo . "." . $extension;
		$routetosave = "/imagenes/pollos/" . $anillo . "." . $extension;
        $directorioDestino = $_SERVER['DOCUMENT_ROOT'] . "/imagenes/pollos/";

        if (!is_dir($directorioDestino)) {
            mkdir($directorioDestino, 0755, true);
        }

        move_uploaded_file($imagenTemp, $imagenRuta);

        // Insertar datos en la base de datos
        $sql = "INSERT INTO pollos (partido, tipo, anillo, foto) VALUES ('$partido', '$tipo', '$anillo', '$routetosave')";

        if ($conn->query($sql) === TRUE) {
            echo "Pollo registrado con éxito";
        } else {
            throw new Exception("Error al registrar el pollo: " . $conn->error);
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

$conn->close();
?>
