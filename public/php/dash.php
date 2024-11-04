<?php

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
?>
<!-- ------------------------------------------------- -->
<?php
$sql = "SELECT COUNT(*) as status_rider FROM table_rider WHERE status_rider = 0";
$query = $conn->prepare($sql);
$query->execute();
$fetch = $query->fetch();
$status_rider = $fetch['status_rider'] ?? 0;
?>
<!-- ------------------------------------------------- -->