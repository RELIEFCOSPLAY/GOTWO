<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);

try {
    // กำหนดโฟลเดอร์เป้าหมาย
    $targetDir = "C:/xampp/htdocs/gotwo/uploads/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true); // สร้างโฟลเดอร์หากไม่มี
    }

    // ตรวจสอบว่าเป็นคำขอ POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Invalid request method.");
    }

    // ตรวจสอบว่าไฟล์ถูกส่งมาหรือไม่
    if (!isset($_FILES["image"]) || $_FILES["image"]["error"] !== UPLOAD_ERR_OK) {
        throw new Exception("Upload error: " . ($_FILES["image"]["error"] ?? "No file uploaded"));
    }

    // ตรวจสอบชนิดไฟล์ที่อนุญาต
    $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
    $fileType = mime_content_type($_FILES["image"]["tmp_name"]);
    if (!in_array($fileType, $allowedTypes)) {
        throw new Exception("Invalid file type. Only JPG, PNG, and WEBP are allowed.");
    }

    // ตรวจสอบขนาดไฟล์ (ไม่เกิน 2MB)
    $maxFileSize = 2 * 1024 * 1024; // 2MB
    if ($_FILES["image"]["size"] > $maxFileSize) {
        throw new Exception("File size exceeds the maximum limit of 2MB.");
    }

    // สร้างชื่อไฟล์ใหม่แบบสุ่ม
    $fileName = uniqid("img_", true) . "_" . basename($_FILES["image"]["name"]);
    $targetFilePath = $targetDir . $fileName;

    // ย้ายไฟล์ไปยังโฟลเดอร์เป้าหมาย
    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
        throw new Exception("Failed to move uploaded file.");
    }

   

    // ส่งผลลัพธ์กลับในรูปแบบ JSON
    echo json_encode([
        "success" => true,
        "message" => "File uploaded successfully.",
        "file" => $targetFilePath
    ]);
} catch (Exception $e) {
    // ส่งข้อความข้อผิดพลาดกลับในรูปแบบ JSON
    http_response_code(400);
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
?>
