<?php
session_start();
require("config.php");

if(!isset($_SESSION['auser'])) {
    header("location:index.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "UPDATE loan_applications SET status = 'Approved' WHERE id = $id";
    if (mysqli_query($con, $query)) {
        header("location:loanapplications.php?msg=Loan application approved successfully.");
    } else {
        header("location:loanapplications.php?msg=Failed to approve loan application.");
    }
} else {
    header("location:loanapplications.php?msg=Invalid loan application ID.");
}
?>
