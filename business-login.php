
<?php
session_start();
$pageTitle = "Business Login";
$error = "";

// Check if already logged in
if (isset($_SESSION['business_id'])) {
    header("Location: business-dashboard.php");
    exit();
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $host = "localhost";
    $username = "root"; 
    $password = ""; 
    $database = "localfinder";

    $conn = mysqli_connect($host, $username, $password, $database);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    
    // Get business from database
    $query = "SELECT * FROM businesses WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) == 1) {
        $business = mysqli_fetch_assoc($result);
        
        // Verify password
        if (password_verify($password, $business['password'])) {
            // Check if approved
            if ($business['status'] == 'approved') {
                // Login successful
                $_SESSION['business_id'] = $business['id'];
                $_SESSION['business_email'] = $business['email'];
                $_SESSION['business_name'] = $business['business_name'];
                
                header("Location: business-dashboard.php");
                exit();
            } else if ($business['status'] == 'pending') {
                $error = "Your business account is pending approval. Please check back later.";
            } else {
                $error = "Your business registration has been rejected.";
            }
        } else {
            $error = "Invalid email or password";
        }
    } else {
        $error = "Invalid email or password";
    }
    
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?> - LocalFinder</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'finder-blue': '#3B82F6',
                        'finder-lightBlue': '#60A5FA',
                        'finder-dark': '#1F2937',
                        'finder-gray': '#6B7280',
                        'finder-teal': '#14B8A6',
                    }
                }
            }
        }
    </script>
    <link href="https://unpkg.com/lucide-icons/dist/umd/lucide.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <?php include 'header.php'; ?>
    
    <main class="flex-grow pt-20">
        <div class="max-w-md mx-auto px-4 py-10">
            <h1 class="text-3xl font-bold text-finder-dark text-center mb-8">Business Login</h1>
            
            <?php if (!empty($error)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6" role="alert">
                    <p><?php echo $error; ?></p>
                </div>
            <?php endif; ?>
            
            <div class="bg-white shadow-md rounded-lg p-6">
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="space-y-6">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input type="email" id="email" name="email" required 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-finder-blue focus:border-finder-blue"
                               value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                    </div>
                    
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input type="password" id="password" name="password" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-finder-blue focus:border-finder-blue">
                    </div>
                    
                    <div>
                        <button type="submit" class="w-full bg-finder-blue hover:bg-finder-lightBlue text-white font-medium py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-finder-blue">
                            Login
                        </button>
                    </div>
                </form>
                
                <div class="mt-4 text-center">
                    <p class="text-sm text-gray-600">
                        Don't have an account yet? <a href="register-business.php" class="text-finder-blue hover:underline">Register your business</a>
                    </p>
                </div>
            </div>
        </div>
    </main>
    
    <?php include 'footer.php'; ?>
    
    <script>
        // Initialize Lucide icons
        lucide.createIcons();
    </script>
</body>
</html>
