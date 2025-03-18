// send_otp.php
<?php
// Function to send OTP via email
function sendOTPEmail($user_email, $otp_code) {
    $subject = "Your OTP Code";
    $message = "Your OTP code is: " . $otp_code;
    $headers = "From: no-reply@yourwebsite.com";

    if(mail($user_email, $subject, $message, $headers)) {
        return true;
    } else {
        return false;
    }
}
