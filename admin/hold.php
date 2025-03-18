<?php
session_start();
require("config.php");

if(!isset($_SESSION['auser'])) {
    header("location:index.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "UPDATE loan_applications SET status = 'Hold' WHERE id = $id";
    if (mysqli_query($con, $query)) {
        header("location:loanapplications.php?msg=Loan application put on hold successfully.");
    } else {
        header("location:loanapplications.php?msg=Failed to put loan application on hold.");
    }
} else {
    header("location:loanapplications.php?msg=Invalid loan application ID.");
}
?>
