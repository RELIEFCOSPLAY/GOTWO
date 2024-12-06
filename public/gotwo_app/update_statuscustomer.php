<?php
header('Content-Type: application/json; charset=utf-8');
try {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "data_test";

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // รับข้อมูล JSON จาก Client
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['regis_customer_id']) && isset($data['status'])) {
        $regis_customer_id = $data['regis_customer_id'];
        $status = $data['status'];

        // อัปเดตสถานะในฐานข้อมูล
        $stmt = $conn->prepare("UPDATE table_customer SET status_customer = :status WHERE regis_customer_id = :regis_customer_id");
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':regis_customer_id', $regis_customer_id);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Status updated successfully."]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to update status."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Invalid input."]);
    }
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Database error: " . $e->getMessage()]);
}
?>