
<?php
session_start();
$pageTitle = "Admin Login";
$error = "";

// Check if already logged in
if (isset($_SESSION['admin_id'])) {
    header("Location: admin-dashboard.php");
    exit();
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Hard-coded admin credentials (in a real app, this should be from database with proper hashing)
    if ($email == "admin@example.com" && $password == "password123") {
        // Login successful
        $_SESSION['admin_id'] = 1;
        $_SESSION['admin_email'] = $email;
        $_SESSION['admin_name'] = "Administrator";
        
        header("Location: admin-dashboard.php");
        exit();
    } else {
        $error = "Invalid email or password";
    }
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
            <h1 class="text-3xl font-bold text-finder-dark text-center mb-8">Admin Login</h1>
            
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
                
                <!-- <div class="mt-4 border-t border-gray-200 pt-4">
                    <p class="text-sm text-gray-600">
                        <strong>Default Admin Credentials:</strong><br>
                        Email: admin@example.com<br>
                        Password: password123
                    </p>
                </div> -->
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
