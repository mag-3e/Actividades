<?php
$host    = 'localhost';
$db      = 'clase_backend';
$user    = 'root';
$pass    = '';     // mi contraseña
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, 
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,      
    PDO::ATTR_EMULATE_PREPARES   => false,                 

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
