<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "data_test";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //// Admin
        $adminQuery = $conn->prepare("SELECT name FROM table_admin ");
        $adminQuery->execute();
        $adminData = $adminQuery->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Information Rider</title>

    <script src="/public/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/public/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />

    <link rel="stylesheet" href="/public/css/css_gotwo/nav_animation.css">
    <link rel="stylesheet" href="/public/css/css_gotwo/sidebar.css">
    <link rel="stylesheet" href="/public/css/css_gotwo/info_rider.css">
</head>

<body>

    <div class="wrapper">
        <aside id="sidebar">
            <div class="d-flex">
                <button class="toggle-btn" type="button">
                    <i class="bi bi-grid-fill"></i>
                </button>
                <div class="sidebar-logo">
                    <a href="#" class="fw-bold" style="font-size: 40px;">GOTWO</a>
                </div>
            </div>
            <a href="#" class="sidebar-person">
                <div class="text-white ">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                        class="bi bi-person-circle" viewBox="0 0 16 16">
                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                        <path fill-rule="evenodd"
                            d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                    </svg>
                    <span class="mx-4 fw-bold">
                        <?= isset($adminData['name']) ? htmlspecialchars($adminData['name']) : 'Unknown'; ?>
                    </span>
                </div>
            </a>

            <p class="text-white mt-4 ms-2 fw-bold">MENU</p>
            <hr class="text-white d-none d-sm-block" />

            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="/public/gotwo_app/Dashboard.php" class="sidebar-link">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#Management" aria-expanded="false" aria-controls="Management">
                        <i class="bi bi-kanban"></i>
                        <span>Management</span>
                    </a>
                    <ul id="Management" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="/public/gotwo_app/Rider_Request.php" class="sidebar-link">Rider</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="/public/gotwo_app/Customer_Suspend.php" class="sidebar-link">Customer</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="/public/gotwo_app/pending_tracking.php" class="sidebar-link">
                        <i class="bi bi-pin-map-fill"></i>
                        <span>Travel Tracking</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#Payment" aria-expanded="false" aria-controls="Payment">
                        <i class="bi bi-credit-card-fill"></i>
                        <span>Payment</span>
                    </a>
                    <ul id="Payment" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="/public/gotwo_app/payment_ride.html" class="sidebar-link">Rider</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="/public/gotwo_app/payment_cus.html" class="sidebar-link">Refund</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a href="/public/gotwo_app/profile.php" class="sidebar-link">
                        <i class="bi bi-person-circle"></i>
                        <span>Profile</span>
                    </a>
                </li>
            </ul>
            <div class="sidebar-footer">
                <a href="/public/gotwo_app/logout.php" class="sidebar-link">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Logout</span>
                </a>
            </div>
        </aside>
        <!-- ----------------------------------------------------------------------------------------------------- -->

        <div class="main p-2">
            <div class="container-fluid">
                <!-- title -->
                <h1 style="color: rgb(26, 28, 67);">Information Rider</h1>
                <form>
                    <!-- Account Section -->
                    <div class="form-section">
                        <h5>Account</h5>
                        <div class="border-top border mb-2" style="border-width: 4px; color:rgb(26, 28, 67);"></div>
                        <div class="row align-items-center">
                            <!-- Profile Image -->
                            <div class="col-md-4 text-center">
                                <img id="profileImage" src="" alt="Profile" class="img-thumbnail" style="width: 150px; height: 150px;">
                            </div>
                            <!-- Account Details -->
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="name" readonly value=">
                                </div>
                                <div class=" mb-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" readonly>
                                        </div>
                                        <!-- <div class="col-md-6">
                                            <label for="img_id_card" class="form-label">img_id_card</label>
                                            <input type="img_id_card" class="form-control" id="img_id_card" readonly>
                                        </div> -->
                                        <div class="col-md-6">
                                            <label for="birthdate" class="form-label">Expiration Date</label>
                                            <input type="text" class="form-control" id="birthdate" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="phoneNumber" class="form-label">Phone Number</label>
                                            <input type="tel" class="form-control" id="phoneNumber" readonly>

                                        </div>
                                        <div class="col-md-6">
                                            <label for="gender" class="form-label">Gender</label>
                                            <input type="text" class="form-control" id="gender" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <style>
                        .form-section img {
                            width: 100px;
                            /* ปรับขนาดความกว้าง */
                            height: 100px;
                            /* ปรับขนาดความสูง */
                            object-fit: cover;
                            /* ปรับขนาดภาพให้เหมาะสมในกรอบ */
                            border-radius: 8px;
                            /* เพิ่มขอบมน */
                            margin: 10px;
                            /* เว้นระยะห่าง */
                            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                            /* เพิ่มเงา */
                        }

                        .document-container {
                            display: flex;
                            flex-wrap: wrap;
                            /* ทำให้ภาพเรียงต่อกันเมื่อหน้าจอแคบ */
                            justify-content: center;
                            /* จัดให้อยู่กลาง */
                            gap: 15px;
                            /* เพิ่มช่องว่างระหว่างภาพ */
                        }

                        .document-card {
                            text-align: center;
                            max-width: 150px;
                        }

                        .document-title {
                            font-size: 14px;
                            margin-top: 5px;
                            color: rgb(26, 28, 67);
                            font-weight: 500;
                        }
                    </style>

                    <!-- Document -->
                    <div class="form-section mb-3">
                        <h5>Document</h5>
                        <div class="border-top border mb-2" style="border-width: 4px; color:rgb(26, 28, 67);"></div>
                        <div class="document-container">
                            <div class="document-card">
                                <img id="idcardImage" src="" alt="ID Card" class="img-thumbnail">
                                <div class="document-title">ID Card</div>
                            </div>
                            <div class="document-card">
                                <img id="imgdriverlicense" src="" alt="Driver License" class="img-thumbnail">
                                <div class="document-title">Driver License</div>
                            </div>
                        </div>
                    </div>

                    <!-- Document Car -->
                    <div class="form-section mt-3">
                        <h5>Document Car</h5>
                        <div class="border-top border mb-2" style="border-width: 4px; color:rgb(26, 28, 67);"></div>
                        <div class="document-container">
                            <div class="document-card">
                                <img id="imgact" src="" alt="ACT" class="img-thumbnail">
                                <div class="document-title">ACT</div>
                            </div>
                            <div class="document-card">
                                <img id="imgcarpicture" src="" alt="Car Picture" class="img-thumbnail">
                                <div class="document-title">Car Picture</div>
                            </div>
                            <div class="document-card">
                                <img id="imgcarregistration" src="" alt="Car Registration" class="img-thumbnail">
                                <div class="document-title">Car Registration</div>
                            </div>
                        </div>
                    </div>


            </div>
            <!-- Modal -->
            <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="imageModalLabel">Image Title</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <img id="idcard" src="https://via.placeholder.com/150" alt="Image" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>


        


            </form>
        </div>
        <script src="/public/js/gotwo_js/nav_animation.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


        <?php
        // ฟังก์ชันสำหรับตรวจสอบไฟล์และคืนค่า URL
        function getImageUrl($fileName, $targetDir, $baseUrl, $default = "default_placeholder.png")
        {
            return isset($fileName) && file_exists($targetDir . basename($fileName))
                ? $baseUrl . basename($fileName)
                : $baseUrl . $default;
        }


        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // ดึงค่า regis_rider_id จาก URL
            $riderId = $_GET['regis_rider_id'] ?? null;
            if (!$riderId) {
                throw new Exception("Rider ID is missing.");
            }

            // Query ข้อมูลจาก table_rider
            $sql = "SELECT * FROM `table_rider` WHERE regis_rider_id = :riderId";
            $query = $conn->prepare($sql);
            $query->bindParam(':riderId', $riderId, PDO::PARAM_INT);
            $query->execute();
            $fetch = $query->fetch(PDO::FETCH_ASSOC);

            if (!$fetch) {
                throw new Exception("Rider not found.");
            }

            // Path และ Base URL
            $targetDir = "C:/xampp/htdocs/gotwo/uploads/";
            $baseUrl = "http://localhost/gotwo/uploads/";

            // ดึงข้อมูลรูปภาพ
            $idCardImage = getImageUrl($fetch['img_id_card'], $targetDir, $baseUrl);
            $driverLicenseImage = getImageUrl($fetch['img_driver_license'], $targetDir, $baseUrl);
            $actImage = getImageUrl($fetch['img_act'], $targetDir, $baseUrl);
            $carImage = getImageUrl($fetch['img_car_picture'], $targetDir, $baseUrl);
            $registrationImage = getImageUrl($fetch['img_car_registration'], $targetDir, $baseUrl);

            // แปลงข้อมูลเป็น JSON
            $riderData = json_encode($fetch, JSON_UNESCAPED_UNICODE);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
        ?>





        <script>
           
            function showImage(imageUrl, title) {
                document.getElementById('modalImage').src = imageUrl || '/public/img/default_placeholder.jpg';
                document.getElementById('imageModalLabel').textContent = title || 'Document';
            }



            //===============================================================================================================
            let riderIdGlobal; // ตัวแปรโกลบอลสำหรับเก็บ regis_rider_id

            document.addEventListener('DOMContentLoaded', function() {
                // ตัวอย่างข้อมูล JSON ที่ได้จาก PHP
                const riderData = <?= $riderData ?>;

                // กำหนดค่าไปยัง input ที่มี id ตรงกัน
                document.getElementById('name').value = riderData.name || 'Not Available';
                document.getElementById('email').value = riderData.email || 'Not Available';
                document.getElementById('birthdate').value = riderData.expiration_date || 'Not Available';
                document.getElementById('phoneNumber').value = riderData.tel || 'Not Available';
                document.getElementById('gender').value = riderData.gender || 'Not Available';
                // document.getElementById('img_id_card').value = riderData.img_id_card || 'Not Available';

                profileImage.src = riderData.img_profile || 'https://via.placeholder.com/150';
                idcardImage.src = riderData.img_id_card || 'https://via.placeholder.com/150';
                imgdriverlicense.src = riderData.img_driver_license || 'https://via.placeholder.com/150';
                imgact.src = riderData.img_act || 'https://via.placeholder.com/150';
                imgcarpicture.src = riderData.img_car_picture || 'https://via.placeholder.com/150';
                imgcarregistration.src = riderData.img_car_registration || 'https://via.placeholder.com/150';

                // เก็บ regis_rider_id ไว้ในตัวแปรโกลบอล
                riderIdGlobal = riderData.regis_rider_id || null;
            });

            //===============================================================================================================
          

   
        </script>
</body>

</html>