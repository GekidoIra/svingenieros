<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

include "db.php";
$conn = connect();

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $anillo = $_POST["anillo"]="639";

    try {
        // Verificar si el número de anillo es válido (puedes agregar más validaciones si es necesario)
        if (!preg_match("/^[0-9]+$/", $anillo)) {
            throw new Exception("El número de anillo no es válido.");
        }

        // Buscar datos en la base de datos
        $sql = "SELECT * FROM pollos WHERE anillo = '$anillo'";
        $result = $conn->query($sql);

        if ($result === false) {
            throw new Exception("Error al ejecutar la consulta: " . $conn->error);
        }

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $partido = $row["partido"];
            $tipo = $row["tipo"];
            $imagenRuta = $row["foto"];

            // Construir la respuesta con estilo
            $response["html"] = "<div class='pollo-info'>
                    <div class='info'>
                        <label class='partido'>Partido: <p class='datos'>$partido</p></label>
                        <label class='tipo'>Tipo: <p class='datos'>$tipo</p></label>
                        <label class='anillo'>Anillo: <p class='datos'>$anillo</p></label>
                    </div>
                    <div class='imagen'>
                        <img class='imagen' id='imagen' src='$imagenRuta' alt='Pollo Registrado'>
                    </div>
                </div>";
        } else {
            $response["error"] = "No se encontraron datos para el pollo con número de anillo $anillo";
        }
    } catch (Exception $e) {
        $response["error"] = "Error: " . $e->getMessage();
    }
}

$conn->close();

// Devolver la respuesta como JSON
echo json_encode($response);
?>

<?php
echo "<mm:dwdrfml documentRoot=" . __FILE__ .">";$included_files = get_included_files();foreach ($included_files as $filename) { echo "<mm:IncludeFile path=" . $filename . " />"; } echo "</mm:dwdrfml>";
?>