<?php
session_start();
require("config.php");

// Check if the admin user is logged in
if(!isset($_SESSION['auser'])) {
    header("location:index.php");
    exit; // Exit to prevent further script execution
}

// Fetch loan applications from the database using prepared statements to avoid SQL injection
$query = mysqli_query($con, "SELECT * FROM loan_applications");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>LM Homes | Admin</title>
    
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    
    <!-- Feathericon CSS -->
    <link rel="stylesheet" href="assets/css/feathericon.min.css">
    
    <!-- Datatables CSS -->
    <link rel="stylesheet" href="assets/plugins/datatables/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="assets/plugins/datatables/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="assets/plugins/datatables/select.bootstrap4.min.css">
    <link rel="stylesheet" href="assets/plugins/datatables/buttons.bootstrap4.min.css">
    
    <!-- Main CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    
    <!--[if lt IE 9]>
        <script src="assets/js/html5shiv.min.js"></script>
        <script src="assets/js/respond.min.js"></script>
    <![endif]-->
</head>
<body>

    <!-- Header -->
    <?php include("header.php"); ?>
    <!-- /Header -->
        
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content container-fluid">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">Loan Applications</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Loan Applications</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Loan Application List</h4>
                            <?php 
                                if(isset($_GET['msg'])) {
                                    echo "<div class='alert alert-info'>".htmlspecialchars($_GET['msg'])."</div>";
                                }
                            ?>
                        </div>
                        <div class="card-body">
                            
                            <!-- Responsive Table Wrapper -->
                            <div class="table-responsive">
                                <?php if(mysqli_num_rows($query) == 0): ?>
                                    <p>No loan applications available.</p>
                                <?php else: ?>
                                <table id="basic-datatable" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Mobile Number</th>
                                            <th>PAN Number</th>
                                            <th>Address</th>
                                            <th>Service Type</th>
                                            <th>Monthly Income</th>
                                            <th>Existing Loan</th>
                                            <th>Loan Amount</th>
                                            <th>Tenure</th>
                                            <th>Guarantor Name</th>
                                            <th>Guarantor Mobile</th>
                                            <th>Guarantor Email</th>
                                            <th>Documents</th>
                                            <th>Profile Photo</th>
                                            <th>Address Proof</th>
                                            <th>Submitted At</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                    <?php
                                        $cnt = 1;
                                        while($row = mysqli_fetch_assoc($query)) {
                                            $status = $row['status'] ?? 'Pending';
                                    ?>
                                        <tr>
                                            <td><?php echo $cnt; ?></td>
                                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                                            <td><?php echo htmlspecialchars($row['mobile_number']); ?></td>
                                            <td><?php echo htmlspecialchars($row['pan_number']); ?></td>
                                            <td><?php echo htmlspecialchars($row['address']); ?></td>
                                            <td><?php echo htmlspecialchars($row['service_type']); ?></td>
                                            <td><?php echo htmlspecialchars($row['monthly_income']); ?></td>
                                            <td><?php echo htmlspecialchars($row['existing_loan']); ?></td>
                                            <td><?php echo htmlspecialchars($row['loan_amount']); ?></td>
                                            <td><?php echo htmlspecialchars($row['tenure']); ?></td>
                                            <td><?php echo htmlspecialchars($row['guarantor_name']); ?></td>
                                            <td><?php echo htmlspecialchars($row['guarantor_mobile_number']); ?></td>
                                            <td><?php echo htmlspecialchars($row['guarantor_email']); ?></td>
                                            <td>
                                                <a href="admin/user/<?php echo htmlspecialchars($row['file_upload']); ?>" target="_blank">Download</a>
                                            </td>
                                            <td>
                                                <?php if (!empty($row['profile_photo'])) { ?>
                                                    <img src="admin/user/<?php echo htmlspecialchars($row['profile_photo']); ?>" height="50px" width="50px" alt="Profile Photo">
                                                <?php } else { ?>
                                                    <img src="assets/img/placeholder.png" height="50px" width="50px" alt="Placeholder Photo">
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <a href="admin/user/<?php echo htmlspecialchars($row['address_proof_upload']); ?>" target="_blank">Download</a>
                                            </td>
                                            <td><?php echo htmlspecialchars($row['submitted_at']); ?></td>
                                            <td><?php echo htmlspecialchars($status); ?></td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-primary dropdown-toggle" type="button" id="actionMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Action
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="actionMenu">
                                                        <a class="dropdown-item" href="approve.php?id=<?php echo $row['id']; ?>">Approve</a>
                                                        <a class="dropdown-item" href="reject.php?id=<?php echo $row['id']; ?>">Reject</a>
                                                        <a class="dropdown-item" href="hold.php?id=<?php echo $row['id']; ?>">Hold</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php
                                        $cnt++;
                                        } 
                                    ?>
                                    </tbody>
                                </table>
                                <?php endif; ?>
                            </div> <!-- End of table-responsive -->

                        </div>
                    </div>
                </div>
            </div>
        
        </div>            
    </div>
    <!-- /Main Wrapper -->

    <!-- jQuery -->
    <script src="assets/js/jquery-3.2.1.min.js"></script>
    
    <!-- Bootstrap Core JS -->
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    
    <!-- Slimscroll JS -->
    <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    
    <!-- Datatables JS -->
    <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/plugins/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="assets/plugins/datatables/dataTables.responsive.min.js"></script>
    <script src="assets/plugins/datatables/responsive.bootstrap4.min.js"></script>
    
    <script src="assets/plugins/datatables/dataTables.select.min.js"></script>
    
    <script src="assets/plugins/datatables/dataTables.buttons.min.js"></script>
    <script src="assets/plugins/datatables/buttons.bootstrap4.min.js"></script>
    <script src="assets/plugins/datatables/buttons.html5.min.js"></script>
    <script src="assets/plugins/datatables/buttons.flash.min.js"></script>
    <script src="assets/plugins/datatables/buttons.print.min.js"></script>
    
    <!-- Custom JS -->
    <script src="assets/js/script.js"></script>
    <script>
        $(document).ready(function() {
            $('#basic-datatable').DataTable();
        });
    </script>
    
</body>
</html>
