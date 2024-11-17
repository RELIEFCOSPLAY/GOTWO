<?php
header('Content-Type: application/json');

try {
    // ตรวจสอบว่าไฟล์และ `status_post_id` ถูกส่งมา
    if (!isset($_FILES['image']) || !isset($_POST['status_post_id'])) {
        echo json_encode([
            "success" => false,
            "message" => "Invalid input data."
        ]);
        exit;
    }

    $image = $_FILES['image'];
    $status_post_id = intval($_POST['status_post_id']);

    // ตรวจสอบข้อผิดพลาดของไฟล์
    if ($image['error'] !== UPLOAD_ERR_OK) {
        echo json_encode([
            "success" => false,
            "message" => "File upload error: " . $image['error']
        ]);
        exit;
    }

    // ตรวจสอบประเภทไฟล์ที่อนุญาต
    $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
    $fileType = mime_content_type($image['tmp_name']);
    if (!in_array($fileType, $allowedTypes)) {
        echo json_encode([
            "success" => false,
            "message" => "Invalid file type: " . $fileType
        ]);
        exit;
    }

    // ตรวจสอบและสร้างโฟลเดอร์ถ้าไม่มี
    $uploadDir = "uploads/";
    if (!is_dir($uploadDir) && !mkdir($uploadDir, 0777, true)) {
        echo json_encode([
            "success" => false,
            "message" => "Failed to create upload directory."
        ]);
        exit;
    }

    // สร้างชื่อไฟล์แบบสุ่ม
    $fileName = uniqid() . "." . pathinfo($image['name'], PATHINFO_EXTENSION);
    $filePath = $uploadDir . $fileName;

    // ย้ายไฟล์ไปยังโฟลเดอร์
    if (!move_uploaded_file($image['tmp_name'], $filePath)) {
        echo json_encode([
            "success" => false,
            "message" => "Failed to save the file."
        ]);
        exit;
    }

    // เชื่อมต่อฐานข้อมูล
    $pdo = new PDO('mysql:host=localhost;dbname=data_test', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // เริ่มต้น Transaction
    $pdo->beginTransaction();

    // อัปเดตรูปภาพและสถานะในฐานข้อมูล
    $sqlUpdate = "
        UPDATE status_post 
        SET image = :image, status = 6, pay = 4 
        WHERE status_post_id = :status_post_id
    ";
    $stmt = $pdo->prepare($sqlUpdate);
    $stmt->bindParam(':image', $filePath);
    $stmt->bindParam(':status_post_id', $status_post_id);

    if (!$stmt->execute()) {
        throw new Exception("Failed to update database.");
    }

    // Commit Transaction
    $pdo->commit();

    // ส่งผลลัพธ์กลับไป
    echo json_encode([
        "success" => true,
        "message" => "File uploaded and database updated successfully.",
        "image" => $filePath
    ]);
} catch (Exception $e) {
    // Rollback หากมีข้อผิดพลาด
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
?>
