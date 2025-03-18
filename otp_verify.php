<?php
session_start();
include("config.php");
$error = "";
$msg = "";
if (!isset($_SESSION['temp_user_data'])) {
    header("Location: register.php");
    exit();
}
if (isset($_POST['otp'])) {
    $user_otp = $_POST['otp'];
    $email = $_SESSION['temp_user_data']['uemail'];
    $otp_query = "SELECT * FROM user_otps WHERE uemail = '$email' AND otp = '$user_otp' AND expires_at > NOW() ORDER BY created_at DESC LIMIT 1";
    $otp_result = mysqli_query($con, $otp_query);

    if ($otp_result) {
        if (mysqli_num_rows($otp_result) == 1) {
            $name = $_SESSION['temp_user_data']['uname'];
            $phone = $_SESSION['temp_user_data']['uphone'];
            $pass = $_SESSION['temp_user_data']['upass'];
            $utype = $_SESSION['temp_user_data']['utype'];
            $uimage = $_SESSION['temp_user_data']['uimage'];
            $ref_code = $_SESSION['temp_user_data']['ref_code'];
            $sql = "INSERT INTO user (uname, uemail, uphone, upass, utype, uimage, ref_code) VALUES ('$name', '$email', '$phone', '$pass', '$utype', '$uimage', '$ref_code')";
            $result = mysqli_query($con, $sql);
            if ($result) {
                $msg = "<p class='alert alert-success'>Register Successfully</p><br><a href='login.php'>go to Login Page</a>";
                unset($_SESSION['temp_user_data']);
                mysqli_query($con, "DELETE FROM user_otps WHERE uemail = '$email'");
            } else {
                $error = "<p class='alert alert-warning'>Register Not Successfully</p> ";
            }
        } else {
            $error = "<p class='alert alert-warning'>Invalid or Expired OTP</p>";
        }
    } else {
        $error = "<p class='alert alert-danger'>Database query error: " . mysqli_error($con) . "</p>";
    }
    echo $error . $msg;
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>OTP Verification</h1>
        <div id="result"></div>
        <form id="otpForm">
            <div class="form-group">
                <label for="otp">Enter OTP</label>
                <input type="text" name="otp" id="otp" class="form-control" required>
            </div>
            <button type="button" id="verifyOtpButton" class="btn btn-primary">Verify OTP</button>
        </form>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#verifyOtpButton').click(function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '', // URL is intentionally left blank, as the form submission is handled by AJAX
                    data: $('#otpForm').serialize(),
                    success: function(response) {
                        $('#result').html(response);
                        $('#otpForm').hide();

                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", status, error);
                        $('#result').html("<p class='alert alert-danger'>An error occurred.</p>");
                    }
                });
            });
        });
    </script>
</body>
</html>