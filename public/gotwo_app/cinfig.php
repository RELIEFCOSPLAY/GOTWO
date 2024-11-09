<!-- <?php

$severname = "localhost";
$username = "root";
$password = "";
$dbname = "gotwo";

try {
    $conn = new PDO("mysql:host=$severname;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?> -->