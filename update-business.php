
<?php
session_start();

// Check if logged in
if (!isset($_SESSION['business_id'])) {
    header("Location: business-login.php");
    exit();
}

// Database connection
$host = "localhost";
$username = "root"; 
$password = ""; 
$database = "localfinder";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $business_id = $_SESSION['business_id'];
    
    // Get form data and sanitize
    $business_name = mysqli_real_escape_string($conn, $_POST['business_name']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $state = mysqli_real_escape_string($conn, $_POST['state']);
    $postal_code = mysqli_real_escape_string($conn, $_POST['postal_code']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $owner_name = mysqli_real_escape_string($conn, $_POST['owner_name']);
    
    // Check if email already exists for different business
    $check_query = "SELECT id FROM businesses WHERE email = '$email' AND id != $business_id";
    $check_result = mysqli_query($conn, $check_query);
    
    if (mysqli_num_rows($check_result) > 0) {
        // Email already exists for another business
        $_SESSION['update_error'] = "Email address already in use by another business.";
        header("Location: business-dashboard.php");
        exit();
    }
    
    // Update the business
    $update_query = "UPDATE businesses SET 
        business_name = '$business_name',
        category = '$category',
        description = '$description',
        address = '$address',
        city = '$city',
        state = '$state',
        postal_code = '$postal_code',
        phone = '$phone',
        email = '$email',
        owner_name = '$owner_name'
        WHERE id = $business_id";
        
    if (mysqli_query($conn, $update_query)) {
        $_SESSION['update_success'] = "Business information updated successfully!";
    } else {
        $_SESSION['update_error'] = "Error updating business information: " . mysqli_error($conn);
    }
    
    mysqli_close($conn);
    
    // Redirect back to dashboard
    header("Location: business-dashboard.php");
    exit();
}
?>
