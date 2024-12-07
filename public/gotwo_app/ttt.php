<?php
// เส้นทางจริงของโฟลเดอร์
$realFolderPath = rtrim("C:/xampp/htdocs/gotwo/uploads", '/\\');
// เส้นทาง URL ที่แสดงในเว็บ
$folderPath = rtrim("http://localhost:3000/public/gotwo_app/gotwo/uploads", '/\\') . '/';

if (is_dir($realFolderPath)) {
    $files = array_diff(scandir($realFolderPath), ['.', '..']);
    $images = array_filter($files, function ($file) use ($realFolderPath) {
        $filePath = $realFolderPath . '/' . $file;
        return @getimagesize($filePath) !== false; // ตรวจสอบว่าเป็นไฟล์รูปภาพหรือไม่
    });
} else {
    die("โฟลเดอร์ไม่พบ: " . $realFolderPath);
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แสดงรูปภาพ</title>
    <style>
        .gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .gallery img {
            max-width: 200px;
            height: auto;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h1>แสดงรูปภาพจากโฟลเดอร์</h1>
    <div class="gallery">
        <?php if (!empty($images)): ?>
            <?php foreach ($images as $image): ?>
                <img src="<?= $folderPath . htmlspecialchars($image); ?>" alt="รูปภาพ">
            <?php endforeach; ?>
        <?php else: ?>
            <p>ไม่มีรูปภาพในโฟลเดอร์นี้</p>
        <?php endif; ?>
    </div>
</body>
</html>
