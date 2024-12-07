<?php
$file = 'C:/xampp/htdocs/gotwo/uploads/qr_admin_1733456477.png';
if (file_exists($file)) {
    header('Content-Type: image/png');
    readfile($file);
} else {
    echo "File not found.";
}
?>
