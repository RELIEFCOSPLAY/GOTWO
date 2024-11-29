<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);

try {
    file_put_contents('debug_log.txt', "POST: " . json_encode($_POST) . PHP_EOL, FILE_APPEND);
    file_put_contents('debug_log.txt', "FILES: " . json_encode($_FILES) . PHP_EOL, FILE_APPEND);

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Invalid request method.");
    }

    if (!isset($_FILES['image']) || !isset($_POST['status_post_id'])) {
        throw new Exception("Invalid input data: Missing file or status_post_id.");
    }

    $image = $_FILES['image'];
    $status_post_id = intval($_POST['status_post_id']);
    $pay = isset($_POST['pay']) ? intval($_POST['pay']) : 4;

    if ($pay !== 4 && $pay !== 5) {
        throw new Exception("Invalid pay value. Only 4 or 5 are allowed.");
    }

    if ($image['error'] !== UPLOAD_ERR_OK) {
        $errorMessages = [
            UPLOAD_ERR_INI_SIZE => "File exceeds the upload_max_filesize directive in php.ini.",
            UPLOAD_ERR_FORM_SIZE => "File exceeds the MAX_FILE_SIZE directive in the HTML form.",
            UPLOAD_ERR_PARTIAL => "The uploaded file was only partially uploaded.",
            UPLOAD_ERR_NO_FILE => "No file was uploaded.",
            UPLOAD_ERR_NO_TMP_DIR => "Missing a temporary folder.",
            UPLOAD_ERR_CANT_WRITE => "Failed to write file to disk.",
            UPLOAD_ERR_EXTENSION => "A PHP extension stopped the file upload."
        ];
        throw new Exception("File upload error: " . ($errorMessages[$image['error']] ?? "Unknown error."));
    }

    $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $fileType = finfo_file($finfo, $image['tmp_name']);
    finfo_close($finfo);

    if (!in_array($fileType, $allowedTypes)) {
        throw new Exception("Invalid file type: $fileType");
    }

    $uploadDir = "gotwo_app/uploads/";
    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0777, true)) {
            throw new Exception("Failed to create upload directory: $uploadDir");
        }
    }

    $timestamp = time();
    $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
    $fileName = $timestamp . "." . $extension;
    $filePath = $uploadDir . $fileName;

    if (!move_uploaded_file($image['tmp_name'], $filePath)) {
        throw new Exception("Failed to save file. Temp: {$image['tmp_name']}, Destination: $filePath");
    }

    $relativePath = $uploadDir . $fileName;

    $pdo = new PDO('mysql:host=localhost;dbname=data_test', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->beginTransaction();

    $sqlUpdate = "
        UPDATE status_post 
        SET image = :image, status = 6, pay = :pay 
        WHERE status_post_id = :status_post_id
    ";
    $stmt = $pdo->prepare($sqlUpdate);
    $stmt->bindParam(':image', $relativePath);
    $stmt->bindParam(':pay', $pay);
    $stmt->bindParam(':status_post_id', $status_post_id);

    if (!$stmt->execute()) {
        throw new Exception("Database update failed: " . json_encode($stmt->errorInfo()));
    }

    $pdo->commit();

    echo json_encode([
        "success" => true,
        "message" => "File uploaded and database updated successfully.",
        "image" => $relativePath,
        "pay" => $pay
    ]);
} catch (Exception $e) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    file_put_contents('debug_log.txt', "Error: " . $e->getMessage() . PHP_EOL, FILE_APPEND);
    http_response_code(500);
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
?>
