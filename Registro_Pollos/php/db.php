<?php
// Conexion a la base de datos para la lista de paises
function connect(){
	//$conn=new mysqli("localhost","prilojuf_tsdb","T0ps3cr3t23","prilojuf_tsdb");
	$conn=new mysqli("127.0.0.1:5522","prilojuf_tsdb","T0ps3cr3t23","prilojuf_tsdb");
	if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    return $conn;
}
?> 