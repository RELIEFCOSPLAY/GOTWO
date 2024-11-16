<?php
header('Content-Type: application/json');

// เชื่อมต่อกับฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "data_test";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
    exit;
}

// รับข้อมูล JSON จาก JavaScript
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['base64Image']) && isset($data['riderId'])) {
    $base64_image = $data['base64Image'];
    
    // ตรวจสอบความยาวของ Base64
    if (strlen($base64_image) > 5000) {
        echo json_encode(['success' => false, 'message' => 'Base64 string is too large to save in VARCHAR.']);
        exit;
    }

    $rider_id = $data['riderId'];
    $price = $data['price'];

    // อัปเดต img_slip ในฐานข้อมูล
    $sql = "UPDATE status_post SET img_slip = ? WHERE rider_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $base64_image, $rider_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Image saved successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid input data.']);
}

$conn->close();
?>
