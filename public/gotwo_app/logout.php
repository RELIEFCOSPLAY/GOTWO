<?php
session_start();
session_destroy();

// เรียกใช้งาน SweetAlert และปรับ Smooth Transition
echo '
	<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
  	<style>
      body {
          margin: 0;
          padding: 0;
          height: 100vh;
          display: flex;
          justify-content: center;
          align-items: center;
          background-color: white; 
          opacity: 1;
          transform: scale(1);
          transition: opacity 0.8s ease-out, transform 0.8s ease-out; 
      }
      body.fade-out {
          opacity: 0;
          transform: scale(0.95);
      }
  	</style>
';

// เพิ่ม SweetAlert สำหรับ logout
echo '
	<script>
	    setTimeout(function() {
	        swal({
	            title: "Logout Successful!",
	            text: "Do not forget to come back to use the system again.",
	            type: "success",
	            showConfirmButton: true
	        }, function() {
	            smoothRedirect("login_gotwo2.html");
	        });
	    }, 1000);

	    // ฟังก์ชันสำหรับ Smooth Transition
	    function smoothRedirect(url) {
	        document.body.classList.add("fade-out"); // เพิ่มคลาส fade-out
	        setTimeout(function() {
	            window.location.href = url; // เปลี่ยนเส้นทาง
	        }, 800); // รอ 800ms ให้เอฟเฟกต์สมบูรณ์
	    }
	</script>
';
?>
