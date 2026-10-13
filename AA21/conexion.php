<?php
// Configuración de la conexión a MySQL con PDO
$host    = 'localhost';
$db      = 'clase_backend';
$user    = 'root';
$pass    = '18.05.46.711.314.05';     
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Lanza PDOException ante errores
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Devuelve arreglos asociativos
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Prepared statements reales
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    header('Content-Type: application/json; charset=utf-8');
    http_response_code(500);
    echo json_encode([
        "estado"  => "error",
        "mensaje" => "Error de conexión con la base de datos: " . $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
    exit;
}
