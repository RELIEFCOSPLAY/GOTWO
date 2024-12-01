<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "data_test";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['regis_rider_id'])) {
        $riderId = $_GET['regis_rider_id'];

        $sql = "SELECT img_id_card FROM table_rider WHERE regis_rider_id = :riderId";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':riderId', $riderId, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            echo json_encode(['success' => true, 'img_id_card' => $result['img_id_card']]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Image not found']);
        }
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
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
                    <span class="mx-4 fw-bold"> Natthawut Sinnamkham</span>
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
                            <a href="/public/gotwo_app/payment_ride.php" class="sidebar-link">Rider</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="/public/gotwo_app/payment_cus.php" class="sidebar-link">Refund</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i class="bi bi-person-circle"></i>
                        <span>Profile</span>
                    </a>
                </li>

            </ul>
            <div class="sidebar-footer">
                <a href="/public/gotwo_app/login_gotwo.html" class="sidebar-link">
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
                                <img src="<?= htmlspecialchars($riderData['img_profile'] ?? '/public/img/unnamed.jpg') ?>"
                                    alt="Profile" class="img-thumbnail" style="width: 150px; height: 150px;">
                            </div>
                            <!-- Account Details -->
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="name" readonly>
                                </div>
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="expiration_date" class="form-label">Expiration Date</label>
                                            <input type="text" class="form-control" id="expiration_date" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="tel" class="form-label">Phone Number</label>
                                            <input type="tel" class="form-control" id="tel" readonly>

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


                    <!-- Document -->
                    <div class="form-section mb-3">
                        <h5>Document</h5>
                        <div class="border-top border mb-2" style="border-width: 4px; color:rgb(26, 28, 67);"></div>
                        <div class="col">
                            <div class="row">
                                <!-- ID Card Button -->

                                <div class="column">


                                    <button type="button" class="btn btn-primary w-75" data-bs-toggle="modal" data-bs-target="#idCardModal" onclick="showIdCardImage(1)">
                                        ID Card
                                    </button>
                                </div>
                                <!-- Driver's License Button -->
                                <div class="column">
                                    <button type="button" class="btn btn-primary w-75" data-bs-toggle="modal" data-bs-target="#licenseModal">
                                        Driver's License
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Document Car -->
                    <div class="form-section mt-3">
                        <h5>Document Car</h5>
                        <div class="border-top border mb-2" style="border-width: 4px; color:rgb(26, 28, 67);"></div>
                        <div class="col">
                            <div class="row">
                                <div class="column">
                                    <div class="card w-75 h-50">
                                        <div class="card-body">
                                            <h5 class="card-title">Act</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="column">
                                    <div class="card w-75 h-50">
                                        <div class="card-body">
                                            <h5 class="card-title">Car Picture</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="column">
                                    <div class="card w-75 h-50">
                                        <div class="card-body">
                                            <h5 class="card-title">Car registration</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

            </div>
            <!-- popup -->
            <div class="modal fade" id="idCardModal" tabindex="-1" aria-labelledby="idCardModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="idCardModalLabel">ID Card</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <img id="idCardImage" src="" alt="No Image Available" class="img-fluid" style="max-width: 100%; height: auto;">
                            <p id="errorTextIDCard" style="display: none; color: red;">No Image Available</p>
                        </div>
                    </div>
                </div>
            </div>



            <!-- Buttons -->
            <div class="d-flex justify-content-end gap-2 mt-1">
                <button type="button" class="btn btn-danger" id="rejectButton" data-rider-id="<?= htmlspecialchars($riderId) ?>">Reject</button>
                <button type="button" class="btn btn-success" id="confirmButton" data-rider-id="<?= htmlspecialchars($riderId) ?>">Confirm</button>
            </div>

            </form>
        </div>
        <script src="/public/js/gotwo_js/nav_animation.js"></script>
        <?php
        $riderId = filter_input(INPUT_GET, 'regis_rider_id', FILTER_VALIDATE_INT);
        if ($riderId === false || $riderId === null) {
            die("");
        }


        // ตรวจสอบว่ามีการเชื่อมต่อฐานข้อมูลสำเร็จ
        if (!$conn) {
            die("Database connection failed");
        }
        $sql = "SELECT 
        `regis_rider_id`, `img_profile`, `name`, `email`, `tel`, `gender`, 
        `img_id_card`, `img_driver_license`, `img_car_picture`, `img_car_registration`, 
        `img_act`, `expiration_date`, `car_rigistration`, `car_brand`, `status_rider` 
    FROM `table_rider` 
    WHERE `regis_rider_id` = :riderId";


        $query = $conn->prepare($sql);
        $query->bindParam(':riderId', $riderId, PDO::PARAM_INT);
        $query->execute();

        $fetch = $query->fetch(PDO::FETCH_ASSOC);
        $riderData = json_encode($fetch, JSON_UNESCAPED_UNICODE);


        ?>
        <script>
            // =======================update status==================================
            async function updateStatus(riderId, status) {
                try {
                    const response = await fetch('status_req.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            regis_rider_id: riderId,
                            status: status
                        }),
                    });

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    const data = await response.json();
                    if (data.success) {
                        alert(data.message);
                        document.getElementById('confirmButton').disabled = true;
                        document.getElementById('rejectButton').disabled = true;
                    } else {
                        alert(data.message || 'Failed to update status.');
                    }
                } catch (error) {
                    console.error('Error updating status:', error);
                    alert('An error occurred while updating the status.');
                }
            }


            document.getElementById('confirmButton').addEventListener('click', () => {
                const riderId = document.getElementById('confirmButton').getAttribute('data-rider-id');
                if (confirm("Are you sure you want to confirm this rider?")) {
                    updateStatus(riderId, 'Confirmed');
                }
            });


            document.getElementById('rejectButton').addEventListener('click', () => {
                const riderId = document.getElementById('rejectButton').getAttribute('data-rider-id');
                if (confirm("Are you sure you want to reject this rider?")) {
                    updateStatus(riderId, 'Rejected');
                }
            });

            document.addEventListener('DOMContentLoaded', function() {
                try {
                    const riderData = JSON.parse('<?= $riderData ?>') || {};

                    // ฟังก์ชันสำหรับจัดฟอร์แมตวันที่
                    const formatDate = (dateString) => {
                        if (!dateString) return 'Not Available'; // ถ้าวันที่ว่าง
                        const date = new Date(dateString);
                        return date.toLocaleDateString('en-GB', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric'
                        });
                    };


                    // Map fields to inputs
                    document.getElementById('name').value = riderData.name || 'Not Available';
                    document.getElementById('email').value = riderData.email || 'Not Available';
                    document.getElementById('expiration_date').value = formatDate(riderData.expiration_date); // ใช้ฟังก์ชัน formatDate
                    document.getElementById('tel').value = riderData.tel || 'Not Available';
                    document.getElementById('gender').value = riderData.gender || 'Not Available';
                } catch (error) {
                    console.error("Error parsing rider data:", error);
                }

            });

       function showIdCardImage(riderId) {
    fetch(`info_rider.php?regis_rider_id=${riderId}`)
        .then(response => response.json())
        .then(data => {
            const imageElement = document.getElementById('idCardImage');
            const errorText = document.getElementById('errorTextIDCard');

            if (data.success && data.img_id_card) {
                const imageUrl = data.img_id_card.startsWith('/')
                    ? data.img_id_card
                    : `/${data.img_id_card}`; // เพิ่ม '/' หากไม่มี
                imageElement.src = imageUrl;
                imageElement.style.display = "block";
                errorText.style.display = "none";
            } else {
                imageElement.style.display = "none";
                errorText.style.display = "block";
            }

            const modal = new bootstrap.Modal(document.getElementById('idCardModal'));
            modal.show();
        })
        .catch(error => {
            console.error('Error fetching image:', error);
        });
}

        </script>
</body>

</html>