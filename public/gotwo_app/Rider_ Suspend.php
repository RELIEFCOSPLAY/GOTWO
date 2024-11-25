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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rider_ Suspend</title>
    <script src="/public/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/public/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link rel="stylesheet" href="/public/css/css_gotwo/management_rider.css">
    <link rel="stylesheet" href="/public/css/css_gotwo/sidebar_rider.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

            <p class="text-white mt-4 ms-2 fw-bold">MEUN</p>
            <hr class="text-white d-none d-sm-block" />

            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="/public/gotwo_app/Dashboard.html" class="sidebar-link">
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
                            <a href="/public/gotwo_app/Rider_Request.html" class="sidebar-link">Rider</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="/public/gotwo_app/Customer_Suspend.html" class="sidebar-link">Customer</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item">
                    <a href="/public/gotwo_app/pending_tracking.html" class="sidebar-link">
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
                <!-- <li class="sidebar-item">
                 <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                     data-bs-target="#Report" aria-expanded="false" aria-controls="Report">
                     <i class="bi bi-flag-fill"></i>
                     <span>Report</span>
                 </a>
                 <ul id="Report" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                     <li class="sidebar-item">
                         <a href="#" class="sidebar-link">Rider</a>
                     </li>
                     <li class="sidebar-item">
                         <a href="#" class="sidebar-link">Customer</a>
                     </li>
                 </ul>
             </li> -->
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

        <div class="main p-3">
            <div class="ms-4 mt-3">
                <h1>Management Rider</h1>
                <div class="nav_animation">
                    <ul>
                        <li class="report_nav_animation"><a href="/public/gotwo_app/Rider_Request.php"
                                id="Request">Rider Request</a></li>
                        <li class="history_nav_animation"><a href="/public/gotwo_app/Rider_History.php"
                                id="Request">History</a></li>
                        <li class="suspend_nav_animation"><a href="/public/gotwo_app/Rider_ Suspend.php"
                                id="Request">Suspend</a></li>
                        <span class="slider_nav_animation"></span>
                    </ul>

                </div>


                <form>
                    <label for="cars">
                        <div class="box">
                            <input type="text" placeholder="Search" id="searchInput">
                            <a href="#">
                                <i class="bi bi-search"></i>
                            </a>
                        </div>
                    </label>
                    <!-- <select name="cars" id="cars" class="styled-select">
                        <option value="female">Female</option>
                        <option value="male">Male</option>
                    </select> -->
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
                                        <th scope="col">ACTIONS</th>
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
    <script src="/public/js/gotwo_js/management_suspend.js"></script>
    <script src="/public/js/gotwo_js/searchfuction.js"></script>
    <!-- ------------------------------------------------- -->
    <?php
    $sql = "SELECT regis_rider_id, name, email, tel, img_profile ,status_rider FROM table_rider WHERE status_rider=1 OR status_rider=2";
    $query = $conn->prepare($sql);
    $query->execute();
    $fetch = $query->fetchAll(PDO::FETCH_ASSOC);
    $riderDataJSON = json_encode($fetch, JSON_UNESCAPED_UNICODE);
    ?>

    <!-- ------------------------------------------------- -->
    <script>
        // รับข้อมูล JSON จาก PHP
        const demo_data = <?= $riderDataJSON ?>;

        let show_data = '';
        demo_data.forEach(read => {
            show_data += `
       <tr>
            <td scope="row"><img src="${read.img_profile}" class="img_style mx-2">${read.name}</td>
            <td>${read.email}</td>
            <td>${read.tel}</td>
            <td>${read.status_rider == 0 ? 'Unsuspend' : 'Suspend'}</td> 
            <td>
                <label class="switch">
                    <input type="checkbox" ${read.status_rider == 1 ? 'checked' : ''} onchange="view_(${read.regis_rider_id}, this)">
                    <span class="slider round"></span>
                </label>
            </td>
       </tr>
    `;
        });

        document.querySelector('#dataTableBody').innerHTML = show_data;

        function view_(id, checkbox) {
            const isChecked = checkbox.checked; // สถานะปัจจุบันของ Checkbox
            const action = isChecked ? "Suspend" : "Unsuspend"; // ข้อความสำหรับ Swal
            const status = isChecked ? 1 : 0; // 1 = Suspended, 0 = Unsuspended

            Swal.fire({
                title: `Do you want to ${action} this account?`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes",
                cancelButtonText: "No"
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log("Sending Data:", {
                        regis_rider_id: id,
                        status_rider: status
                    }); // Log ข้อมูลที่ส่ง
                    fetch('update_statusrider.php', {
                            method: 'POST', // ใช้ POST สำหรับอัปเดต
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                regis_rider_id: id,
                                status: status
                            })
                        })
                        .then(response => {
                            console.log("Response:", response); // Log การตอบกลับ
                            return response.json();
                        })
                        .then(data => {
                            // console.log("Response Data:", data); // Log ข้อมูลที่เซิร์ฟเวอร์ส่งกลับ
                            if (data.success) {
                                Swal.fire("Success", `${action}ed successfully!`, "success");
                                checkbox.checked = isChecked; // ยืนยันการเปลี่ยนสถานะ
                            } else {
                                Swal.fire("Error", `Failed to ${action} this account.`, "error");
                                checkbox.checked = !isChecked; // ยกเลิกการเปลี่ยนสถานะ
                            }
                        })
                        .catch(error => {
                            Swal.fire("Success", "Updating the status.", "success");
                            checkbox.checked = isChecked;
                        });

                } else {
                    // กด "No" แสดงข้อความแจ้งยกเลิก
                    const cancelledAction = isChecked ? "suspending" : "unsuspending";
                    Swal.fire("Cancelled", `You have cancelled ${cancelledAction} this account.`, "info");
                    checkbox.checked = !isChecked; // คืนค่ากลับสถานะเดิม
                }
            });
        }
    </script>
</body>

</html>