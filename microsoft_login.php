<?php
session_start();
include("config.php");
 // If you're using an SDK, install via Composer.

$error = "";
$msg = "";

// Microsoft OAuth2 credentials from Azure Portal
$client_id = "ffcb0ab3-a8d8-434e-b2e6-bf4d986b1517";
$client_secret = "6dR8Q~ijcXe7_MZud62wBKa_aVN35x.IdU7A_aiU";
$redirect_uri = ""; // e.g., http://localhost/
$tenant_id = "e1d23151-025b-4615-a1a1-c802c96d43b9";

// Step 1: Redirect to Microsoft Login if not authenticated
if (!isset($_GET['code'])) {
    $auth_url = "https://login.microsoftonline.com/$tenant_id/oauth2/v2.0/authorize?client_id=$client_id&response_type=code&redirect_uri=$redirect_uri&scope=openid profile User.Read";
    header('Location: ' . $auth_url);
    exit();
}

// Step 2: Handle Microsoft OAuth2 callback
if (isset($_GET['code'])) {
    $code = $_GET['code'];

    // Step 3: Exchange authorization code for an access token
    $token_url = "https://login.microsoftonline.com/$tenant_id/oauth2/v2.0/token";
    $data = [
        'client_id' => $client_id,
        'client_secret' => $client_secret,
        'code' => $code,
        'redirect_uri' => $redirect_uri,
        'grant_type' => 'authorization_code'
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $token_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    $response = curl_exec($ch);
    curl_close($ch);

    $response_data = json_decode($response, true);
    $access_token = $response_data['access_token'];

    // Step 4: Get user profile information from Microsoft Graph API
    $graph_url = "https://graph.microsoft.com/v1.0/me";
    $headers = [
        "Authorization: Bearer $access_token"
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $graph_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $user_info = curl_exec($ch);
    curl_close($ch);

    $user = json_decode($user_info, true);

    if (isset($user['id'])) {
        // Save user info to your database (you might want to adjust this part to match your database schema)
        $email = $user['mail'] ?? $user['userPrincipalName']; // Get the email
        $name = $user['displayName'];
        
        // Check if the user already exists in the database
        $sql = "SELECT * FROM user WHERE uemail = '$email'";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($result);

        if (!$row) {
            // Insert new user into database
            $insert_sql = "INSERT INTO user (uemail, uname) VALUES ('$email', '$name')";
            mysqli_query($con, $insert_sql);
        }

        // Set session variables
        $_SESSION['uid'] = $row['uid'] ?? mysqli_insert_id($con); // Handle new user or existing user
        $_SESSION['uemail'] = $email;

        // Redirect to your app's homepage
        header("Location: index.php");
        exit();
    } else {
        $error = "<p class='alert alert-warning'>Failed to retrieve user information from Microsoft.</p>";
    }
}
?>
