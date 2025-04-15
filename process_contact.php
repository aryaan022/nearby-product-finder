
<?php
// Database connection
$servername = "localhost";
$username = "root"; // Change this to your actual database username
$password = ""; // Change this to your actual database password (if any)
$dbname = "localfinder"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    // Log the error for debugging
    error_log("Database connection failed: " . $conn->connect_error);
    
    // Redirect to contact page with error message
    header("Location: contact.php?status=error&message=database");
    exit;
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, isset($_POST['phone']) ? $_POST['phone'] : '');
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $ip = $_SERVER['REMOTE_ADDR'];
    
    // SQL query to insert data
    $sql = "INSERT INTO contact_form_submissions (name, email, phone, subject, message, ip_address) 
            VALUES ('$name', '$email', '$phone', '$subject', '$message', '$ip')";
    
    // Execute query and check if successful
    if ($conn->query($sql) === TRUE) {
        // Redirect back to contact page with success message
        header("Location: contact.php?status=success");
    } else {
        // Log the error
        error_log("Database insert error: " . $conn->error);
        
        // Redirect back to contact page with error message
        header("Location: contact.php?status=error&message=insert");
    }
    
    // Close the database connection
    $conn->close();
    exit;
}

// If accessed directly without POST data, redirect to contact page
header("Location: contact.php");
exit;
?>
