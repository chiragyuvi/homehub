<?php 
include("config.php");
$error="";
$msg="";
if (isset($_REQUEST['reg'])) {
    // ... (Your existing registration code - but remove the OTP generation and sending)
    $name = $_SESSION['name'];
    $email = $_SESSION['email'];
    $phone = $_SESSION['phone'];
    $pass = $_SESSION['pass'];
    $utype = $_REQUEST['utype'];
    $ref_code = $_REQUEST['reff'];
    $uimage = $_FILES['uimage']['name'];
    $temp_name1 = $_FILES['uimage']['tmp_name'];
    if (!empty($name) && !empty($email) && !empty($phone) && !empty($pass) ) {
        if (isset($_SESSION['otp_verified']) && $_SESSION['otp_verified'] === true) {
            // OTP is verified, complete registration
            $sql = "INSERT INTO user (uname, uemail, uphone, upass, utype, uimage, ref_code) 
                    VALUES ('$name', '$email', '$phone', '$pass', '$utype', '$uimage', '$ref_code')";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, "sssssss", $name, $email, $phone, $pass, $utype, $uimage, $ref_code);
            $result = mysqli_query($con, $sql);
            move_uploaded_file($temp_name1, "admin/user/$uimage");
            if ($result) {
                $msg = "<p class='alert alert-success'>Register Successfully</p> ";
                unset($_SESSION['otp_verified']);
                echo json_encode(['status' => 'success', 'message' => $msg]);
                // Clear session data
                // unset($_SESSION['name']);
                // unset($_SESSION['email']);
                // unset($_SESSION['phone']);
                // unset($_SESSION['pass']);
                // unset($_SESSION['utype']);
                // unset($_SESSION['ref_code']);
                // unset($_SESSION['uimage']);
                // unset($_SESSION['temp_name1']);
                // unset($_SESSION['otp']);
                // unset($_SESSION['otp_verified']);
            } else {
                $error = "<p class='alert alert-warning'>Register Not Successfully</p> ";
            }
        } else {
            $error = "<p class='alert alert-warning'>Please verify OTP before registering.</p>";
        }
    } else {
        $error = "<p class='alert alert-warning'>Please Fill all the fields</p>";
    }
}


// session_start();
// include("config.php"); // Your database connection

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     // Sanitize and validate data (IMPORTANT!)
//     $name = mysqli_real_escape_string($con, $_POST['name']);
//     $email = mysqli_real_escape_string($con, $_POST['email']);
//     $phone = mysqli_real_escape_string($con, $_POST['phone']);
//     $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT); // Hash the password!
//     $utype = mysqli_real_escape_string($con, $_POST['utype']);
//     $ref_code = mysqli_real_escape_string($con, $_POST['reff']);

//     // Handle file upload
//     $uimage = $_FILES['uimage']['name'];
//     $temp_name1 = $_FILES['uimage']['tmp_name'];
//     $upload_directory = "admin/user/";

//     if (!empty($name) && !empty($email) && !empty($phone) && !empty($pass) && !empty($uimage)) {
//         // **IMPORTANT: Use prepared statements to prevent SQL injection**
//         $sql="INSERT INTO user (uname,uemail,uphone,upass,utype,uimage,ref_code) VALUES ('$name','$email','$phone','$pass','$utype','$uimage','$ref_code')";
//         $result=mysqli_query($con, $sql);
// 		move_uploaded_file($temp_name1,"admin/user/$uimage");

//         if (mysqli_stmt_execute($result)) {
//             move_uploaded_file($temp_name1, $upload_directory . $uimage);
//             echo json_encode(['status' => 'success', 'message' => 'Register Successfully']);

//              // Clear session data
//             unset($_SESSION['otp']);
//             unset($_SESSION['otp_verified']);

//         } else {
//             echo json_encode(['status' => 'error', 'message' => 'Register Not Successfully']);
//         }
//         mysqli_stmt_close($result);
//     } else {
//         echo json_encode(['status' => 'error', 'message' => 'Please fill all the fields']);
//     }
// } else {
//     echo json_encode(['status' => 'error', 'message' => 'Invalid Request']);
// }
?>
<!DOCTYPE html>
<html lang="en">

<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Meta Tags -->
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link rel="shortcut icon" href="images/favicon.ico">

<!--	Fonts
	========================================================-->
