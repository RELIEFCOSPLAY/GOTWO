<?php
header('Content-Type: application/json');

// เปิดการแสดงผลข้อผิดพลาด
error_reporting(E_ALL);
ini_set('display_errors', 1);

// รับข้อมูล JSON
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// ตรวจสอบ Input
if (!isset($data['regis_rider_id']) || !isset($data['status'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid input data']);
    exit;
}

$regis_rider_id = $data['regis_rider_id'];
$status_rider = $data['status'];
$reason = isset($data['reason']) ? $data['reason'] : null;

try {
    // เชื่อมต่อฐานข้อมูล
    $conn = new PDO("mysql:host=localhost;dbname=data_test", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // อัปเดตฐานข้อมูล
    $sql = "UPDATE table_rider SET status_rider = :status_rider, reason = :reason WHERE regis_rider_id = :regis_rider_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':status_rider', $status_rider, PDO::PARAM_INT);
    $stmt->bindParam(':reason', $reason, PDO::PARAM_STR);
    $stmt->bindParam(':regis_rider_id', $regis_rider_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Status and reason updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update data']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>