<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $targetDir = "uploads/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    // ตรวจสอบว่าไฟล์ถูกส่งมาหรือไม่
    if (!isset($_FILES["image"]) || $_FILES["image"]["error"] !== UPLOAD_ERR_OK) {
        error_log("Upload error: " . ($_FILES["image"]["error"] ?? "No file uploaded"));
        echo json_encode(["error" => "Upload error: " . ($_FILES["image"]["error"] ?? "No file uploaded")]);
        exit;
    }

    // ตรวจสอบชนิดไฟล์
    $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
    $fileType = mime_content_type($_FILES["image"]["tmp_name"]);
    if (!in_array($fileType, $allowedTypes)) {
        error_log("Invalid file type: $fileType");
        echo json_encode(["error" => "Invalid file type. Only JPG, PNG, and WEBP are allowed."]);
        exit;
    }

    // สร้างชื่อไฟล์ใหม่แบบสุ่ม
    $fileName = uniqid("img_", true) . "_" . basename($_FILES["image"]["name"]);
    $targetFilePath = $targetDir . $fileName;

    // ย้ายไฟล์ไปยังโฟลเดอร์เป้าหมาย
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
        $fileUrl = $targetFilePath;
        echo json_encode([
            "message" => "File uploaded successfully.",
            "file" => $fileUrl
        ]);
    } else {
        error_log("Failed to move uploaded file to $targetFilePath");
        echo json_encode(["error" => "File upload failed."]);
    }
} else {
    error_log("Invalid request method: " . $_SERVER['REQUEST_METHOD']);
    echo json_encode(["error" => "Invalid request"]);
}
?>