<link href="https://fonts.googleapis.com/css?family=Muli:400,400i,500,600,700&amp;display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Comfortaa:400,700" rel="stylesheet">

<!--	Css Link
	========================================================-->
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap-slider.css">
<link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="css/layerslider.css">
<link rel="stylesheet" type="text/css" href="css/color.css">
<link rel="stylesheet" type="text/css" href="css/owl.carousel.min.css">
<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="fonts/flaticon/flaticon.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/login.css">

<!--	Title
	=========================================================-->
<title>Real Estate PHP</title>
</head>
<body>

<!--	Page Loader
=============================================================
<div class="page-loader position-fixed z-index-9999 w-100 bg-white vh-100">
	<div class="d-flex justify-content-center y-middle position-relative">
	  <div class="spinner-border" role="status">
		<span class="sr-only">Loading...</span>
	  </div>
	</div>
</div>
--> 


<div id="page-wrapper">
    <div class="row"> 
        <!--	Header start  -->
		<?php include("include/header.php");?>
        <!--	Header end  -->
        
        <!--	Banner   --->
        <!-- <div class="banner-full-row page-banner" style="background-image:url('images/breadcromb.jpg');">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h2 class="page-name float-left text-white text-uppercase mt-1 mb-0"><b>Register</b></h2>
                    </div>
                    <div class="col-md-6">
                        <nav aria-label="breadcrumb" class="float-left float-md-right">
                            <ol class="breadcrumb bg-transparent m-0 p-0">
                                <li class="breadcrumb-item text-white"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Register</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div> -->
         <!--	Banner   --->
		 
		 
		 
        <div class="page-wrappers login-body full-row bg-gray">
            <div class="login-wrapper">
            	<div class="container">
                	<div class="loginbox">
                        <div class="login-right">
							<div class="login-right-wrap">
								<h1>Register</h1>
								<p class="account-subtitle">Access to our dashboard</p>
								<?php echo $error; ?><?php echo $msg; ?>
								<!-- Form -->
								<form method="post" enctype="multipart/form-data">
									<div class="form-group">
										<input type="text"  name="name" class="form-control" placeholder="Your Name*">
									</div>
									<div class="form-group">
										<input type="email"  name="email" class="form-control" id="email" placeholder="Your Email*">
										<div class="input-group-append">
                                        	<button class="btn btn-outline-secondary" type="button" id="send-otp">Send OTP</button>
                                    	</div>
									</div>
									
									<div class="form-group">
										<input type="text"  name="phone" class="form-control" placeholder="Your Phone*" maxlength="10">
									</div>
									<div class="form-group">
										<input type="password" name="pass"  class="form-control" placeholder="Your Password*">
									</div>
									<div class="form-group">
										<input type="text"  name="reff" class="form-control" placeholder="Enter Refferal Code">
									</div>
									<div class="form-group">
										<input type="text"  name="otp" class="form-control" placeholder="Enter OTP*" maxlength="10">
										<div id="otp-error" class="text-danger"></div>
									</div>
					


									 <div class="form-check-inline">
									  <label class="form-check-label">
										<input type="radio" class="form-check-input" name="utype" value="user" checked>User
									  </label>
									</div>
									<div class="form-check-inline">
									  <label class="form-check-label">
										<input type="radio" class="form-check-input" name="utype" value="agent">Agent
									  </label>
									</div>
									<div class="form-check-inline disabled">
									  <label class="form-check-label">
										<input type="radio" class="form-check-input" name="utype" value="builder">Builder
									  </label>
									</div> 
									<div class="form-check-inline disabled">
									  <label class="form-check-label">
										<input type="radio" class="form-check-input" name="utype" value="designer">Designer
									  </label>
									</div> 
									
									<div class="form-group">
										<label class="col-form-label"><b>User Image</b></label>
										<input class="form-control" name="uimage" type="file">
										
									</div>

									<button class="btn btn-success" name="reg" value="Register" id="register-btn" type="submit" >Register</button>
									
								
								<div class="login-or">
									<span class="or-line"></span>
									<span class="span-or">or</span>
								</div>
								
								<!-- Social Login -->
								<!-- <div class="social-login">
									<span>Register with</span>
									<a href="#" class="facebook"><i class="fab fa-facebook-f"></i></a>
									<a href="#" class="google"><i class="fab fa-google"></i></a>
									<a href="#" class="facebook"><i class="fab fa-twitter"></i></a>
									<a href="#" class="google"><i class="fab fa-instagram"></i></a>
								</div> -->
								<!-- /Social Login -->
								
								<div class="text-center dont-have">Already have an account? <a href="login.php">Login</a></div>
								
							</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	<!--	login  -->
        
        
        <!--	Footer   start-->
		<?php include("include/footer.php");?>
		<!--	Footer   start-->
        
        <!-- Scroll to top --> 
        <a href="#" class="bg-secondary text-white hover-text-secondary" id="scroll"><i class="fas fa-angle-up"></i></a> 
        <!-- End Scroll To top --> 
    </div>
