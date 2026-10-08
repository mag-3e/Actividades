<?php
header("Content-Type: application/json; charset=utf-8");
require "conexion.php";

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $stmt = $pdo->prepare("SELECT * FROM productos");
    $stmt->execute();
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $d = json_decode(file_get_contents("php://input"), true);

    if (empty($d["nombre"]) || empty($d["categoria"]) || !isset($d["precio"])) {
        http_response_code(400);
        echo json_encode(["error" => "Faltan datos"]);
        exit;
    }

    $stmt = $pdo->prepare(
        "INSERT INTO productos (nombre, categoria, precio, stock)
         VALUES (:nombre, :categoria, :precio, :stock)"
    );
    $stmt->execute([
        ":nombre"    => $d["nombre"],
        ":categoria" => $d["categoria"],
        ":precio"    => $d["precio"],
        ":stock"     => $d["stock"] ?? 0,
    ]);
    echo json_encode(["ok" => true, "id" => $pdo->lastInsertId()]);
}