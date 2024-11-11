<?php
require_once("qr_code/PromptPayQR.php");
require 'db_connect.php'; // เรียกใช้การเชื่อมต่อฐานข้อมูล
header('Content-Type: application/json'); // Set header as JSON

$PromptPayQR = new PromptPayQR(); // Create a new object

$price = isset($_POST['price']) ? intval($_POST['price']) : null;
$promptPay = isset($_POST['promptPay']) ? $_POST['promptPay'] : null;
$action = isset($_POST['action']) ? $_POST['action'] : null;

if ($action == "PAY" && !empty($promptPay) && !is_null($price)) {
    $PromptPayQR->size = 8; // Set QR code size to 8
    $PromptPayQR->id = $promptPay; // PromptPay ID
    $PromptPayQR->amount = $price; // Set amount

    // Generate QR image as a temporary file
    $tempFilePath = tempnam(sys_get_temp_dir(), 'qrcode') . '.png';
    $PromptPayQR->generate($tempFilePath);

    // Read file content and encode to base64
    $imageData = file_get_contents($tempFilePath);
    $base64 = base64_encode($imageData);

    // Remove temporary file
    unlink($tempFilePath);

    // Send JSON response with base64 image data
    echo json_encode([
        "status" => "success",
        "qr_code" => 'data:image/png;base64,' . $base64
    ]);
} else {
    echo json_encode(["status" => "error", "message" => "Invalid action or missing parameters"]);
}
?>
