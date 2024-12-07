<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "data_test";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}

// ฟังก์ชันสำหรับตรวจสอบไฟล์และคืนค่า URL
function getImageUrl($fileName, $targetDir, $baseUrl, $default = "/public/img/unnamed.jpg") {
    return isset($fileName) && file_exists($targetDir . $fileName)
        ? $baseUrl . $fileName
        : $default;
}

try {
    $riderId = $_GET['regis_rider_id'] ?? null;

    if (!$riderId) {
        throw new Exception("Rider ID is missing.");
    }

    $sql = "SELECT regis_rider_id, name, email, tel, gender, img_profile, img_id_card, img_driver_license, 
            img_car_picture, img_car_registration, img_act, expiration_date 
            FROM table_rider WHERE regis_rider_id = :riderId";

    $query = $conn->prepare($sql);
    $query->bindParam(':riderId', $riderId, PDO::PARAM_INT);
    $query->execute();
    $fetch = $query->fetch(PDO::FETCH_ASSOC);

    if (!$fetch) {
        throw new Exception("Rider not found.");
    }

    $targetDir = "C:/xampp/htdocs/gotwo/uploads/";
    $baseUrl = "http://localhost/gotwo/uploads/";

    // รูปภาพโปรไฟล์
    $profileImage = getImageUrl($fetch['img_profile'], $targetDir, $baseUrl);
    $idCardImage = getImageUrl($fetch['img_id_card'], $targetDir, $baseUrl);
    $driverLicenseImage = getImageUrl($fetch['img_driver_license'], $targetDir, $baseUrl);
    $carImage = getImageUrl($fetch['img_car_picture'], $targetDir, $baseUrl);
    $registrationImage = getImageUrl($fetch['img_car_registration'], $targetDir, $baseUrl);
    $actImage = getImageUrl($fetch['img_act'], $targetDir, $baseUrl);

    $riderData = json_encode($fetch, JSON_UNESCAPED_UNICODE);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Information Rider</title>
    <link rel="stylesheet" href="/public/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>

    <div class="container">
        <h1 class="text-center my-4">Rider Information</h1>
        <div class="row">
            <div class="col-md-4 text-center">
                <img src="<?= htmlspecialchars($profileImage, ENT_QUOTES, 'UTF-8') ?>" alt="Profile Image" class="img-fluid rounded-circle">
                <p><?= htmlspecialchars($fetch['name'] ?? 'Unknown', ENT_QUOTES, 'UTF-8') ?></p>
            </div>
            <div class="col-md-8">
                <h3>Details</h3>
                <p>Email: <?= htmlspecialchars($fetch['email'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></p>
                <p>Phone: <?= htmlspecialchars($fetch['tel'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></p>
                <p>Gender: <?= htmlspecialchars($fetch['gender'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></p>
                <p>Expiration Date: <?= htmlspecialchars($fetch['expiration_date'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></p>
            </div>
        </div>
        <div class="row mt-4">
            <h3 class="text-center">Documents</h3>
            <div class="col-md-4">
                <h5>ID Card</h5>
                <img src="<?= htmlspecialchars($idCardImage, ENT_QUOTES, 'UTF-8') ?>" alt="ID Card" class="img-fluid">
            </div>
            <div class="col-md-4">
                <h5>Driver License</h5>
                <img src="<?= htmlspecialchars($driverLicenseImage, ENT_QUOTES, 'UTF-8') ?>" alt="Driver License" class="img-fluid">
            </div>
            <div class="col-md-4">
                <h5>Car Picture</h5>
                <img src="<?= htmlspecialchars($carImage, ENT_QUOTES, 'UTF-8') ?>" alt="Car Picture" class="img-fluid">
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-4">
                <h5>Car Registration</h5>
                <img src="<?= htmlspecialchars($registrationImage, ENT_QUOTES, 'UTF-8') ?>" alt="Car Registration" class="img-fluid">
            </div>
            <div class="col-md-4">
                <h5>ACT Document</h5>
                <img src="<?= htmlspecialchars($actImage, ENT_QUOTES, 'UTF-8') ?>" alt="ACT Document" class="img-fluid">
            </div>
        </div>
    </div>

    <script src="/public/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Information Rider</title>
    <link rel="stylesheet" href="/public/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1 class="text-center my-4">Rider Information</h1>
        <div class="row">
            <div class="col-md-4 text-center">
                <img src="<?= htmlspecialchars($profileImage, ENT_QUOTES, 'UTF-8') ?>" alt="Profile Image" class="img-fluid rounded-circle">
                <p><?= htmlspecialchars($fetch['name'] ?? 'Unknown', ENT_QUOTES, 'UTF-8') ?></p>
            </div>
            <div class="col-md-8">
                <h3>Details</h3>
                <p>Email: <?= htmlspecialchars($fetch['email'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></p>
                <p>Phone: <?= htmlspecialchars($fetch['tel'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></p>
                <p>Gender: <?= htmlspecialchars($fetch['gender'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></p>
                <p>Expiration Date: <?= htmlspecialchars($fetch['expiration_date'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></p>
            </div>
        </div>
        <div class="row mt-4">
            <h3 class="text-center">Documents</h3>
            <div class="col-md-4">
                <h5>ID Card</h5>
                <img src="<?= htmlspecialchars($idCardImage, ENT_QUOTES, 'UTF-8') ?>" alt="ID Card" class="img-fluid">
            </div>
            <div class="col-md-4">
                <h5>Driver License</h5>
                <img src="<?= htmlspecialchars($driverLicenseImage, ENT_QUOTES, 'UTF-8') ?>" alt="Driver License" class="img-fluid">
            </div>
            <div class="col-md-4">
                <h5>Car Picture</h5>
                <img src="<?= htmlspecialchars($carImage, ENT_QUOTES, 'UTF-8') ?>" alt="Car Picture" class="img-fluid">
            </div>
        </div>
    </div>
</body>

</html>
