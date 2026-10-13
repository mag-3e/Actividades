<?php
// ✅ CÓDIGO SEGURO: consulta preparada con PDO (el dato viaja separado del SQL)
header('Content-Type: application/json; charset=utf-8');
require_once '../config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(["estado" => "error", "mensaje" => "Método no permitido."], JSON_UNESCAPED_UNICODE);
    exit;
}

$busqueda = trim($_GET['q'] ?? '');

try {
    $sql  = "SELECT id, nombre, categoria, precio, stock
             FROM productos
             WHERE nombre LIKE :nombre OR categoria LIKE :categoria
             ORDER BY nombre";
    $stmt = $pdo->prepare($sql);
    // Los comodines % van en el valor enlazado, nunca dentro del SQL
    $like = '%' . $busqueda . '%';
    $stmt->execute([':nombre' => $like, ':categoria' => $like]);
    $productos = $stmt->fetchAll();

    http_response_code(200);
    echo json_encode([
        "estado" => "exito",
        "total"  => count($productos),
        "data"   => $productos
    ], JSON_UNESCAPED_UNICODE);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["estado" => "error", "mensaje" => "Error al consultar la base de datos."], JSON_UNESCAPED_UNICODE);
}
