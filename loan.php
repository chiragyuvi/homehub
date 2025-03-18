<?php
session_start();
include("config.php");

// Initialize error and message variables
$error = "";
$msg = "";

// Session check to ensure the user is logged in
if (!isset($_SESSION['uid'])) {
    // If the user is not logged in, redirect to login page
    header("Location: login.php");
    exit;
}
function checkLoanEligibility($monthly_income, $existing_loan, $loan_amount, $cibil_score) {
    // Eligibility rules (adjust these as needed)
    $min_cibil_score = 700;
    $max_loan_amount = $monthly_income * 10; // Example: 10 times monthly income

    if ($cibil_score < $min_cibil_score) {
        return "Loan application can't meet eligibility: CIBIL score is too low.";
    }

    if ($loan_amount > $max_loan_amount) {
        return "Loan application can't meet eligibility: Loan amount requested is too high.";
    }

    if ($existing_loan === 'yes') {
        // Additional checks if an existing loan is present
        $max_loan_amount_with_existing = $monthly_income * 5; // Example: Reduced loan amount eligibility
        if ($loan_amount > $max_loan_amount_with_existing) {
            return "Loan application can't meet eligibility: Loan amount is too high with an existing loan.";
        }
    }

    return true; // Eligibility met
}


// Handle form submission
if (isset($_REQUEST['submit'])) {
    $name = $_POST['name'];
    $mobile_number = $_POST['mobile_number'];
    $pan_number = $_POST['pan_number'];
    $address = $_POST['address'];
    $service_type = $_POST['service_type'];
    $monthly_income = $_POST['monthly_income'];
    $existing_loan = $_POST['existing_loan'];
    $loan_amount = $_POST['loan_amount'];
    $tenure = $_POST['tenure'];
    $guarantor_name = $_POST['guarantor_name'];
    $guarantor_mobile_number = $_POST['guarantor_mobile_number'];
    $guarantor_email = $_POST['guarantor_email'];
    $guarantor_address = $_POST['guarantor_address'];
    $cibil_score = $_POST['cibil_score'];

    // Upload files (profile photo, address proof)
    $file_upload = $_FILES['file_upload']['name'];
    $profile_photo = $_FILES['profile_photo']['name'];
    $address_proof_upload = $_FILES['address_proof_upload']['name'];

    // Set target directory to save the images
    $target_dir = "admin/user/";

    // File upload checks and moving files
    if ($_FILES['file_upload']['error'] === UPLOAD_ERR_OK) {
        move_uploaded_file($_FILES['file_upload']['tmp_name'], $target_dir . $file_upload);
    } else {
        $error = "Error uploading file: " . $_FILES['file_upload']['error'];
    }

    if ($_FILES['address_proof_upload']['error'] === UPLOAD_ERR_OK) {
        move_uploaded_file($_FILES['address_proof_upload']['tmp_name'], $target_dir . $address_proof_upload);
    } else {
        $error = "Error uploading address proof: " . $_FILES['address_proof_upload']['error'];
    }

    if ($_FILES['profile_photo']['error'] === UPLOAD_ERR_OK) {
        move_uploaded_file($_FILES['profile_photo']['tmp_name'], $target_dir . $profile_photo);
    } else {
        $error = "Error uploading profile photo: " . $_FILES['profile_photo']['error'];
    }

    // Database connection
    $con = mysqli_connect("localhost:3307", "root", "", "realestatephp");
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Prepare SQL statement
    $stmt = $con->prepare("INSERT INTO loan_applications (name, mobile_number, pan_number, address, service_type, monthly_income, existing_loan, loan_amount, tenure, guarantor_name, guarantor_mobile_number, guarantor_email, guarantor_address, file_upload, profile_photo, address_proof_upload) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("ssssssssssssssss", $name, $mobile_number, $pan_number, $address, $service_type, $monthly_income, $existing_loan, $loan_amount, $tenure, $guarantor_name, $guarantor_mobile_number, $guarantor_email, $guarantor_address, $file_upload, $profile_photo, $address_proof_upload);

    if ($stmt->execute()) {
        $msg = "<p class='alert alert-success'>Application submitted successfully!</p>";
    } else {
        $error = "<p class='alert alert-danger'>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
    mysqli_close($con);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Loan Application Form</title>
</head>

<body>

    <div id="page-wrapper">
        <div class="row">
            <?php include("include/header.php"); ?>

            <div class="page-wrappers login-body full-row bg-gray">
                <div class="login-wrapper">
                    <div class="container">
                        <div class="loginbox">
                            <div class="login-right">
                                <div class="login-right-wrap">
                                    <h1>Loan Application</h1>
                                    <p class="account-subtitle">Fill in your details below</p>
                                    <?php echo $error; ?>
                                    <?php echo $msg; ?>

                                    <form method="post" enctype="multipart/form-data">
                                        <!-- Input fields for loan application -->
                                        <div class="form-group">
                                            <input type="text" name="name" class="form-control" placeholder="Your Name*" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="mobile_number" class="form-control" placeholder="Mobile Number*" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="pan_number" class="form-control" placeholder="PAN Number*" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="number" name="cibil_score" class="form-control" placeholder="CIBIL Score*" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="file" name="file_upload" class="form-control" required>
                                            <label>Upload Profile Photo</label>
                                        </div>
                                        <div class="form-group">
                                            <textarea name="address" class="form-control" rows="3" placeholder="Your Address*" required></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Address Proof Type:</label>
                                            <select name="address_proof" class="form-control" required>
                                                <option value="aadhaar">Aadhaar Card</option>
                                                <option value="passport">Passport</option>
                                                <option value="voter_id">Voter ID</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="file" name="address_proof_upload" class="form-control" required>
                                            <label>Upload Address Proof</label>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="service_type" class="form-control" placeholder="Service Type (govt/private/business)*" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="number" name="monthly_income" class="form-control" placeholder="Monthly Income*" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Existing Loan:</label>
                                            <select name="existing_loan" class="form-control" required>
                                                <option value="yes">Yes</option>
                                                <option value="no">No</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="number" name="loan_amount" class="form-control" placeholder="Expected Loan Amount*" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="file" name="profile_photo" class="form-control" required>
                                            <label>Upload Profile Photo</label>
                                        </div>
                                        <div class="form-group">
                                            <label>Tenure:</label>
                                            <select name="tenure" class="form-control" required>
                                                <option value="1_year">1 Year</option>
                                                <option value="2_years">2 Years</option>
                                                <option value="3_years">3 Years</option>
                                            </select>
                                        </div>

                                        <h4>Guarantor Info</h4>
                                        <div class="form-group">
                                            <input type="text" name="guarantor_name" class="form-control" placeholder="Guarantor Name*" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="guarantor_mobile_number" class="form-control" placeholder="Guarantor Mobile Number*" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="email" name="guarantor_email" class="form-control" placeholder="Guarantor Email*" required>
                                        </div>
                                        <div class="form-group">
                                            <textarea name="guarantor_address" class="form-control" rows="3" placeholder="Guarantor Address*" required></textarea>
                                        </div>

                                        <button class="btn btn-success" name="submit" type="submit">Submit</button>
                                        <button type="reset" class="btn btn-secondary">Clear</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php include("include/footer.php"); ?>
            </div>
        </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#submitBtn").click(function(event) {
                event.preventDefault(); // Prevent the form from submitting immediately

                // Get the form data
                var name = $("input[name='name']").val();
                var mobile_number = $("input[name='mobile_number']").val();
                var pan_number = $("input[name='pan_number']").val();
                var address = $("textarea[name='address']").val();
                var service_type = $("input[name='service_type']").val();
                var monthly_income = parseInt($("input[name='monthly_income']").val());
                var existing_loan = $("select[name='existing_loan']").val();
                var loan_amount = parseInt($("input[name='loan_amount']").val());
                var tenure = $("select[name='tenure']").val();
                var guarantor_name = $("input[name='guarantor_name']").val();
                var guarantor_mobile_number = $("input[name='guarantor_mobile_number']").val();
                var guarantor_email = $("input[name='guarantor_email']").val();
                var guarantor_address = $("textarea[name='guarantor_address']").val();
                var cibil_score = parseInt($("input[name='cibil_score']").val());

                // Perform eligibility check
                var eligibilityResult = checkLoanEligibility(monthly_income, existing_loan, loan_amount, cibil_score);

                if (eligibilityResult === true) {
                    // Eligibility met, submit the form
                    // $("#loanForm").unbind('submit').submit(); // Unbind preventDefault and submit
                    document.forms[0].submit(); //Alternative to submit the form
                } else {
                    // Eligibility not met, show alert
                    alert(eligibilityResult);
                }
            });

            // *** Eligibility check function (client-side - for demonstration) ***
            function checkLoanEligibility(monthly_income, existing_loan, loan_amount, cibil_score) {
                // *** This is a simplified client-side check for demonstration.
                // *** The server-side check (PHP function) is the authoritative one.

                var min_cibil_score = 700;
                var max_loan_amount = monthly_income * 10;

                if (cibil_score < min_cibil_score) {
                    return "Loan application can't meet eligibility: CIBIL score is too low.";
                }

                if (loan_amount > max_loan_amount) {
                    return "Loan application can't meet eligibility: Loan amount requested is too high.";
                }

                if (existing_loan === 'yes') {
                    var max_loan_amount_with_existing = monthly_income * 5;
                    if (loan_amount > max_loan_amount_with_existing) {
                        return "Loan application can't meet eligibility: Loan amount is too high with an existing loan.";
                    }
                }

                return true;
            }
        });
    </script>
</body>

</html>
