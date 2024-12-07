<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "data_test";

try {
    // เชื่อมต่อฐานข้อมูล
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // ดึงข้อมูล Admin
    $adminQuery = $conn->prepare("SELECT name FROM table_admin LIMIT 1");
    $adminQuery->execute();
    $adminData = $adminQuery->fetch(PDO::FETCH_ASSOC);
    $adminData = $adminData ?: ['name' => 'Unknown']; // ถ้าไม่มี Admin ให้ตั้งค่า Unknown

    // ดึงข้อมูล Status Post
    $sql = "
        SELECT 
            s.status_post_id AS id, 
            r.name AS rider_name, 
            r.email AS rider_email, 
            r.tel AS rider_tel, 
            r.gender AS rider_gender, 
            r.img_profile AS rider_img_profile,
            c.name AS customer_name, 
            c.email AS customer_email, 
            c.tel AS customer_tel, 
            c.gender AS customer_gender, 
            c.img_profile AS customer_img_profile,
            p.pick_up, 
            p.at_drop, 
            p.date, 
            s.pay, 
            s.image
        FROM status_post s
        JOIN table_rider r ON s.rider_id = r.regis_rider_id
        JOIN table_customer c ON s.customer_id = c.regis_customer_id
        JOIN post p ON s.post_id = p.post_id
        WHERE s.status = 2
        ORDER BY p.date DESC
    ";

    $query = $conn->prepare($sql);
    $query->execute();
    $data = $query->fetchAll(PDO::FETCH_ASSOC);

    // เพิ่ม Path สำหรับไฟล์ภาพ
    foreach ($data as &$item) {
        if (!empty($item['image'])) {
            $item['image'] = "uploads/" . $item['image']; // เพิ่ม Path uploads/
        }
    }

    // ส่งข้อมูลไปยัง JavaScript
    echo "<script>const demo_data = " . json_encode($data) . ";</script>";
} catch (PDOException $e) {
    echo "<script>console.error('Database error: " . addslashes($e->getMessage()) . "');</script>";
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
                            <!-- <li class="Request_nav_animation"><a href="/public/gotwo_app/req_tracking.php">Request</a>
                            </li> -->
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
                                <th>Slip</th>
                                <th>Status Payment </th>
                            </tr>
                        </thead>
                        <tbody id="dataTableBody">
                        </tbody>
                    </table>
                </div>
                <!-- --------------------------------------------------------- modal rider ----------------------------------------------------------->
                <div class="modal fade" id="exampleModal_rider" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Details</h5>
                            </div>
                            <div class="modal-body" id="madal_display">
                                <!-- Content will be dynamically added here -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment_cus -->
        <div class="modal fade" id="slipModal" tabindex="-1" aria-labelledby="slipModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="slipModalLabel">Slip Customer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="display: none;"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img id="slipImage" src="" alt="Slip" class="img-fluid" style="display: none;">
                        <p id="errorText" class="text-danger" style="display: none;">Slip not available.</p>
                    </div>
                    <div class="modal-footer">
                        <button id="successButton" type="button" class="btn btn-success" onclick="updatePay()">Verified</button>
                        <button id="closeButton" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>


        <script src="/public/js/gotwo_js/confirm_report_nav_animation.js"></script>
        <script src="/public/js/gotwo_js/searchfuction.js"></script>


        <!-- ////////////////////////////////////// -->
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                displayTableData(demo_data);
            });

            function displayTableData(data) {
                let tableBody = '';
                const baseUrl = "http://localhost/gotwo/";


                data.forEach((item, index) => {
                    // ตรวจสอบสถานะและกำหนดข้อความแสดงผล
                    const statusText =
                        item.pay == 2 ?
                        '<span style="color: green; font-weight: bold;">Verified</span>' :
                        '<span style="color: orange; font-weight: bold;">Under Review</span>';
                    console.log('Demo Data:', demo_data);

                    const riderImgUrl = baseUrl + item.rider_img_profile;
                    const customerImgUrl = baseUrl + item.customer_img_profile;
                    const fullImageUrl = baseUrl + item.image;

                    // เพิ่มแถวข้อมูลในตาราง
                    tableBody += `
        <tr data-bs-toggle="modal" data-bs-target="#exampleModal_rider" onclick="view_modal(${index})">
            <td><img src="${riderImgUrl}" class="rounded-circle" width="50" height="50"> ${item.rider_name}</td>
            <td><img src="${customerImgUrl}" class="rounded-circle" width="50" height="50"> ${item.customer_name}</td>
            <td>${item.pick_up}</td>
            <td>${item.at_drop}</td>
            <td>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#slipModal" onclick="event.stopPropagation(); viewSlip('${item.image}', ${item.id})">View Slip</button>
            </td>
            <td>${statusText}</td>
        </tr>`;
                });

                // อัปเดตเนื้อหาใน tbody ของตาราง
                document.querySelector('#dataTableBody').innerHTML = tableBody;
            }

            let selectedId = null; // กำหนดตัวแปร selectedId เป็นตัวแปร global


            function view_modal(index) {
    const item = demo_data[index]; // ใช้ข้อมูลจากแถวที่เลือก
    const baseUrl = "http://localhost/gotwo/"; // กำหนด Base URL
    const riderImgUrl = baseUrl + item.rider_img_profile;
    const customerImgUrl = baseUrl + item.customer_img_profile;
    const formattedDate = formatDate(item.date); // เรียกใช้ฟังก์ชันจัดฟอร์แมตวันที่

    const show_modal = `
        <div class="popup center container">
            <div class="popup center container">
            <div class="d-flex flex-row align-items-center">
    <div class="me-3">
        <img src="${riderImgUrl}" class="rounded-circle" width="150" height="150">
    </div>
    <div class="mt-3">
        <div class="d-flex flex-row align-items-center">
            <i class="bi bi-person-fill"></i>
            <p class="ms-2 align-content-center fw-bold">Rider</p>
        </div>
        <p>Date: ${formattedDate}</p>
        <p>Name: ${item.rider_name}</p>
        <p>Email: ${item.rider_email}</p>
        <p>Tel: ${item.rider_tel}</p>
        <p>Gender: ${item.rider_gender}</p>
    </div>
</div> 
<hr>
<div class="d-flex flex-row align-items-center">
    <div class="me-3">
        <img src="${customerImgUrl}" class="rounded-circle" width="150" height="150">
    </div>
    <div class="mt-3">
        <div class="d-flex flex-row align-items-center">
            <i class="bi bi-person-fill"></i>
            <p class="ms-2 align-content-center fw-bold">Customer</p>
        </div>
        <p>Date: ${formattedDate}</p>
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



            function viewSlip(imagePath, id) {
                selectedId = id; // กำหนดค่า selectedId
                const slipImage = document.getElementById('slipImage');
                const errorText = document.getElementById('errorText');
                const baseUrl = "http://localhost/gotwo/";

                if (typeof imagePath === "string" && imagePath.trim() !== "") {
                    const fullImageUrl = baseUrl + imagePath.trim();
                    slipImage.src = fullImageUrl;
                    slipImage.style.display = "block";
                    errorText.style.display = "none";
                } else {
                    slipImage.style.display = "none";
                    errorText.style.display = "block";
                }

                const modal = new bootstrap.Modal(document.getElementById('slipModal'));
                modal.show();
            }



            // ฟังก์ชันสำหรับอัปเดตสถานะ

            function updatePay() {
                if (!selectedId) {
                    alert("No item selected.");
                    return;
                }
                fetch('/public/gotwo_app/confirm_payment_cus.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            id: selectedId,
                            pay: 2,
                        }),
                    })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.success) {
                            alert('Pay updated successfully!');
                            location.reload();
                        } else {
                            alert('Failed to update Pay: ' + data.message);
                        }
                    })
                    .catch((error) => console.error('Error:', error));
            }

            // ฟังก์ชันสำหรับจัดฟอร์แมตวันที่
            function formatDate(dateString) {
                if (!dateString) return 'Not Available'; // ถ้าไม่มีข้อมูลวันที่
                const date = new Date(dateString);
                const day = String(date.getDate()).padStart(2, '0');
                const month = String(date.getMonth() + 1).padStart(2, '0'); // เดือนเริ่มต้นที่ 0
                const year = date.getFullYear();
                return `${day}/${month}/${year}`;
            }
        </script>


</body>

</html>