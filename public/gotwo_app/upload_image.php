<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);

try {
    // Debugging logs
    file_put_contents('debug_log.txt', "POST: " . json_encode($_POST) . PHP_EOL, FILE_APPEND);
    file_put_contents('debug_log.txt', "FILES: " . json_encode($_FILES) . PHP_EOL, FILE_APPEND);

    // Validate HTTP request method
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Invalid request method.");
    }

    // Validate input data
    if (!isset($_FILES['img_qr_admin']) || !isset($_POST['status_post_id'])) {
        throw new Exception("Invalid input data: Missing file or status_post_id.");
    }

    $img_qr_admin = $_FILES['img_qr_admin'];
    $status_post_id = intval($_POST['status_post_id']);
    $pay = isset($_POST['pay']) ? intval($_POST['pay']) : 5; 
    if ($pay !== 5 && $pay !== 6) {
        throw new Exception("Invalid pay value. Only 5 or 6 are allowed.");
    }

    // Handle file upload errors
    if ($img_qr_admin['error'] !== UPLOAD_ERR_OK) {
        $errorMessages = [
            UPLOAD_ERR_INI_SIZE => "File exceeds the upload_max_filesize directive in php.ini.",
            UPLOAD_ERR_FORM_SIZE => "File exceeds the MAX_FILE_SIZE directive in the HTML form.",
            UPLOAD_ERR_PARTIAL => "The uploaded file was only partially uploaded.",
            UPLOAD_ERR_NO_FILE => "No file was uploaded.",
            UPLOAD_ERR_NO_TMP_DIR => "Missing a temporary folder.",
            UPLOAD_ERR_CANT_WRITE => "Failed to write file to disk.",
            UPLOAD_ERR_EXTENSION => "A PHP extension stopped the file upload."
        ];
        throw new Exception("File upload error: " . ($errorMessages[$img_qr_admin['error']] ?? "Unknown error."));
    }

    // Validate file type
    $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $fileType = finfo_file($finfo, $img_qr_admin['tmp_name']);
    finfo_close($finfo);

    if (!in_array($fileType, $allowedTypes)) {
        throw new Exception("Invalid file type: $fileType");
    }

    // Define upload directories
    $primaryDir = "C:/xampp/htdocs/gotwo/uploads/";
    $additionalDir = "C:/Users/Waraphorn_2546/Documents/GitHub/GOTWO/public/gotwo_app/gotwo/uploads";

    foreach ([$primaryDir, $additionalDir] as $dir) {
        if (!is_dir($dir)) {
            if (!mkdir($dir, 0777, true)) {
                throw new Exception("Failed to create upload directory: $dir");
            }
        }
    }

    // Generate consistent file name
    $timestamp = time();
    $extension = pathinfo($img_qr_admin['name'], PATHINFO_EXTENSION);
    $fileName = "qr_admin_" . $timestamp . "." . $extension;

    // Define file paths
    $filePathPrimary = $primaryDir . $fileName;
    $filePathAdditional = $additionalDir . "/" . $fileName;

    // Move file to primary directory
    if (!move_uploaded_file($img_qr_admin['tmp_name'], $filePathPrimary)) {
        throw new Exception("Failed to save file to primary directory.");
    }

    // Copy file to additional directory
    if (!copy($filePathPrimary, $filePathAdditional)) {
        throw new Exception("Failed to copy file to additional directory.");
    }

    // Database operations
    $pdo = new PDO('mysql:host=localhost;dbname=data_test', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->beginTransaction();

    $sqlUpdate = "
        UPDATE status_post 
        SET img_qr_admin = :img_qr_admin, pay = :pay 
        WHERE status_post_id = :status_post_id
    ";

    $relativePath = "gotwo/uploads/" . $fileName;
    $stmt = $pdo->prepare($sqlUpdate);
    $stmt->bindParam(':img_qr_admin', $relativePath); // Save relative path in database
    $stmt->bindParam(':pay', $pay);
    $stmt->bindParam(':status_post_id', $status_post_id);

    if (!$stmt->execute()) {
        throw new Exception("Database update failed: " . json_encode($stmt->errorInfo()));
    }

    $pdo->commit();

    // Return success response
    echo json_encode([
        "success" => true,
        "message" => "File uploaded and database updated successfully.",
        "file_primary" => $filePathPrimary,
        "file_additional" => $filePathAdditional
    ]);
} catch (Exception $e) {
    // Rollback if an error occurs
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    // Log errors
    file_put_contents('debug_log.txt', "Error: " . $e->getMessage() . PHP_EOL, FILE_APPEND);

    // Return error response
    http_response_code(500);
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
