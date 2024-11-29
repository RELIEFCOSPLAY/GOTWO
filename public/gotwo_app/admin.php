<?php
header('Content-Type: application/json'); // กำหนดให้ส่ง JSON

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "data_test";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = $conn->prepare("SELECT name FROM table_admin LIMIT 1");
    $query->execute();
    $adminData = $query->fetch(PDO::FETCH_ASSOC);

    echo json_encode([
        "admin" => $adminData['name'] ?? "Unknown"
    ]);
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
