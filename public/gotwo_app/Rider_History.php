<?php
$severname = "localhost";
$username = "root";
$password = "";
$dbname = "data_test";

try {
    $conn = new PDO("mysql:host=$severname;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       //// Admin
       $adminQuery = $conn->prepare("SELECT name FROM table_admin ");
       $adminQuery->execute();
       $adminData = $adminQuery->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rider_History</title>
    <script src="/public/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/public/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link rel="stylesheet" href="/public/css/css_gotwo/management_rider.css">
    <link rel="stylesheet" href="/public/css/css_gotwo/sidebar_rider.css">
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

        <div class="main p-3">
            <div class="ms-4 mt-3">
                <h1>Management Rider</h1>
                <div class="nav_animation">
                    <ul>
                        <li class="report_nav_animation"><a href="/public/gotwo_app/Rider_Request.php" id="Request">Rider Request</a></li>
                        <li class="history_nav_animation"><a href="/public/gotwo_app/Rider_History.php"
                                id="Request">History</a></li>
                        <li class="suspend_nav_animation"><a href="/public/gotwo_app/Rider_ Suspend.php"
                                id="Request">Suspend</a></li>
                        <span class="slider_nav_animation"></span>
                    </ul>

                </div>


                <form>
                    <label for="filter">
                        <div class="box">
                            <input type="text" placeholder="Search" id="searchInput">
                            <a href="#">
                                <i class="bi bi-search"></i>
                            </a>
                        </div>
                    </label>
                    <select name="filter" id="filter" class="styled-select" onchange="filterData()">
                        <option value="all">All</option>
                        <option value="confirm">Confirm</option>
                        <option value="reject">Reject</option>
                    </select>
                </form>


                <div class="mt-3">
                    <div class="row">
                        <div class="col-12">
                            <!-- class="table table-striped" -->
                            <table id="table-posts">
                                <thead>
                                    <tr>
                                        <th scope="col">NAME</th>
                                        <th scope="col">MAIL</th>
                                        <th scope="col">MOBILE</th>
                                        <th scope="col">STATUS</th>
                                    </tr>
                                </thead>
                                <tbody id="dataTableBody">


                                </tbody>
                            </table>
                        </div>
                    </div>


                    <!-- ---------------------------------------------------------  --------------------------------------------------------- -->
                </div>
            </div>
        </div>
    </div>
    <script src="/public/js/gotwo_js/management_history.js"></script>
    <script src="/public/js/gotwo_js/searchfuction.js"></script>


    <!-- ------------------------------------------------- -->
    <?php
    // ดึงข้อมูลจากฐานข้อมูล Rider ที่ status_rider = 1(confirm) และ 3 (reject)
    $sql = "SELECT regis_rider_id, name, email, tel, img_profile, status_rider FROM table_rider WHERE status_rider IN (1, 3)";
    $query = $conn->prepare($sql);
    $query->execute();
    $fetch = $query->fetchAll(PDO::FETCH_ASSOC);

    // แปลงข้อมูลเป็น JSON เพื่อส่งไปยัง JavaScript
    $riderDataJSON = json_encode($fetch, JSON_UNESCAPED_UNICODE);
    ?>
    <script>
        // ข้อมูล JSON ที่ดึงมาจาก PHP
        const demo_data = <?= $riderDataJSON ?>;

        // ฟังก์ชันกรองข้อมูล
        function filterData() {
            const filterValue = document.getElementById('filter').value;
            console.log('Selected filter:', filterValue);

            let filteredData = demo_data;

            // กรองข้อมูลตามสถานะ
            if (filterValue === 'confirm') {
                filteredData = demo_data.filter(item => item.status_rider == 1); // Confirm
            } else if (filterValue === 'reject') {
                filteredData = demo_data.filter(item => item.status_rider == 3); // Reject
            }

            console.log('Filtered data:', filteredData);

            // อัปเดตตารางด้วยข้อมูลที่กรองแล้ว
            updateTable(filteredData);
        }


        // ฟังก์ชันอัปเดตตาราง
        function updateTable(data) {
            let show_data = '';

            // วนลูปข้อมูลและสร้าง HTML สำหรับตาราง
            data.forEach((read) => {
                const statusClass = read.status_rider == 1 ? 'text-success' : 'text-danger';
                const statusText = read.status_rider == 1 ? 'Confirm' : 'Reject';

                const riderId = read.regis_rider_id ? read.regis_rider_id : 'unknown';

                show_data += `
     <tr onclick="redirectToPage('/public/gotwo_app/view_info_rider.php?regis_rider_id=${riderId}');">
            <td scope="row">
                <img src="${read.img_profile || '/public/img/unnamed.jpg'}" class="img_style mx-2">
                ${read.name || 'Unknown Name'}
            </td>
            <td>${read.email || 'No Email'}</td>
            <td>${read.tel || 'No Tel'}</td>
            <td class="${statusClass}">${statusText}</td>
        </tr>`;
            });

            // อัปเดต DOM
            const tableBody = document.querySelector('#dataTableBody');
            tableBody.innerHTML = show_data;

            console.log('Table updated:', show_data);
        }

        // ฟังก์ชันเปลี่ยนหน้า
        function redirectToPage(url) {
            if (url && url.includes('regis_rider_id')) {
                console.log("Redirecting to:", url); // Log URL
                window.location.href = url;
            } else {
                console.error("Invalid URL or regis_rider_id not provided.");
                Swal.fire("Error", "Invalid URL or regis_rider_id not provided.", "error");
            }
        }


        // เรียกใช้ฟังก์ชันอัปเดตตารางครั้งแรก (โหลดข้อมูลทั้งหมด)
        updateTable(demo_data);
    </script>


</body>

</html>