<?php
include("config.php");
$uid = $_GET['id'];

// View code to retrieve the user's image before deletion
$sql = "SELECT * FROM user WHERE id='$uid'";  // Updated from 'uid' to 'id'
$result = mysqli_query($con, $sql);
while ($row = mysqli_fetch_array($result)) {
    $img = $row["image"];  // Updated from 'uimage' to 'image'
}

// Delete the image from the server
@unlink('user/' . $img);

// End view code
$msg = "";
$sql = "DELETE FROM user WHERE id = {$uid}";  // Updated from 'uid' to 'id'
$result = mysqli_query($con, $sql);
if ($result == true) {
    $msg = "<p class='alert alert-success'>Designer Deleted</p>";  // Updated message
    header("Location:userdesigner.php?msg=$msg");  // Redirect to the designer list page
} else {
    $msg = "<p class='alert alert-warning'>Designer not Deleted</p>";  // Updated message
    header("Location:userdesigner.php?msg=$msg");  // Redirect to the designer list page
}

mysqli_close($con);
?>
