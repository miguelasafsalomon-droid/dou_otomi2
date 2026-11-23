
<?php

header("Content-Type: application/json");

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {

    include("conexion.php");

    $data = json_decode(file_get_contents("php://input"), true);

    if (!$data) {
        throw new Exception("No se recibieron los datos.");
    }

    $nombre = $data['nombre'];
    $email = $data['email'];
    $contraseña = $data['contraseña'];
    $fecha_nac = $data['fecha_nac'];
    $pais = $data['pais'];
    $nivel = (int)$data['nivel'];

    $fecha_registro = date("Y-m-d");

    $sql = "INSERT INTO usuario
    (nombre, email, `contraseña`, fecha_registro, fecha_nac, pais, nivel)
    VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "ssssssi",
        $nombre,
        $email,
        $contraseña,
        $fecha_registro,
        $fecha_nac,
        $pais,
        $nivel
    );

    $stmt->execute();

    echo json_encode([
        "estado" => true,
        "mensaje" => "Usuario registrado correctamente"
    ]);

    $stmt->close();
    $conn->close();

} catch (Throwable $e) {

    echo json_encode([
        "estado" => false,
        "mensaje" => "Error: " . $e->getMessage()
    ]);

}

?>
