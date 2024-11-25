<?php
header('Content-Type: application/json');

// ตั้งค่าการเชื่อมต่อฐานข้อมูล
$host = "localhost";
$username = "root";
$password = "";
$database = "gotwo";

try {
    $conn = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // รับข้อมูล JSON
    $data = json_decode(file_get_contents("php://input"), true);
    $riderId = $data['regis_rider_id'] ?? null;
    $status = $data['status'] ?? null;

    if ($riderId && ($status === 'confirm' || $status === 'reject')) {
        // อัปเดต status เป็น 3 สำหรับ confirm และ 4 สำหรับ reject
        $newStatus = ($status === 'confirm') ? 3 : 4;

        // อัปเดตฐานข้อมูล
        $stmt = $conn->prepare("UPDATE riders SET status = :status WHERE id = :rider_id");
        $stmt->bindParam(':status', $newStatus, PDO::PARAM_INT);
        $stmt->bindParam(':rider_id', $riderId, PDO::PARAM_INT);
        $stmt->execute();

        echo json_encode(['success' => true, 'message' => 'Rider status updated to ' . $newStatus . ' successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid data.']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
