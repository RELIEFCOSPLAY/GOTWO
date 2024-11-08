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
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Travel Tracking Details_pending</title>
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
                    <span class="mx-4 fw-bold"> Natthawut Sinnamkham</span>
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
                            <a href="/public/gotwo_app/Rider_Request.html" class="sidebar-link">Rider</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="/public/gotwo_app/Customer_Suspend.html" class="sidebar-link">Customer</a>
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
                            <!-- <tr>
                                <td>Peter Potter</td>
                                <td>Griffin lily</td>
                                <td>FahThai Soi5</td>
                                <td>M-square</td>
                            </tr>
                            <tr>
                                <td>Lisa Lalisa</td>
                                <td>Jisoo Kim</td>
                                <td>D1</td>
                                <td>M-square</td>
                            </tr>
                            <tr>
                                <td>Rose Salin</td>
                                <td>Henry Wang</td>
                                <td>D1</td>
                                <td>M-square</td>
                            </tr>
                            <tr>
                                <td>Riku Gun</td>
                                <td>Miyuki</td>
                                <td>C5</td>
                                <td>M-square</td>
                            </tr> -->
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
        <script src="/public/js/gotwo_js/tracking_nav_animation.js"></script>
        <script src="/public/js/gotwo_js/searchfuction.js"></script>

        <?php
        // ดึงข้อมูลจากฐานข้อมูล Rider
        $sql = "SELECT name FROM table_rider";
        $query = $conn->prepare($sql);
        $query->execute();
        $fetch = $query->fetch();
        $name = $fetch['name'];
        // ----------------------------
        $sql = "SELECT email FROM table_rider";
        $query = $conn->prepare($sql);
        $query->execute();
        $fetch = $query->fetch();
        $email = $fetch['email'];
        // ----------------------------
        $sql = "SELECT tel FROM table_rider";
        $query = $conn->prepare($sql);
        $query->execute();
        $fetch = $query->fetch();
        $tel = $fetch['tel'];
        // ----------------------------
        $sql = "SELECT gender FROM table_rider";
        $query = $conn->prepare($sql);
        $query->execute();
        $fetch = $query->fetch();
        $gender = $fetch['gender'];

        // ดึงข้อมูลจากฐานข้อมูล Cus
        $sql = "SELECT name FROM table_customer";
        $query = $conn->prepare($sql);
        $query->execute();
        $fetch = $query->fetch();
        $nameCus = $fetch['name'];
        // ----------------------------
        $sql = "SELECT email FROM table_Customer";
        $query = $conn->prepare($sql);
        $query->execute();
        $fetch = $query->fetch();
        $emailCus = $fetch['email'];
        // ----------------------------
        $sql = "SELECT tel FROM table_Customer";
        $query = $conn->prepare($sql);
        $query->execute();
        $fetch = $query->fetch();
        $telCus = $fetch['tel'];
        // ----------------------------
        $sql = "SELECT gender FROM table_Customer";
        $query = $conn->prepare($sql);
        $query->execute();
        $fetch = $query->fetch();
        $genderCus = $fetch['gender'];
        //////////////////////////////////////
        $sql = "SELECT pick_up FROM post";
        $query = $conn->prepare($sql);
        $query->execute();
        $fetch = $query->fetch();
        $pick_up = $fetch['pick_up'];

        $sql = "SELECT at_drop FROM post";
        $query = $conn->prepare($sql);
        $query->execute();
        $fetch = $query->fetch();
        $at_drop = $fetch['at_drop'];

        $sql = "SELECT img_profile FROM table_rider";
        $query = $conn->prepare($sql);
        $query->execute();
        $fetch = $query->fetch();
        $img_profile_rider = $fetch['img_profile'];

        $sql = "SELECT img_profile FROM table_customer";
        $query = $conn->prepare($sql);
        $query->execute();
        $fetch = $query->fetch();
        $img_profile_Cus = $fetch['img_profile'];
        ?>

        <script>
            const demo_data = [{
                id: 0,
                name: <?= json_encode($name) ?>,
                cus: <?= json_encode($nameCus) ?>,
                pickup: <?= json_encode($pick_up) ?>,
                drop: <?= json_encode($at_drop) ?>,
                rider_img: <?= json_encode($img_profile_rider) ?>,
                customer_img: <?= json_encode($img_profile_Cus) ?>
            }];

            let show_data = '';
            for (let read of demo_data) {
                show_data += `
            <tr data-bs-toggle="modal" data-bs-target="#exampleModal_rider">
                <td><div><img src="${read.rider_img}" class="rounded-circle mx-3" width="50" height="50">${read.name}</div></td>
                <td><div><img src="${read.customer_img}" class="rounded-circle mx-3" width="50" height="50">${read.cus}</div></td>
                <td>${read.pickup}</td>
                <td>${read.drop}</td>
            </tr>
        `;
            }

            document.querySelector('#dataTableBody').innerHTML = show_data;
            view_modal()


            function view_modal() {

                let show_modal = '';
                show_modal += `
            <div class="popup center container">
                                    <div class="d-flex flex-row justify-content-center">
                                        <img src="/public/img/prodiss.jpg" class="rounded-circle" width="150" height="150">
                                        <div class="mt-3 ms-2">
                                            <div class="d-flex flex-row">
                                                <i class="bi bi-person-fill"></i>
                                                <p class="ms-2 align-content-center">Rider</p>
                                            </div>
                                            <p><?= json_encode($name) ?></p>
                                            <p><?= json_encode($email) ?></p>
                                            <p><?= json_encode($tel) ?></p>
                                            <p>Gender:<?= json_encode($gender) ?></p>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row justify-content-center">
                                        <img src="/public/img/prodiss.jpg" class="rounded-circle" width="150" height="150">
                                        <div class="mt-3 ms-2">
                                             <div class="d-flex flex-row">
                                                <i class="bi bi-person-fill"></i>
                                                <p class="ms-2 align-content-center">Customer</p>
                                            </div>
                                            <p><?= json_encode($nameCus) ?></p>
                                            <p><?= json_encode($emailCus) ?></p>
                                            <p><?= json_encode($telCus) ?></p>
                                            <p>Gender:<?= json_encode($genderCus) ?></p>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row justify-content-center">
                                        <div class="d-flex flex-row">
                                            <i class="bi bi-geo-alt-fill"></i>
                                            <p class="ms-2 align-content-center"><?= json_encode($pick_up) ?></p>
                                           
                                            
                                            <i class="bi bi-arrow-right ms-2 me-2"></i>
                                            <i class="bi bi-geo-alt-fill"></i>
                                            <p class="ms-2 align-content-center"><?= json_encode($at_drop) ?></p>
                                           
                                        </div>
                                    </div>
                                </div>
            `;
                document.querySelector('#madal_display').innerHTML = show_modal;
            }
        </script>
</body>

</html>