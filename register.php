<?php
 include("config.php");
 session_start();
 $error = "";
 $msg = "";
 if (isset($_REQUEST['reg'])) {
     $name = $_REQUEST['name'];
     $email = $_REQUEST['email'];
     $phone = $_REQUEST['phone'];
     $pass = $_REQUEST['pass'];
     $utype = $_REQUEST['utype'];
     $ref_code = $_REQUEST['reff'];
     $uimage = $_FILES['uimage']['name'];
     $temp_name1 = $_FILES['uimage']['tmp_name'];
     $query = "SELECT * FROM user WHERE uemail='$email'";
     $res = mysqli_query($con, $query);
     $num = mysqli_num_rows($res);
     $otp = rand(100000, 999999); // Generate a 6-digit OTP
     if ($num == 1) {
         $error = "<p class='alert alert-warning'>Email Id already Exist</p> ";
     } else {
         if (!empty($name) && !empty($email) && !empty($phone) && !empty($pass) && !empty($uimage)) {
             move_uploaded_file($temp_name1, "admin/user/$uimage");
             // Store user data in session (without OTP)
             $_SESSION['temp_user_data'] = array(
                 'uname' => $name,
                 'uemail' => $email,
                 'uphone' => $phone,
                 'upass' => $pass,
                 'utype' => $utype,
                 'uimage' => $uimage,
                 'ref_code' => $ref_code
             );
             // Store OTP in the database
             date_default_timezone_set('Asia/Kolkata');
             $otp_expiration = date('Y-m-d H:i:s', strtotime('+10 minutes')); // OTP expires in 10 minutes
             $otp_sql = "INSERT INTO user_otps (uemail, otp, expires_at) VALUES ('$email', '$otp', '$otp_expiration')";
             if (mysqli_query($con, $otp_sql) && sendOTP($email, $otp)) {
                 header("Location: otp_verify.php");
                 exit();
             } else {
                 $error = "<p class='alert alert-warning'>Failed to send or store OTP. Please try again.</p>";
             }
         } else {
             $error = "<p class='alert alert-warning'>Please Fill all the fields</p>";
         }
     }
 }
 function sendOTP($email, $otp) {
     $to = $email;
     $subject = "Your OTP Verification Code";
     $message = "Your OTP is: " . $otp;
     $headers = "From: yuvrajdhariwal222@gmail.com";  // Replace with your email
     if (mail($to, $subject, $message, $headers)) {
         return true;
     } else {
         return false;
     }
 }
// include("config.php");
// $error="";
// $msg="";
// if(isset($_REQUEST['reg']))
// {
// 	$name=$_REQUEST['name'];
// 	$email=$_REQUEST['email'];
// 	$phone=$_REQUEST['phone'];
// 	$pass=$_REQUEST['pass'];
// 	$utype=$_REQUEST['utype'];
// 	$ref_code = $_REQUEST['reff'];
	
	
	
// 	$uimage=$_FILES['uimage']['name'];
// 	$temp_name1 = $_FILES['uimage']['tmp_name'];
	
	
// 	$query = "SELECT * FROM user where uemail='$email'";
// 	$res=mysqli_query($con, $query);
// 	$num=mysqli_num_rows($res);
// 	$otp=rand(00000,99999);
// 	if($num == 1)
// 	{
// 		$error = "<p class='alert alert-warning'>Email Id already Exist</p> ";
// 	}
// 	else
// 	{
		
// 		if(!empty($name) && !empty($email) && !empty($phone) && !empty($pass) && !empty($uimage))
// 		{
			
// 			$sql="INSERT INTO user (uname,uemail,uphone,upass,utype,uimage,ref_code) VALUES ('$name','$email','$phone','$pass','$utype','$uimage','$ref_code')";
// 			$result=mysqli_query($con, $sql);
// 			move_uploaded_file($temp_name1,"admin/user/$uimage");
// 			   if($result){
// 				   $msg = "<p class='alert alert-success'>Register Successfully</p> ";
// 			   }
// 			   else{
// 				   $error = "<p class='alert alert-warning'>Register Not Successfully</p> ";
// 			   }
// 		}else{
// 			$error = "<p class='alert alert-warning'>Please Fill all the fields</p>";
// 		}
// 	}
	
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
										<input type="email"  name="email" class="form-control" placeholder="Your Email*">
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
									<div id="extra-field-container" style="display: none;">
									<div class="form-group">
										<label for="extra-field">Enter MahaRERA (Maharashtra Real Estate Regulatory Authority) number:</label>
										<input type="text" class="form-control" id="extra-field" name="extra_field" placeholder="Enter P followed by 8 digits" oninput="validateExtraField()">
										</div>
									</div>
									<div class="form-group">
										<label class="col-form-label"><b>User Image</b></label>
										<input class="form-control" name="uimage" type="file" accept=".jpeg, .jpg, .png">
										
									</div>

									<button class="btn btn-success" name="reg" value="Register" type="submit">Register</button>
									
								</form>
								
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
<script>
    $(document).ready(function() {
        $('input[name="utype"]').change(function() {
            if ($(this).val() === 'agent' || $(this).val() === 'builder' ) {
                $('#extra-field-container').show();
            } else {
                $('#extra-field-container').hide();
            }
        });
    });

    function validateExtraField() {
        const inputField = document.getElementById('extra-field');
        const inputValue = inputField.value;

        // Regular expression to test for "P" followed by 8 digits
        const regex = /^P\d{8}$/;

        if (!regex.test(inputValue)) {
            // If the format is invalid, you can provide feedback
            inputField.setCustomValidity("Please enter P followed by 8 digits (e.g., P12345678)");
        } else {
            // If the format is valid, clear any previous error message
            inputField.setCustomValidity("");
        }
    }
</script>
<script>
    const fileInput = document.querySelector('input[name="uimage"]');
    const form = document.querySelector('form'); // Get the form element

    form.addEventListener('submit', function(event) {
        const file = fileInput.files[0];
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];

        if (file && !allowedTypes.includes(file.type)) {
            alert('Please select an image of type JPEG, JPG, or PNG.');
            event.preventDefault(); // Prevent form submission
        }
    });
</script>
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
</body>
</html>