</div>
<!-- Wrapper End --> 

<!--	Js Link
============================================================--> 
<script src="js/jquery.min.js"></script> 
<!--jQuery Layer Slider --> 
<script src="js/greensock.js"></script> 
<script src="js/layerslider.transitions.js"></script> 
<script src="js/layerslider.kreaturamedia.jquery.js"></script> 
<!--jQuery Layer Slider --> 
<script src="js/popper.min.js"></script> 
<script src="js/bootstrap.min.js"></script> 
<script src="js/owl.carousel.min.js"></script> 
<script src="js/tmpl.js"></script> 
<script src="js/jquery.dependClass-0.1.js"></script> 
<script src="js/draggable-0.1.js"></script> 
<script src="js/jquery.slider.js"></script> 
<script src="js/wow.js"></script> 
<script src="js/custom.js"></script>
<script>
        // $(document).ready(function() {
        //     $("#send-otp").click(function(event) {
		// 		event.preventDefault();
        //         var email = $("#email").val();
        //         if (email == "") {
        //             alert("Please enter your email.");
        //             return;
        //         }
        //         $.ajax({
        //             url: 'send_otp.php',
        //             type: 'POST',
        //             data: {
        //                 email: email
        //             },
        //             dataType: 'json',
        //             success: function(response) {
        //                 if (response.status == "success") {
        //                     alert(response.message);
        //                     // Enable the OTP field and Register button
        //                     $("#otp").prop("disabled", false);
        //                     $("#register-btn").prop("disabled", false);
        //                     // Store other form data in session
        //                     $('input[name="name"]').val();
        //                     $('input[name="phone"]').val();
        //                     $('input[name="pass"]').val();
        //                     $('input[name="reff"]').val();
        //                     $('input[name="utype"]').val();
        //                     $('input[name="uimage"]').val();
        //                 } else {
        //                     alert(response.message);
        //                 }
        //             },
        //             error: function() {
        //                 alert("Error sending OTP.");
        //             }
        //         });
        //     });
        //     $("#otp").on('input', function() {
        //         var enteredOtp = $(this).val();
        //         var email = $("#email").val();
        //         if (enteredOtp.length == 6) {
        //             $.ajax({
        //                 url: 'send_otp.php', //verify_otp.php
        //                 type: 'POST',
        //                 data: {
        //                     otp: enteredOtp,
        //                     email: email
        //                 },
        //                 dataType: 'json',
        //                 success: function(response) {
        //                     if (response.status == "success") {
        //                         $("#otp-error").text("");
        //                         $("#register-btn").prop("disabled", false);
        //                         $_SESSION['otp_verified'] = true;
        //                         $_SESSION['name'] = $('input[name="name"]').val();
        //                         $_SESSION['email'] = $('input[name="email"]').val();
        //                         $_SESSION['phone'] = $('input[name="phone"]').val();
        //                         $_SESSION['pass'] = $('input[name="pass"]').val();
        //                         $_SESSION['utype'] = $('input[name="utype"]').val();
        //                         $_SESSION['ref_code'] = $('input[name="reff"]').val();
        //                         $_SESSION['uimage'] = $('input[name="uimage"]').val();
        //                         $_SESSION['temp_name1'] = $('input[name="uimage"]').val();
        //                     } else {
        //                         $("#otp-error").text(response.message);
        //                         $("#register-btn").prop("disabled", true);
        //                     }
        //                 },
        //                 error: function() {
        //                     alert("Error verifying OTP.");
        //                 }
        //             });
        //         } else {
        //             $("#otp-error").text("OTP must be 6 digits.");
        //             $("#register-btn").prop("disabled", true);
        //         }
        //     });
        // });


		// $(document).ready(function() {
		// 	$("#send-otp").click(function(e) {
		// 		e.preventDefault();
		// 		var email = $("#email").val();
		// 		if (email === "") {
		// 			alert("Please enter your email.");
		// 			return;
		// 		}
		// 		$.ajax({
		// 			url: 'send_otp.php',
		// 			type: 'POST',
		// 			data: { email: email },
		// 			dataType: 'json',
		// 			success: function(response) {
		// 				if (response.status === "success") {
		// 					alert(response.message);
		// 					$("#otp").prop("disabled", false);
		// 					$("#register-btn").prop("disabled", true); //disabled until otp is verified.
		// 				} else {
		// 					alert(response.message);
		// 				}
		// 			},
		// 			error: function() {
		// 				alert("Error sending OTP.");
		// 			}
		// 		});
		// 	});

		// 	$("#otp").on('input', function() {
		// 		var enteredOtp = $(this).val();
		// 		var email = $("#email").val();
		// 		if (enteredOtp.length === 6) {
		// 			$.ajax({
		// 				url: 'verify_otp.php', // Separate PHP script for verification
		// 				type: 'POST',
		// 				data: { otp: enteredOtp, email: email },
		// 				dataType: 'json',
		// 				success: function(response) {
		// 					if (response.status === "success") {
		// 						$("#otp-error").text("");
		// 						$("#register-btn").prop("disabled", false);
		// 						//now the user can register.
		// 					} else {
		// 						$("#otp-error").text(response.message);
		// 						$("#register-btn").prop("disabled", true);
		// 					}
		// 				},
		// 				error: function() {
		// 					alert("Error verifying OTP.");
		// 				}
		// 			});
		// 		} else {
		// 			$("#otp-error").text("OTP must be 6 digits.");
		// 			$("#register-btn").prop("disabled", true);
		// 		}
		// 	});
		// });



		$(document).ready(function() {
            $("#send-otp").click(function(e) {
                e.preventDefault();
                var email = $("#email").val();
                if (email === "") {
                    alert("Please enter your email.");
                    return;
                }
                $.ajax({
                    url: 'send_otp.php',
                    type: 'POST',
                    data: { email: email },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === "success") {
                            alert(response.message);
                            $("#otp").prop("disabled", false);
                            $("#register-btn").prop("disabled", true); //disabled until otp is verified.
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function() {
                        alert("Error sending OTP.");
                    }
                });
        });

        $("#otp").on('input', function() {
            var enteredOtp = $(this).val();
            var email = $("#email").val();
            if (enteredOtp.length === 6) {
                $.ajax({
                    url: 'verify_otp.php', // Separate PHP script for verification
                    type: 'POST',
                    data: { otp: enteredOtp, email: email },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === "success") {
                            $("#otp-error").text("");
                            $("#register-btn").prop("disabled", false);
                            //now the user can register.
                        } else {
                            $("#otp-error").text(response.message);
                            $("#register-btn").prop("disabled", true);
                        }
                    },
                    error: function() {
                        alert("Error verifying OTP.");
                    }
                });
            } else {
                $("#otp-error").text("OTP must be 6 digits.");
                $("#register-btn").prop("disabled", true);
            }
        });

    // Handle Registration via AJAX
        $("#register-btn").click(function(e) {
            e.preventDefault(); // Prevent default form submission

            // Collect form data
            var name = $("input[name='name']").val();
            var email = $("#email").val();
            var phone = $("input[name='phone']").val();
            var pass = $("input[name='pass']").val();
            var reff = $("input[name='reff']").val();
            var utype = $("input[name='utype']:checked").val();
            var uimage = $("input[name='uimage']")[0].files[0]; // Get the file object

            // Create FormData object to handle file uploads
            var formData = new FormData();
            formData.append('name', name);
            formData.append('email', email);
            formData.append('phone', phone);
            formData.append('pass', pass);
            formData.append('reff', reff);
            formData.append('utype', utype);
            formData.append('uimage', uimage);

            $.ajax({
                url: 'register.php', // New PHP file to handle registration
                type: 'POST',
                data: formData,
                contentType: false, // Important for file uploads
                processData: false, // Important for file uploads
                dataType: 'json',
                success: function(response) {
                    if (response.status === "success") {
                        alert(response.message);
                        // Redirect or show success message
                        window.location.href = "login.php"; // Example: Redirect to login
                    } else {
                        alert(response.message);
                    }
                },
                error: function() {
                    alert("Error during registration.");
                }
            });
        });
});
    </script>
</body>
</html>