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
    // Query ดึงข้อมูลทั้งหมด
    $sql = "
        SELECT r.name AS rider_name, r.email AS rider_email, r.tel AS rider_tel, 
               r.gender AS rider_gender, r.img_profile AS rider_img_profile,
               c.name AS customer_name, c.email AS customer_email, c.tel AS customer_tel, 
               c.gender AS customer_gender, c.img_profile AS customer_img_profile,
               p.pick_up, p.at_drop,p.date
        FROM status_post s
        JOIN table_rider r ON s.rider_id = r.regis_rider_id
        JOIN table_customer c ON s.customer_id = c.regis_customer_id
        JOIN post p ON s.post_id = p.post_id
        WHERE s.status = 2
        ORDER BY p.date DESC
    ";
    $query = $conn->prepare($sql);
    $query->execute();
    $data = $query->fetchAll(PDO::FETCH_ASSOC); // ดึงข้อมูลทั้งหมด

    // ส่งข้อมูลไปยัง JavaScript
    echo "<script>const demo_data = " . json_encode($data) . ";</script>";
} catch (PDOException $e) {
    echo "<script>console.error('Database error: " . $e->getMessage() . "');</script>";
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Travel Tracking Details_confirm</title>
    <script src="/public/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/public/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link rel="stylesheet" href="/public/css/css_gotwo/tracking_nav_animation .css" />
    <link rel="stylesheet" href="/public/css/css_gotwo/sidebar.css" />
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

            <p class="text-white mt-4 ms-2 fw-bold">MEUN</p>
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

        <!-- bar status -->
        <div class="main p-3">
            <div class="d-flex flex-column justify-content-between col-auto">
                <div class="ms-4 mt-3">
                    <h1>Travel Tracking Details</h1>
                    <div class="nav_animation">
                        <ul>
                            <li class="Pending_nav_animation"><a
                                    href="/public/gotwo_app/pending_tracking.php">Pending</a></li>
                            <li class="Request_nav_animation"><a href="/public/gotwo_app/req_tracking.php">Request</a>
                            </li>
                            <li class="Confirm_nav_animation"><a
                                    href="/public/gotwo_app/confirm_tracking.php">Confirm</a></li>
                            <li class="Totravel_nav_animation"><a href="/public/gotwo_app/totravel_tracking.php">To travel</a></li>
                            <li class="Success_nav_animation"><a
                                    href="/public/gotwo_app/success_tracking.php">Success</a></li>
                            <li class="Cancel_nav_animation"><a href="/public/gotwo_app/cancel_tracking.php">Cancel</a>
                            </li>
                            <span class="slider_nav_animation"></span>
                        </ul>
                    </div>

                    <!-- Search -->
                    <div class="box">
                        <input type="text" id="searchInput" placeholder="Search" />
                        <a href="#">
                            <i class="bi bi-search"></i>
                        </a>
                    </div>
                </div>
                <!-- table data  -->
                <div class="container-fluid mt-5">
                    <table>
                        <thead>
                            <tr>
                                <th>Ridername</th>
                                <th>Customername</th>
                                <th>Pick up</th>
                                <th>Drop</th>
                            </tr>
                        </thead>
                        <tbody id="dataTableBody">
                        </tbody>
                    </table>
                </div>
                <!-- --------------------------------------------------------- modal rider ----------------------------------------------------------->
                <div class="modal fade" id="exampleModal_rider" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Details</h5>
                            </div>
                            <div class="modal-body" id="madal_display">

                            </div>
                            <div class="modal-footer">

                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/public/js/gotwo_js/confirm_report_nav_animation.js"></script>
        <script src="/public/js/gotwo_js/searchfuction.js"></script>


        <!-- ////////////////////////////////////// -->
        <script>
            function displayTableData(data) {
                let tableBody = '';
                data.forEach((item, index) => {
                    tableBody += `
            <tr data-bs-toggle="modal" data-bs-target="#exampleModal_rider" onclick="view_modal(${index})">
                <td><img src="${item.rider_img_profile}" class="rounded-circle" width="50" height="50"> ${item.rider_name}</td>
                <td><img src="${item.customer_img_profile}" class="rounded-circle" width="50" height="50"> ${item.customer_name}</td>
                <td>${item.pick_up}</td>
                <td>${item.at_drop}</td>
            </tr>`;
                });
                document.querySelector('#dataTableBody').innerHTML = tableBody;
            }

            function view_modal(index) {
                const item = demo_data[index]; // ใช้ข้อมูลจากแถวที่เลือก
                const show_modal = `
        <div class="popup center container">
            <div class="popup center container">
            <div class="d-flex flex-row align-items-center">
    <div class="me-3">
        <img src="${item.rider_img_profile}" class="rounded-circle" width="150" height="150">
    </div>
    <div class="mt-3">
        <div class="d-flex flex-row align-items-center">
            <i class="bi bi-person-fill"></i>
            <p class="ms-2 align-content-center fw-bold">Rider</p>
        </div>
        <p>Date: ${item.date}</p>
        <p>Name: ${item.rider_name}</p>
        <p>Email: ${item.rider_email}</p>
        <p>Tel: ${item.rider_tel}</p>
        <p>Gender: ${item.rider_gender}</p>
    </div>
</div>
<hr>
<div class="d-flex flex-row align-items-center">
    <div class="me-3">
        <img src="${item.customer_img_profile}" class="rounded-circle" width="150" height="150">
    </div>
    <div class="mt-3">
        <div class="d-flex flex-row align-items-center">
            <i class="bi bi-person-fill"></i>
            <p class="ms-2 align-content-center fw-bold">Customer</p>
        </div>
        <p>Date: ${item.date}</p>
        <p>Name: ${item.customer_name}</p>
        <p>Email: ${item.customer_email}</p>
        <p>Tel: ${item.customer_tel}</p>
        <p>Gender: ${item.customer_gender}</p>
    </div>
</div>
            <div class="d-flex flex-row justify-content-center">
                <div class="d-flex flex-row">
                    <i class="bi bi-geo-alt-fill"></i>
                    <p class="ms-2 align-content-center">${item.pick_up}</p>
                    <i class="bi bi-arrow-right ms-2 me-2"></i>
                    <i class="bi bi-geo-alt-fill"></i>
                    <p class="ms-2 align-content-center">${item.at_drop}</p>
                </div>
            </div>
        </div>
        `;
                document.querySelector('#madal_display').innerHTML = show_modal;
            }

            document.addEventListener('DOMContentLoaded', () => {
                displayTableData(demo_data); // เรียกฟังก์ชันแสดงตาราง
            });
        </script>


</body>

</html>